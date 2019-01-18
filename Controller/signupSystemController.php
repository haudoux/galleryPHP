<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/signupSystem.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

class signupSystemController
{
    private $header;
    private $footer;
    private $signSys;
    public function __construct()
    {
        $this->signSys  = new signupSystem();
        $this->header   = new HeaderController();
        $this->footer   = new FooterController();
    }
    public function renderTemplate($username, $email, $password, $passwordRepeat, $package)
    {
        $check = $this->signSys->signup($username, $email, $password, $passwordRepeat, $package);
        header("Location: signup.php?error=".$check);
    }
    private function renderBody()
    {
    }
}
