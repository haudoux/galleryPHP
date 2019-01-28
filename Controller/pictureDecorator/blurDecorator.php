<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/pictureDecoratorInterface.php");

require_once("/var/www/html/pattern/Model/gallery.php");

class blurDecorator implements IpictureDecorator
{
    private $pathToWrite;
    private $fullPath;

    public function __construct($fullPath)
    {
        $this->fullPath     = $fullPath;
    }
    public function decorate($pathToWrite, $value)
    {
        loggerSingleton::getInstance()->writeLog("Add blur to image", levelLogger::DEBUG);
        $this->radialBlurImage($pathToWrite, $value);
    }
    private function radialBlurImage($pathToWrite, $blurRadius)
    {
        $imagick = new Imagick(realpath($this->fullPath));
        $imagick->setFormat("jpg");
        $imagick->radialBlurImage($blurRadius);
        
        $this->writeImage($imagick, $pathToWrite);
    }
    private function writeImage($imagick, $pathToWrite)
    {
        if (!$imagick->writeImage($pathToWrite)) {
            loggerSingleton::getInstance()->writeLog("Write image fail", levelLogger::DEBUG);
        } else {
            loggerSingleton::getInstance()->writeLog("Write image success", levelLogger::DEBUG);
        }
        $imagick->destroy();
    }
}
