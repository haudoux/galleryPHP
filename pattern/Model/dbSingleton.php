<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");

final class dbSingleton
{
    private static $instances   = null;
    
    private static $host        = "localhost";
    private static $user        = "php";
    private static $psw         = "php";
    private static $db          = "template";
    private static $connect;

    private function __construct()
    {
        static::$connect = new mysqli(static::$host, static::$user, static::$psw, static::$db);
        if (static::$connect->connect_errno) {
            $toLog = "Connect failed: ".static::$connect->connect_error;
            loggerSingleton::getInstance()->writeLog($toLog, levelLogger::ERROR);
            exit();
        } else {
            loggerSingleton::getInstance()->writeLog("Connect to SQL successful ", levelLogger::INFO);
        }
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function closeDb()
    {
        static::$connect->close();
    }
    public static function getInstance(): dbSingleton
    {
        if (!static::$instances) {
            static::$instances = new dbSingleton();
        }

        return static::$instances;
    }

    public function getConnection()
    {
        return static::$connect;
    }

    public function selectSQL($query, $param = 0)
    {
        $parameters = 0;
        if($param !== 0){
            $parameters = array_values($param);
        }
        loggerSingleton::getInstance()->writeLog("Query to execute : ".$query, levelLogger::INFO);
        loggerSingleton::getInstance()->writeLog("Parameters : ".implode(" ", $parameters), levelLogger::INFO);
        loggerSingleton::getInstance()->writeLog("Parameters : ".print_r($parameters,true), levelLogger::INFO);

        $data = [];

        $stmt = static::$connect->prepare($query);
        if ($parameters > 0) {
            $parametersType = "";
            foreach ($parameters as $oneParameter) {
                $type = gettype($oneParameter);
                if (strcmp($type, "integer") == 0) {
                    $parametersType .= "i";
                } elseif (strcmp($type, "string") == 0) {
                    $parametersType .= "s";
                } elseif (strcmp($type, "float") == 0) {
                    $parametersType .= "d";
                }
            }
            
            $stmt->bind_param($parametersType, ...$parameters);
        }
        if (!$stmt->execute()) {
            loggerSingleton::getInstance()->writeLog("QUERY FAIL : ".$query, levelLogger::ERROR);
            loggerSingleton::getInstance()->writeLog("ERROR : ".$stmt->error, levelLogger::ERROR);
            return false;
        }
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $keys = array_keys($row);
            foreach ($keys as $aKey) {
                $data[$aKey][] = $row[$aKey];
            }
        }
        $stmt->close();
        return $data;
    }

    public function execSQL($query, $parameters = 0)
    {
        loggerSingleton::getInstance()->writeLog("Query to execute : ".$query, levelLogger::INFO);
        $data = [];

        $stmt = static::$connect->prepare($query);
        if ($parameters > 0) {
            $parametersType = "";
            foreach ($parameters as $oneParameter) {
                $type = gettype($oneParameter);
                if (strcmp($type, "integer") == 0) {
                    $parametersType .= "i";
                } elseif (strcmp($type, "string") == 0) {
                    $parametersType .= "s";
                } elseif (strcmp($type, "float") == 0) {
                    $parametersType .= "d";
                } else {
                    $parametersType .= "s";
                }
            }
            $stmt->bind_param($parametersType, ...$parameters);
        }
        if ($stmt->execute() === false) {
            loggerSingleton::getInstance()->writeLog("QUERY FAIL : ".$query, levelLogger::ERROR);
            loggerSingleton::getInstance()->writeLog("ERROR : ".$stmt->error, levelLogger::ERROR);
            return false;
        }
        $stmt->close();
        return true;
    }
}
