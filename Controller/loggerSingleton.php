<?php
require("/var/www/html/pattern/Controller/levelLogger.php");
final class loggerSingleton
{
    private static $instances= null;
    private static $levelMin;
    private static $runBy;
    private static $logFile = "/var/www/html/pattern/log.txt";
    

    private function __construct()
    {
        $filename = "/var/www/html/pattern/config.cfg";
        static::$levelMin = file_get_contents($filename);
        static::checkSession();
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance()
    {
        $subclass = static::class;
        if (static::$instances === null) {
            static::$instances = new loggerSingleton();
        }

        return static::$instances;
    }

    public static function writeLog($newLog, $lvl)
    {
        static::checkSession();
        $date = date("D d-M-Y H:i:s");
        $level = "ERROR";
        if ($lvl >= static::$levelMin) {
            $handle = fopen(static::$logFile, 'a+');
            if (!$handle) {
                exit();
            }
            if (levelLogger::INFO === $lvl) {
                $level = "INFO";
            } elseif (levelLogger::DEBUG === $lvl) {
                $level = "DEBUG";
            } elseif (levelLogger::WARNING === $lvl) {
                $level = "WARNING";
            } elseif (levelLogger::ERROR === $lvl) {
                $level = "ERROR";
            } else {
                $level = "ERROR";
            }

            $logToWrite = $level." ".$date." ".$newLog.", run by user : ".static::$runBy."<br />\n";
            if (fwrite($handle, $logToWrite) === false) {
                exit();
            }
            fclose($handle);
        }
    }
    private function checkSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            static::$runBy = "Anonymous";
        } else {
            static::$runBy = $_SESSION['userId'];
        }
    }
}
