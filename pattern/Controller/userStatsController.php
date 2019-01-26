<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/userList.php");


class userStatsController
{
    private $header;
    private $footer;
    private $userList;

    public function __construct()
    {
        $this->userList     = UserList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        session_start();
        $this->header->setStylesheet("stats.css");
        $html  = $this->header->renderTemplate();
        $html .= self::renderBody($_SESSION['userId']);
        $html .= $this->footer->renderTemplate();
        return $html;
    }

    private function renderBody($id)
    {
        $user = $this->getUser($id);
        $html = '
                <h1>Statistique</h1>
                <li>
                    <h3>Upload in kb</h3>
                    <p>'.$this->user->getUploadKb().' kb</p>
                </li>
                <li>
                    <h3>Upload in nb</h3>
                    <p>'.$this->user->getUploadnb().' nb</p>
                </li>';
        return $html;
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::INFO);
        $this->userList->loadUserFromDb();
        $this->user = $this->userList->getOneUser($_SESSION['userId']);
    }
}
