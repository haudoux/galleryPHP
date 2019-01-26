<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/classicPictureFactory.php");
require_once("dbSingleton.php");
require_once("picture.php");

class Gallery
{
    private $listPicture;
    private $pictureFactory;
    public function __construct()
    {
        $this->pictureFactory = new classicPictureFactory();
        $this->listPicture = [];
    }

    public function getList()
    {
        return $this->listPicture;
    }
    public function loadPictureFromDb($limit = 0, $offset = 0)
    {
        loggerSingleton::getInstance()->writeLog("Start loading picture from db", levelLogger::DEBUG);
        $sql    = "SELECT id_gallery, fk_id_user, user.uid_user, description_gallery, title_gallery, img_full_name_gallery, creation_date_gallery, modification_date_gallery, size_kb_gallery FROM gallery INNER JOIN user ON fk_id_user = user.id_user ";
        $this->sortQuery($sql, array("limit" => $limit, "offset" => $offset));
    }
    public function getPictureOfOneUser($id)
    {
        loggerSingleton::getInstance()->writeLog("Start loading picture from db", levelLogger::DEBUG);
        $sql    = "SELECT id_gallery, fk_id_user, user.uid_user, description_gallery, title_gallery, img_full_name_gallery, creation_date_gallery, modification_date_gallery, size_kb_gallery FROM gallery INNER JOIN user ON fk_id_user = user.id_user WHERE id_user = ? ";
        $pictures = dbSingleton::getInstance()->selectSQL($sql, array($id));
        $fields = array_keys($pictures);
        $sizeArray = count($pictures[$fields[0]]);

        for ($aPicture = 0; $aPicture < $sizeArray; $aPicture += 1) {
            $dataOnePic = array();
            foreach ($fields as $aField) {
                $dataOnePic[] = $pictures[$aField][$aPicture];
            }
            $pic = new Picture(...$dataOnePic);
            $this->addPicture($pic);
        }
        
        loggerSingleton::getInstance()->writeLog("Loading finish gallery", levelLogger::DEBUG);
    }
    public function addPicture(Picture $pic)
    {
        $this->listPicture[$pic->getId()] = $pic;
    }
    public function cleanList()
    {
        $this->listPicture = array();
    }
    public function getOnePicture($id)
    {
        return $this->listPicture[$id];
    }
    public function searchGallery($search, $limit = 0, $offset = 0)
    {
        $sql    = "SELECT id_gallery, fk_id_user, user.uid_user, description_gallery, title_gallery, img_full_name_gallery, creation_date_gallery, modification_date_gallery, size_kb_gallery FROM template.gallery LEFT JOIN user ON user.id_user = fk_id_user WHERE description_gallery REGEXP ? OR title_gallery REGEXP ? OR user.uid_user REGEXP ? OR creation_date_gallery REGEXP ? OR hastags_gallery REGEXP ? OR size_kb_gallery REGEXP ? ";
        $param  = array($search,$search,$search,$search,$search,$search,"limit" => $limit, "offset" => $offset);

        $this->sortQuery($sql, $param);
    }
    private function sortQuery($sql, $param)
    {
        loggerSingleton::getInstance()->writeLog("Param ".print_r($param,true), levelLogger::DEBUG);
        if ($param['limit'] !== 0) {
            $sql                .= "LIMIT ? OFFSET ?";
            $param["offset"]    *= 10;
        }
        $pictures = dbSingleton::getInstance()->selectSQL($sql, $param);
        $fields = array_keys($pictures);
        $sizeArray = count($pictures[$fields[0]]);

        for ($aPicture = 0; $aPicture < $sizeArray; $aPicture += 1) {
            $dataOnePic = array();
            foreach ($fields as $aField) {
                $dataOnePic[] = $pictures[$aField][$aPicture];
            }
            $pic = $this->pictureFactory->makePicture(...$dataOnePic);
            $this->addPicture($pic);
        }
        
        loggerSingleton::getInstance()->writeLog("Loading finish gallery", levelLogger::DEBUG);
    }
}
