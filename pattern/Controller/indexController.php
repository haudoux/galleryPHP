<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

class indexController
{
    private $page;
    private $nbImagePerPage;
    private $gallery;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->page             = 0;
        $this->nbImagePerPage   = 10;
        $this->gallery          = new Gallery();
        $this->header           = new HeaderController();
        $this->footer           = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->setStylesheet("gallery.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderTemplateNext()
    {
        $this->page += 1;
        return $this->renderTemplate();
    }
    public function renderTemplatePrevious()
    {
        if ($this->page > 0) {
            $this->page -= 1;
        }
        return $this->renderTemplate();
    }
    private function renderBody()
    {
        $html = "";
        $this->getGallery();
        foreach ($this->gallery->getList() as $pic) {
            loggerSingleton::getInstance()->writeLog("Rendering image ".$pic->getTitle(), levelLogger::DEBUG);
            $html .= '        
            <div class="gallery">
            <a target="../ressources/imagesUpload/'.$pic->getPath().'" href="../ressources/imagesUpload/'.$pic->getPath().'">
                <img src="../ressources/imagesUpload/'.$pic->getPath().'" width="800" height="600">
            </a>
                <p>Author      : '.$pic->getOwner().'</p>
                <p>Name        : '.$pic->getTitle().'</p>
                <p>Description : '.$pic->getDescription().'</p>
                <p>Upload date : '.$pic->getCreationDate().'</p>
                <form action="download.php" method="post">
                    <input type="hidden" name="id" value="'.$pic->getId().'" />
                    <input type="submit" name="submit" value="Download" />
                </form>
            </div>';
        }
        $html .= '
                <form action="index.php" method="post">
                    <button type="submit" name="next">      Next</button>
                    <button type="submit" name="previous">  Previous</button>
                </form>';
        return $html;
    }
    private function getGallery()
    {
        loggerSingleton::getInstance()->writeLog("Start loading picture", levelLogger::DEBUG);
        $this->gallery->loadPictureFromDb($this->nbImagePerPage, $this->page);
    }
}
