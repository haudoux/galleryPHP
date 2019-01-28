<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("dbSingleton.php");
require_once("user.php");

class UserList
{
    private static $listUser;
    private static $instances   = null;

    private function __construct()
    {
        static::$listUser = [];
    }
    public static function getInstance(): UserList
    {
        if (!static::$instances) {
            static::$instances = new UserList();
        }

        return static::$instances;
    }

    public function getConnection()
    {
        return static::$listUser;
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
    public function loadUserFromDb()
    {
        static::cleanList();
        loggerSingleton::getInstance()->writeLog("Start loading user from db", levelLogger::DEBUG);
        $Users = dbSingleton::getInstance()->selectSQL("SELECT id_user, fk_package_id, package.nom_package, role.name, uid_user, email_user, creation_date_user, modification_date_user, upload_kb_consumption, upload_nb_consumption FROM user INNER JOIN package ON fk_package_id = package.id_package INNER JOIN role ON fk_role_id = role.id_role");
        $fields = array_keys($Users);
        $sizeArray = count($Users[$fields[0]]);
        
        for ($aUser = 0; $aUser < $sizeArray; $aUser += 1) {
            $dataOnePic = array();
            foreach ($fields as $aField) {
                $dataOnePic[] = $Users[$aField][$aUser];
            }
            $user = new User(...$dataOnePic);
            static::adduser($user);
        }
        
        loggerSingleton::getInstance()->writeLog("Loading finish user", levelLogger::DEBUG);
    }
    public function addUser(user $user)
    {
        loggerSingleton::getInstance()->writeLog("Id :".$user->getId(), levelLogger::DEBUG);
        static::$listUser[$user->getId()] = $user;
    }
    public function removeFirstUser()
    {
        if (array_shift(static::$listUser) !== null) {
            return true;
        }
        return false;
    }
    public function removeLastUser()
    {
        static::$listUser = array_pop(static::$listUser);
    }
    public function cleanList()
    {
        static::$listUser = array();
    }
    public function getList()
    {
        return static::$listUser;
    }
    public function getOneUser($id)
    {
        loggerSingleton::getInstance()->writeLog(print_r("getOneUser", true), levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r(static::$listUser[$id], true), levelLogger::DEBUG);
        if (isset(static::$listUser[$id])) {
            return static::$listUser[$id];
        } else {
            return null;
        }
    }
}
