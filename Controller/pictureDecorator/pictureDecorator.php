<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/pictureDecoratorInterface.php");

require_once("/var/www/html/pattern/Model/gallery.php");

class pictureDecorator implements IpictureDecorator
{
    private $pathToWrite;
    private $fullPath;

    public function __construct($fullPath)
    {
        $this->fullPath     = $fullPath;
    }
    public function decorate($pathToWrite, $value)
    {
        loggerSingleton::getInstance()->writeLog("Preparation of the image", levelLogger::DEBUG);
        $imagick = new Imagick(realpath($this->fullPath));
        $imagick->setFormat("jpg");
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
