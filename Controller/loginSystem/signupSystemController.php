<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/loginSystem/signupSystem.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");

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
