<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/loginSystem/loginSystemProxy.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");

class loginSystemController
{
    private $header;
    private $footer;
    private $logSys;
    public function __construct()
    {
        $this->logSys  = new proxyLogin();
        $this->header  = new HeaderController();
        $this->footer  = new FooterController();
    }
    public function renderTemplate($username, $password)
    {
        $check = $this->login($username, $password);
        header("Location: login.php?error=".$check);
    }
    private function renderBody()
    {
    }
    private function login($username, $password)
    {
        $html = "";
        $check = $this->logSys->logUser($username, $password);
        return $check;
    }
}
