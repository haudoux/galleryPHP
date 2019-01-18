<?php
class package
{
    private $id;
    private $name;
    private $price;
    private $sizeUploadLimit;
    private $dailyUpload;
    private $maximumUpload;
    private $creationDate;
    private $modificationDate;

    public function __construct($id, $name, $price, $sizeUploadLimit, $dailyUpload, $maximumUpload, $creationDate, $modificationDate)
    {
        $this->id               = $id;
        $this->name             = $name;
        $this->price            = $price;
        $this->sizeUploadLimit  = $sizeUploadLimit;
        $this->dailyUpload      = $dailyUpload;
        $this->maximumUpload    = $maximumUpload;
        $this->creationDate     = $creationDate;
        $this->modificationDate = $modificationDate;
    }
    //Getter
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getSizeUploadLimit()
    {
        return $this->sizeUploadLimit;
    }
    public function getDailyUpload()
    {
        return $this->dailyUpload;
    }
    public function getMaximumUpload()
    {
        return $this->maximumUpload;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
    //////////
    //Setter
    public function setName($name)
    {
        dbSingleton::getInstance()->execSQL("UPDATE package SET nom_package = ? WHERE id_package = ?", array($name,$this->getId()));
        $this->name = $name;
    }
    public function setPrice($price)
    {
        dbSingleton::getInstance()->execSQL("UPDATE package SET price_package = ? WHERE id_package = ?", array($price,$this->getId()));
        $this->price = $price;
    }
    public function setSizeUploadLimit($sizeUploadLimit)
    {
        dbSingleton::getInstance()->execSQL("UPDATE package SET size_upload_limit_package = ? WHERE id_package = ?", array($sizeUploadLimit,$this->getId()));
        $this->sizeUploadLimit = $sizeUploadLimit;
    }
    public function setDailyUpload($dailyUpload)
    {
        dbSingleton::getInstance()->execSQL("UPDATE package SET daily_upload_package = ? WHERE id_package = ?", array($dailyUpload,$this->getId()));
        $this->dailyUpload = $dailyUpload;
    }
    public function setMaximumUpload($maximumUpload)
    {
        dbSingleton::getInstance()->execSQL("UPDATE package SET nb_maximum_upload_package = ? WHERE id_package = ?", array($maximumUpload,$this->getId()));
        $this->maximumUpload = $maximumUpload;
    }
    //////////
}
