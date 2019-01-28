<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");


class signupController
{
    private $header;
    private $footer;
    private $packageList;

    public function __construct()
    {
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
        $this->packageList  = PackageList::getInstance();
    }
    public function renderTemplate()
    {
        $this->isLog();
        $this->header->setStylesheet("login.css");
        $html  = $this->header->renderTemplate();
        $html .= self::renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBody()
    {
        $this->getPackage();
        $packageList = $this->packageList->getList();
        $html = '
                <form class="box" action="../../View/template/signupWait.php" method="POST">
                    <h1>Login</h1>'
                    .$this->getError().'
                    <input type="text"      name ="username"        placeholder="Username" required>
                    <input type="email"     name ="email"           placeholder="Email" required>
                    <input type="password"  name ="pwd"             placeholder="Password" required>
                    <input type="password"  name ="pwd-repeat"      placeholder="Repeat password" required>
                    <select name="package">';
        loggerSingleton::getInstance()->writeLog("Package list", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r($packageList, true), levelLogger::DEBUG);


        foreach ($packageList as $pack) {
            loggerSingleton::getInstance()->writeLog("package : ", levelLogger::DEBUG);
            loggerSingleton::getInstance()->writeLog(print_r($pack, true), levelLogger::DEBUG);
            $html .= '<option value='.$pack->getId();
            $html .= '>'.$pack->getName().'</option>';
        }
                        
        $html .= '
                    </select>
                    <input type="submit"    name ="signup-submit"   value="Login">
                </form>';
        return $html;
    }
    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package", levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function getError()
    {
        $html = "";
        if (isset($_GET['error'])) {
            if (strcmp($_GET['error'], "emptyfields") == 0) {
                echo '<p class="signerror">Fill all fields</p>';
            } elseif (strcmp($_GET['error'], "invalidemail") == 0) {
                echo '<p class="signerror">Fill email field</p>';
            } elseif (strcmp($_GET['error'], "invalidemailanduid") == 0) {
                echo '<p class="signerror">Fill username and email fields</p>';
            } elseif (strcmp($_GET['error'], "invalidusername") == 0) {
                echo '<p class="signerror">Fill username field</p>';
            } elseif (strcmp($_GET['error'], "passwordCheck") == 0) {
                echo '<p class="signerror">Password not equal</p>';
            } elseif (strcmp($_GET['error'], "usernametaken") == 0) {
                echo '<p class="signerror">Username already taken</p>';
            } elseif (strcmp($_GET['error'], "sqlerror") == 0) {
                echo '<p class="signerror">Server error, try later</p>';
            } elseif (strcmp($_GET['error'], "success") == 0) {
                echo '<p class="signupsuccess">Sign up successful</p>';
            } elseif (strcmp($_GET['error'], "success") != 0) {
                echo '<p class="signupsuccess">Unknown error</p>';
            }
        }
    }
    private function isLog()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header('Location: index.php');
        }
    }
}
