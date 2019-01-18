<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/userList.php");
require_once("/var/www/html/pattern/Model/roleList.php");


loggerSingleton::getInstance()->writeLog("New client index", levelLogger::INFO);

class administrationController
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
        $this->roleList     = RoleList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity();
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
                    <a href="adminUsers.php" class="link">
                        <li class="item i1">
                            <i><ion-icon name="people" size="large"></ion-icon></i>
                            <span>Users</span>
                        </li>
                    </a>
                    <a href="adminGallery.php" class="link">
                        <li class="item i2">
                            <i><ion-icon name="images" size="large"></ion-icon></i>
                            <span>Gallery</span>
                        </li>
                    </a>
                    <a href="adminRoles.php" class="link">
                        <li class="item i3">
                            <i><ion-icon name="construct" size="large"></ion-icon></i>
                            <span>Roles</span>
                        </li>
                    </a>
                </div>
                <div class="l2">
                    <a href="adminLogs.php" class="link">
                        <li class="item i6">
                            <i><ion-icon name="analytics" size="large"></ion-icon></i>
                            <span>Logs</span>
                        </li>
                    </a>
                    <a href="adminPackages.php" class="link">
                        <li class="item i4">
                            <i><ion-icon name="gift" size="large"></ion-icon></i>
                            <span>Packages</span>
                        </li>
                    </a>
                    <a href="adminStats.php" class="link">
                        <li class="item i5">
                            <i><ion-icon name="stats" size="large"></ion-icon></i>
                            <span>Statistics</span>
                        </li>
                    </a>

                </div>
            </div>
        <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>';
        return $html;
    }
    private function getRole()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Role", levelLogger::DEBUG);
        $this->roleList->loadRoleFromDb();
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

    private function renderRole()
    {
        $html = "";
        $this->getRole();
        foreach ($this->roleList->getList() as $role) {
            loggerSingleton::getInstance()->writeLog(print_r($role->getName(), true), levelLogger::DEBUG);

            loggerSingleton::getInstance()->writeLog("Rendering role ".$role->getName(), levelLogger::DEBUG);
            $html .= '<p>Name : '.$role->getName().'</p>';
        }
        return $html;
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
