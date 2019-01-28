<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/pictureDecoratorInterface.php");

require_once("/var/www/html/pattern/Model/gallery.php");

class resizeDecorator implements IpictureDecorator
{
    private $pathToWrite;
    private $fullPath;

    public function __construct($fullPath)
    {
        $this->fullPath     = $fullPath;
    }
    public function decorate($pathToWrite, $value)
    {
        loggerSingleton::getInstance()->writeLog("Add sepia to image ", levelLogger::DEBUG);
        $this->resizeImage($pathToWrite, $value);
    }
    private function resizeImage($pathToWrite, $percent = 100)
    {
        $imagick = new Imagick(realpath($this->fullPath));
        $imagick->setFormat("jpg");
        $imagick->adaptiveResizeImage($imagick->getImageWidth() * ($percent / 100), $imagick->getImageHeight() * ($percent / 100));

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
