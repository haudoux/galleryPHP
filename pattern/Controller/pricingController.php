<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/userList.php");

class pricingController
{
    private $packageList;
    private $user;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->packageList  = PackageList::getInstance();
        $this->user         = null;
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->setStylesheet("pricing.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function setPackage($id)
    {
        $this->getPackage();
        session_start();
        loggerSingleton::getInstance()->writeLog(print_r("User : ".$_SESSION['userId']." Package id : ".$id, true), levelLogger::DEBUG);
        if (isset($_SESSION['userId'])) {
            $this->getOneUser($_SESSION['userId']);
            if ($this->user !== null) {
                $this->user->setPackageId($id);
            }
            loggerSingleton::getInstance()->writeLog(print_r("User not existing", true), levelLogger::DEBUG);
            return $this->renderTemplate();
        } else {
            return $this->renderTemplate();
        }
    }
    private function renderBody()
    {
        $this->getPackage();
        $html = '<div class="pricing-table">';
        //loggerSingleton::getInstance()->writeLog(print_r($this->packageList->getList(),true),levelLogger::DEBUG);
        foreach ($this->packageList->getList() as $pack) {
            //<div class="pop">Popular</div>
            $html .= '
            <div class="col">
            <form action="pricing.php" method="POST">
                    <input type="hidden" name="id" value='.$pack->getId().'>
                <div class="table">
                    <h2>'.$pack->getName().'</h2>
                    <div class="price">'.$pack->getPrice().' €</div>
                        <span>Per Month</span>
                        <ul>
                            <li><strong>'.$pack->getSizeUploadLimit().'</strong> Upload limit</li>
                            <li><strong>'.$pack->getDailyUpload().'</strong> Daily upload</li>
                            <li><strong>'.$pack->getMaximumUpload().'</strong> Maximum upload</li>
                        </ul>
                        <input type="submit" name="buy" value="Buy Now !">
                    </div>
                </div>
            </form>
            ';
        }
        return $html;
    }
    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package", levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function getOneUser($id)
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::DEBUG);
        $userList = UserList::getInstance();
        $userList->loadUserFromDb();
        $this->user = $userList->getOneUser($id);
    }
}
