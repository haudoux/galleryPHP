<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");

class HeaderController
{
    private $stylesheet;
    private $enable;
    private $securityLevel;
    private $admin = 2;

    public function __construct()
    {
        $this->stylesheet     = "gallery.css";
        $this->enable         = false;
        $this->securityLevel  = 3;
    }
    public function renderTemplate()
    {
        $html  = $this->renderHeader();
        return $html;
    }
    private function renderHeader()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $isAdmin = $_SESSION['role'] == 2;
        if ($this->enable && !(isset($_SESSION["userId"]) && ($_SESSION['role'] == $this->securityLevel || $isAdmin))) {
            loggerSingleton::getInstance()->writeLog("Redirect no right/connected", levelLogger::INFO);
            header('Location: index.php');
            exit();
        } else {
            loggerSingleton::getInstance()->writeLog("Rendering Footer", levelLogger::DEBUG);
            $log = "";
            if (!isset($_SESSION["userId"])) {
                $log = '<a href="login.php">Log in</a>
                        <a href="signup.php">Sign up</a>';
            } elseif (isset($_SESSION["userId"]) && ($_SESSION['role'] == $this->admin)) {
                $log = '<a href="administration.php">Administration</a>
                        <a href="../../Controller/logoutController.php">Log out</a>';
            } elseif (isset($_SESSION["userId"]) && ($_SESSION['role'] == $this->securityLevel)) {
                $log = '<a href="profil.php">Profil</a>
                        <a href="../../Controller/logoutController.php">Log out</a>';
            } else {
                $log = '<a href="../../Controller/logoutController.php">Log out</a>';
            }
            echo '
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <title>Gallery</title>
                        <link rel="stylesheet" href="../css/header.css">
                        <link rel="stylesheet" href="../css/'.$this->stylesheet.'">
                        <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>
                    </head>
                    <body>
                        <div class="header">
                            <h2 class="logo">Gallery</h2>
    
                            <ul class="menu">
                                <div class="search-box">
                                    <form action="search.php" method="post">
                                        <input class="search-txt" type="text" name ="search" placeholder="Type to search">
                                        <button class="search-btn" type="submit" name="search-submit" value="someValue"><ion-icon name="search"></ion-icon></button>
                                    </form>
                                </div>
                                <a href="index.php">Home</a>
                                <a href="pricing.php">Pricing</a>'.$log.
                                '
                                <a href="upload.php">Upload</a>
                            </ul>
                        </div>';
        }
    }
    public function setStylesheet($name)
    {
        $this->stylesheet = $name;
    }
    public function enableSecurity($securityLevel = 2)
    {
        $this->enable           = true;
        $this->securityLevel    = $securityLevel;
    }
}
