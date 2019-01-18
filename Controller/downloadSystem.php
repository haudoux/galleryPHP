<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");

class downloadSystem
{
    private $gallery;
    private $path;
    private $fullPath;

    public function __construct()
    {
        $this->gallery      = new Gallery();
        $this->path         = '/var/www/html/pattern/View/ressources/imagesUpload/';
    }
    public function download($id, $sepia, $blurRadius, $blurSigma, $width, $height, $original)
    {
        loggerSingleton::getInstance()->writeLog("Start download", levelLogger::INFO);
        loggerSingleton::getInstance()->writeLog("original".$original, levelLogger::INFO);
        $temp           = tmpfile();
        $pic            = $this->getPicture($id);
        $this->fullPath = $this->path.$pic->getPath();
        $toSend         = $this->fullPath;

        if (strcmp($original, "on") !== 0) {
            $toSend = stream_get_meta_data($temp)['uri'];
            $this->sepiaToneImage($sepia, stream_get_meta_data($temp)['uri']);
            $this->radialBlurImage($blurRadius, stream_get_meta_data($temp)['uri']);
            $this->resizeImage($width, $height, stream_get_meta_data($temp)['uri']);
        }
        
        loggerSingleton::getInstance()->writeLog("Start sending file", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog("Sending header", levelLogger::DEBUG);
        header('Content-type: application/jpeg');
        header('Content-Disposition: attachment; filename="'.stream_get_meta_data($temp)['uri'].'.jpg"');
        loggerSingleton::getInstance()->writeLog("Start reading file", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog("Path : ".stream_get_meta_data($temp)['uri'], levelLogger::DEBUG);
        readfile($toSend);
    }
    private function getPicture($id)
    {
        $this->gallery->loadPictureFromDb();
        return $this->gallery->getOnePicture($id);
    }
    private function sepiaToneImage($sepia, $path)
    {
        $imagick = new Imagick(realpath($this->fullPath));
        $imagick->setFormat("jpg");
        $imagick->sepiaToneImage($sepia);

        $this->writeImage($imagick, $path, "sepia");
    }
    private function radialBlurImage($blurRadius, $path)
    {
        $imagick = new Imagick($path);
        $imagick->setFormat("jpg");
        $imagick->radialBlurImage($blurRadius);
        
        $this->writeImage($imagick, $path, "radial blur");
    }
    private function resizeImage($width = 0, $height = 0, $path)
    {
        loggerSingleton::getInstance()->writeLog("Width ".$widht." height : ".$height, levelLogger::DEBUG);

        $imagick = new Imagick($path);
        $imagick->setFormat("jpg");
        $imagick->adaptiveResizeImage($width, $height);

        $this->writeImage($imagick, $path, "resize");
    }
    private function writeImage($imagick, $path, $func)
    {
        if (!$imagick->writeImage($path)) {
            loggerSingleton::getInstance()->writeLog("Write image fail ".$func, levelLogger::DEBUG);
        } else {
            loggerSingleton::getInstance()->writeLog("Write image success ".$func, levelLogger::DEBUG);
        }
        $imagick->destroy();
    }
}
