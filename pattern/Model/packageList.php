<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("dbSingleton.php");
require_once("package.php");

class PackageList
{
    private static $listPackage;
    private static $instances   = null;

    private function __construct()
    {
        static::$listPackage = [];
    }
    public static function getInstance(): PackageList
    {
        if (!static::$instances) {
            static::$instances = new PackageList();
        }

        return static::$instances;
    }

    public function getConnection()
    {
        return static::$listPackage;
    }
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public function getList()
    {
        return static::$listPackage;
    }
    public function loadPackageFromDb()
    {
        static::cleanList();
        loggerSingleton::getInstance()->writeLog("Start loading package from db", levelLogger::DEBUG);
        $packages = dbSingleton::getInstance()->selectSQL("SELECT id_package, nom_package, price_package, size_upload_limit_package, daily_upload_package, nb_maximum_upload_package, creation_date_package, modification_date_package FROM package");
        $fields = array_keys($packages);
        $sizeArray = count($packages[$fields[0]]);
        
        for ($aPackage = 0; $aPackage < $sizeArray; $aPackage += 1) {
            $dataOnePic = array();
            foreach ($fields as $aField) {
                $dataOnePic[] = $packages[$aField][$aPackage];
            }
            $package = new Package(...$dataOnePic);
            static::addPackage($package);
        }
        loggerSingleton::getInstance()->writeLog("Loading finish package", levelLogger::DEBUG);
    }
    private function addPackage(Package $pack)
    {
        static::$listPackage[$pack->getId()] = $pack;
    }
    public function addNewPackage($name, $price, $uploadLimit, $dailyUpload, $maximumUpload)
    {
        loggerSingleton::getInstance()->writeLog("Add new package", levelLogger::INFO);
        dbSingleton::getInstance()->execSQL('INSERT INTO package (nom_package, price_package, upload_limit_package,daily_upload_package,nb_maximum_upload_package) VALUES (?,?,?,?,?)', array($name, $price, $uploadLimit,$dailyUpload,$maximumUpload));
        $package    = dbSingleton::getInstance()->selectSQL("SELECT id_package, creation_date_package, modification_date_package FROM package WHERE nom_package = ? AND upload_limit_package = ? AND daily_upload_package = ? AND nb_maximum_upload_package = ?", array($name,$uploadLimit,$dailyUpload,$maximumUpload));
        $pack       = new package($package['id_package'], $name, $uploadLimit, $dailyUpload, $maximumUpload, $package['creation_date_package'], $package['modification_date_package']);

        static::addPackage($pack);
    }
    public function getOnePackage($id)
    {
        return static::$listPackage[$id];
    }
    public function cleanList()
    {
        static::$listPackage = array();
    }
}
