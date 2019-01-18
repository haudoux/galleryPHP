<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/userList.php");


class uploadSystem
{
    private $path;
    private $allowed;
    private $maxSize;
    private $packageList;
    private $userList;


    public function __construct()
    {
        $this->allowed = array("jpg", "jpeg", "png");
        $this->maxSize = 60000000;
        $this->path    = "../ressources/imagesUpload/";
        $this->packageList  = PackageList::getInstance();
        $this->userList     = UserList::getInstance();
    }
    public function startUpload($file, $imageTitle, $imageDesc)
    {
        session_start();
        $newFileName = $imageTitle;
        if (empty($imageTitle)) {
            $newFileName = "gallery";
        } else {
            $newFileName = strtolower(str_replace(' ', '-', $newFileName));
        }
        $filename    = $file['name'];
        $filetype    = $file['type'];
        $fileTmpName = $file['tmp_name'];
        $fileError   = $file['error'];
        $fileSize    = $file['size'];

        //Get extension
        $fileExt = explode(".", $filename);
        $fileActualExt = strtolower(end($fileExt));

        if (in_array($fileActualExt, $this->allowed)) {
            if ($fileError === 0) {
                if ($fileSize < $this->maxSize) {
                    $imageFullName   = $newFileName.".".uniqid("", true).".".$fileActualExt;
                    $fileDestination = $this->path.$imageFullName;
                    if (empty($imageTitle) || empty($imageDesc)) {
                        return "empty";
                    } else {
                        $error = $this->checkPackage($fileSize);
                        if ($error === false) {
                            dbSingleton::getInstance()->execSQL("INSERT INTO gallery (title_gallery, description_gallery, img_full_name_gallery, fk_id_user) VALUES (?,?,?,?);", array($imageTitle, $imageDesc, $imageFullName, $_SESSION['userId']));
                            $move = move_uploaded_file($fileTmpName, $fileDestination);
                            if (!$move) {
                                return "moverror";
                            }
                            dbSingleton::getInstance()->execSQL("UPDATE user SET upload_nb_consumption = upload_nb_consumption + 1 , upload_kb_consumption = upload_kb_consumption + ? WHERE id_user = ?;", array($fileSize,$_SESSION['userId']));
                            return "success";
                        } else {
                            return $error;
                        }
                    }
                } else {
                    return "sizelimit";
                    exit();
                }
            } else {
                return "uploadError";
            }
        } else {
            return "extension";
            exit();
        }
    }

    private function checkPackage($fileSize)
    {
        $this->getPackage();
        $this->getUser();

        $user           = $this->userList->getOneUser($_SESSION['userId']);
        $userKb         = $user->getUploadKb();
        $userNb         = $user->getUploadNb();
        $packId         = $user->getPackageId();

        $pack           = $this->packageList->getOnePackage($packId);
        $packSizeLimit  = $pack->getSizeUploadLimit();
        $packMaxUpload  = $pack->getMaximumUpload();

        if ($fileSize > $packSizeLimit) {
            loggerSingleton::getInstance()->writeLog("Size : ".$fileSize." Pack limit : ".$packSizeLimit, levelLogger::DEBUG);
            return "maxsize";
        } elseif ($userNb >= $packMaxUpload) {
            loggerSingleton::getInstance()->writeLog("UserNb : ".$userNb." Pack limit : ".$packMaxUpload, levelLogger::DEBUG);
            return "maxupload";
        }
        return false;
    }

    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package, run by : ".$_SESSION['userId'], levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User, run by : ".$_SESSION['userId'], levelLogger::DEBUG);
        $this->userList->loadUserFromDb();
    }
}
