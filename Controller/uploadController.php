<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");
require_once("/var/www/html/pattern/Controller/uploadSystem.php");

class uploadController
{
    private $uploadSys;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->uploadSys    = new uploadSystem();
        $this->gallery      = new Gallery();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("upload.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function uploadPicture($file, $imageTitle, $imageDesc)
    {
        loggerSingleton::getInstance()->writeLog(print_r($file, true), levelLogger::DEBUG);
        $success = $this->uploadSys->startUpload($file, $imageTitle, $imageDesc);
        header("Location: upload.php?error=".$success);
    }
    private function renderBody()
    {
        echo '
        <div class="gallery-upload">
            <form class="box" action="upload.php" method="post" enctype="multipart/form-data">
                <h1>Upload</h1>'.
                $this->getError().'
                <input type="text" name="filetitle" placeholder="Image title">
                <input type="text" name="filedesc" placeholder="Image description">
                <input type="file" name="file">
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>';
    }
    private function getError()
    {
        $html = "";
        if (isset($_GET['error'])) {
            if (strcmp($_GET['error'], "success") == 0) {
                $html .= '<p class="signerror">Upload success</p>';
            } elseif (strcmp($_GET['error'], "sizelimit") == 0) {
                $html .= '<p class="signerror">Picture too big</p>';
            } elseif (strcmp($_GET['error'], "empty") == 0) {
                $html .= '<p class="signerror">Set a name and description</p>';
            } elseif (strcmp($_GET['error'], "extension") == 0) {
                $html .= '<p class="signerror">Only .jpg .jpeg and .png</p>';
            } elseif (strcmp($_GET['error'], "uploaderror") == 0) {
                $html .= '<p class="signerror">Error, try again</p>';
            } elseif (strcmp($_GET['error'], "maxsize") == 0) {
                $html .= '<p class="signerror">The file is too big</p>';
            } elseif (strcmp($_GET['error'], "maxupload") == 0) {
                $html .= '<p class="signerror">You have reach the limit of upload</p>';
            }
        }
        return $html;
    }
}
