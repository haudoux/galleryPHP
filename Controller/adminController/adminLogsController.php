<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

class adminLogsController
{
    private $header;
    private $footer;


    public function __construct()
    {
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity();
        $this->header->setStylesheet("../css/adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= self::renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }

    private function renderBody()
    {
        $html = $this->readLogs();
        return $html;
    }
    private function readLogs()
    {
        $filename = "/var/www/html/pattern/log.txt";
        
        return file_get_contents($filename);
    }
}
