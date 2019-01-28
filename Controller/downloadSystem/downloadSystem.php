<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/sepiaDecorator.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/blurDecorator.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/resizeDecorator.php");

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
    public function download($id, $sepiaEnable, $sepia, $blurEnable, $blurRadius, $resizeEnable, $percent, $original)
    {
        loggerSingleton::getInstance()->writeLog("Start download", levelLogger::INFO);
        loggerSingleton::getInstance()->writeLog("original".$original, levelLogger::INFO);
        $temp           = tmpfile();
        $pic            = $this->getPicture($id);
        $this->fullPath = $this->path.$pic->getPath();
        $toSend         = $this->fullPath;

        if (strcmp($original, "on") !== 0) {
            $toSend             = stream_get_meta_data($temp)['uri'];
            if (strcmp($sepiaEnable, "on") !== 0) {
                $pictureDecorator   = new sepiaDecorator($this->fullPath);
                $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $sepia);
            }
            if (strcmp($blurEnable, "on") !== 0) {
                $pictureDecorator   = new blurDecorator($this->fullPath);
                $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $blurRadius);
            }
            if (strcmp($resizeEnable, "on") !== 0) {
                $pictureDecorator   = new resizeDecorator($this->fullPath);
                $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $percent);
            }
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
