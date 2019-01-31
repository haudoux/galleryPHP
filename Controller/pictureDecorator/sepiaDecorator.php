<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/pictureDecorator/pictureDecoratorInterface.php");

require_once("/var/www/html/pattern/Model/gallery.php");

class sepiaDecorator implements IpictureDecorator
{
    private $pathToWrite;

    public function __construct()
    {
    }
    public function decorate($pathToWrite, $value)
    {
        loggerSingleton::getInstance()->writeLog("Add sepia to image ", levelLogger::DEBUG);
        $this->sepiaToneImage($pathToWrite, $value);
    }
    private function sepiaToneImage($pathToWrite, $sepia)
    {
        $imagick = new Imagick($pathToWrite);
        $imagick->setFormat("jpg");
        $imagick->sepiaToneImage($sepia);

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
