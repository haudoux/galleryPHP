<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");

class loginController
{
    private $header;
    private $footer;

    public function __construct()
    {
        $this->header  = new HeaderController();
        $this->footer  = new FooterController();
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
        $html = '
                    <form class="box" action="../../View/template/loginWait.php" method="POST">
                        <h1>Login</h1>
                        '.$this->getError().'
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="password" placeholder="Password">
                        <input type="submit" name="login-submit" value="Login">
                    </form>';
        return $html;
    }
    private function getError()
    {
        $html = "";
        if (isset($_GET['error'])) {
            if (strcmp($_GET['error'], "emptyfields") == 0) {
                $html .= '<p class="signerror">Fill all fields</p>';
            } elseif (strcmp($_GET['error'], "nouser") == 0) {
                $html .= '<p class="signerror">Check password and username</p>';
            } elseif (strcmp($_GET['error'], "serverror") == 0) {
                $html .= '<p class="signerror">Server error, try later</p>';
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
