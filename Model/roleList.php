<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("dbSingleton.php");
require_once("role.php");

class RoleList
{
    private static $listRole;
    private static $instances   = null;

    private function __construct()
    {
        static::$listRole = [];
    }
    public static function getInstance(): RoleList
    {
        if (!static::$instances) {
            static::$instances = new RoleList();
        }

        return static::$instances;
    }

    public function getConnection()
    {
        return static::$listRole;
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public function loadRoleFromDb()
    {
        loggerSingleton::getInstance()->writeLog("Start loading role from db", levelLogger::DEBUG);
        //modify_description_role, modify_description_all_role, view_stats_role, view_stats_all_role, manage_image, manage_image_all, modify_profil, modify_profil_all, modify_package, modify_package_all, view_action,
        $roles = dbSingleton::getInstance()->selectSQL("SELECT id_role, name, creation_date_role, modification_date_role FROM role");
        $fields = array_keys($roles);
        $sizeArray = count($roles[$fields[0]]);
        
        for ($aRole = 0; $aRole < $sizeArray; $aRole += 1) {
            $dataOnePic = array();
            foreach ($fields as $aField) {
                $dataOnePic[] = $roles[$aField][$aRole];
            }
            $role = new Role(...$dataOnePic);
            static::addRole($role);
        }
        
        loggerSingleton::getInstance()->writeLog("Loading finish role", levelLogger::DEBUG);
    }
    public function addRole(role $role)
    {
        static::$listRole[$role->getId()] = $role;
    }
    public function cleanList()
    {
        static::$listRole = array();
    }
    public function getOneRole($id)
    {
        if (isset(static::$listRole[$id])) {
            return static::$listRole[$id];
        } else {
            return null;
        }
    }
    public function getList()
    {
        return static::$listRole;
    }
}
