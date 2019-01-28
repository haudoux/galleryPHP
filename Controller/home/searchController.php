<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");


require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");

class searchController
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
    public function renderTemplate($search)
    {
        $this->header->setStylesheet("gallery.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBody($search);
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
    private function renderBody($search)
    {
        $html = "";
        $this->getSearch($search);
        $fieldFill = empty($search);
        if ($fieldFill) {
            header("Location: ../gallery.php?error=emptyfields");
            exit();
        }
        $html = $this->createHtmlGallery();
        return $html;
    }
    private function getSearch($search)
    {
        loggerSingleton::getInstance()->writeLog("Start loading picture", levelLogger::DEBUG);
        $this->gallery->searchGallery($search, $this->nbImagePerPage, $this->page);
    }
    private function createHtmlGallery()
    {
        $html = '';
        foreach ($this->gallery->getList() as $pic) {
            loggerSingleton::getInstance()->writeLog("Rendering image ".$pic->getTitle(), levelLogger::DEBUG);
            $html .= '        
            <div class="gallery">
            <a target="../ressources/imagesUpload/'.$pic->getPath().'" href="../ressources/imagesUpload/'.$pic->getPath().'">
                <img src="../ressources/imagesUpload/'.$pic->getPath().'" width="800" height="600">
            </a>
                <p>Author      : '.$pic->getOwner().'</p>
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
}
