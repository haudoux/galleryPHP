<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/sepiaDecorator.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/blurDecorator.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/resizeDecorator.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/pictureDecorator.php");

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
    public function download($id, $sepiaEnable, $sepia, $blurEnable, $blurRadius, $resizeEnable, $percent)
    {
        loggerSingleton::getInstance()->writeLog("Start download", levelLogger::INFO);
        loggerSingleton::getInstance()->writeLog("id ".$id, levelLogger::DEBUG);
        $temp           = tmpfile();
        $pic            = $this->getPicture($id);
        $this->fullPath = $this->path.$pic->getPath();
        $toSend         = $this->fullPath;
        $pictureDecorator   = new pictureDecorator($this->fullPath);
        $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $sepia);

        if (strcmp($sepiaEnable, "on") === 0) {
            $toSend             = stream_get_meta_data($temp)['uri'];
            $pictureDecorator   = new sepiaDecorator();
            $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $sepia);
        }
        if (strcmp($blurEnable, "on") === 0) {
            $toSend             = stream_get_meta_data($temp)['uri'];
            $pictureDecorator   = new blurDecorator();
            $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $blurRadius);
        }
        if (strcmp($resizeEnable, "on") === 0) {
            $toSend             = stream_get_meta_data($temp)['uri'];
            $pictureDecorator   = new resizeDecorator();
            $pictureDecorator->decorate(stream_get_meta_data($temp)['uri'], $percent);
        }
        
        loggerSingleton::getInstance()->writeLog("Start sending file", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog("Sending header", levelLogger::DEBUG);
        header('Content-type: application/jpeg');
        header('Content-Disposition: attachment; filename="'.$pic->getTitle().'.jpg"');
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
