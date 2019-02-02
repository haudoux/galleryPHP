<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/downloadSystem/downloadSystem.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");

class downloadController
{
    private $dowSys;
    private $header;
    private $footer;
    private $imagePath;

    public function __construct()
    {
        $this->dowSys       = new downloadSystem();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate($id)
    {
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderModifyPicture($id, $sepiaEnable = "no", $sepia, $blurEnable = "no", $blurRadius, $resizeEnable = "no", $percent = 0)
    {
        $this->dowSys->download($id, $sepiaEnable, $sepia, $blurEnable, $blurRadius, $resizeEnable, $percent);
        return $html;
    }
    private function renderBodyModify($id)
    {
        $html = '
        <form action="download.php" method="post" >
            <input type="hidden" name="id" value="'.$id.'"/>
            Enable      <input type="checkbox"  name="sepiaEnable"/>
            Sepia       <input type="range"     name="sepia" min="0" max="100"/>
            Enable      <input type="checkbox"  name="blurEnable"/>
            Blur radius <input type="range"     name="blurRadius" min="0" max="50"/>
            Enable      <input type="checkbox"  name="resizeEnable"/>
            Resize in % <input type="number"    name="percent" min="0" max="10000"/>
            <input type="submit" name="submit" value="Download"/>
        </form>
            ';
        return $html;
    }
}
