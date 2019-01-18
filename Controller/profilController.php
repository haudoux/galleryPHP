<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/userList.php");


loggerSingleton::getInstance()->writeLog("New client index", levelLogger::INFO);

class profilController
{
    private $gallery;
    private $packageList;
    private $userList;
    private $roleList;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->gallery      = new Gallery();
        $this->packageList  = PackageList::getInstance();
        $this->userList     = UserList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("adminMenu.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBody()
    {
        $html = '
            <div class="metro">
                <div class="l1">
                    <a href="userProfil.php" class="link">
                        <li class="item i1">
                            <i><ion-icon name="person" size="large"></ion-icon></i>
                            <span>Information</span>
                        </li>
                    </a>
                    <a href="userGallery.php" class="link">
                        <li class="item i2">
                            <i><ion-icon name="images" size="large"></ion-icon></i>
                            <span>Gallery</span>
                        </li>
                    </a>
                </div>
                <div class="l2">
                    <a href="userStats.php" class="link">
                        <li class="item i3">
                            <i><ion-icon name="stats" size="large"></ion-icon></i>
                            <span>Statistics</span>
                        </li>
                    </a>
                </div>
            </div>
        <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>';
        return $html;
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::DEBUG);
        $this->userList->loadUserFromDb();
    }
    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package", levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function getGallery()
    {
        loggerSingleton::getInstance()->writeLog("Start loading picture", levelLogger::DEBUG);
        $this->gallery->loadPictureFromDb();
    }

    private function renderUser()
    {
        $html = "";
        $this->getUser();
        foreach ($this->userList->getList() as $user) {
            loggerSingleton::getInstance()->writeLog(print_r($user->getUid(), true), levelLogger::DEBUG);
            loggerSingleton::getInstance()->writeLog("Rendering package ".$user->getUid(), levelLogger::DEBUG);
            $html .= '<p>Name : '.$user->getUid().'</p>';
        }
        return $html;
    }
    private function renderPackage()
    {
        $html = "";
        $this->getPackage();
        foreach ($this->packageList->getList() as $package) {
            loggerSingleton::getInstance()->writeLog(print_r($package->getName(), true), levelLogger::DEBUG);

            loggerSingleton::getInstance()->writeLog("Rendering package ".$package->getName(), levelLogger::DEBUG);
            $html .= '<p>Name : '.$package->getName().'</p>';
        }
        return $html;
    }
    private function renderImage()
    {
        $html = "";
        $this->getGallery();
        foreach ($this->gallery->getList() as $pic) {
            loggerSingleton::getInstance()->writeLog("Rendering image ".$pic->getTitle(), levelLogger::DEBUG);
            $html .= '        
            <div class="gallery">
            <a target="#" href="../ressources/imagesProject/'.$pic->getPath().'.png"></a>
                <img src="../ressources/imagesProject/'.$pic->getPath().'" width="600" height="400">
            </a>
            <p>'.$pic->getDescription().'</p>
            </div>';
        }
        $html .= '
                <button>Previous</button>
                <button>Next</button>';
        return $html;
    }
}
