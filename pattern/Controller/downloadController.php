<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/downloadSystem.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

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

        //$this->dowSys->download($id);
        //header("Location: index.php");
    }
    public function renderModifyPicture($id, $sepia, $blurRadius, $width, $height, $original)
    {
        //$html  = $this->header->renderTemplate();
        //$html .= $this->footer->renderTemplate();
        $this->dowSys->download($id, $sepia, $blurRadius, $width, $height, $original);
        return $html;
        
        //header("Location: index.php");
    }
    private function renderBodyModify($id)
    {
        $html = '
        <form action="download.php" method="post" >
            <input type="hidden" name="id" value="'.$id.'"/>
            Original <input type="checkbox" name="original"/>
            Sepia <input type="range" name="sepia" min="0" max="100"/>
            Blur radius <input type="range" name="blurRadius" min="0" max="50"/>
            Width <input type="number" name="width" min="0" max="10000"/>
            Height <input type="number" name="height" min="0" max="10000"/>
            <input type="submit" name="submit" value="Download"/>
        </form>
            ';
        return $html;
    }
}
