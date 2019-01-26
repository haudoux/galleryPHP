<?php
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/pictureInterface.php");

class Picture implements pictureInterface
{
    private $id;
    private $ownerId;
    private $owner;
    private $description;
    private $title;
    private $path;
    private $creationDate;
    private $modificationDate;
    private $size;

    public function __construct($id, $ownerId, $owner, $description, $title, $path, $creationDate, $modificationDate, $size)
    {
        $this->id               = $id;
        $this->ownerId          = $ownerId;
        $this->owner            = $owner;
        $this->description      = $description;
        $this->title            = $title;
        $this->path             = $path;
        $this->creationDate     = $creationDate;
        $this->modificationDate = $modificationDate;
        $this->size             = $size;
    }

    
    //Getter
    public function getId()
    {
        return $this->id;
    }
    public function getOwnerId()
    {
        return $this->ownerId;
    }
    public function getOwner()
    {
        //Adapter TODO
        return $this->owner;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
    public function getSize()
    {
        return $this->size;
    }
    //////////
    //Setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setOwner($owner)
    {
        dbSingleton::getInstance()->execSQL("UPDATE gallery SET fk_id_user = ? WHERE id_gallery = ?", array($owner,$this->getId()));
        $this->owner = $owner;
    }
    public function setDescription($description)
    {
        dbSingleton::getInstance()->execSQL("UPDATE gallery SET description_gallery = ? WHERE id_gallery = ?", array($description,$this->getId()));
        $this->description = $description;
    }
    public function setTitle($title)
    {
        dbSingleton::getInstance()->execSQL("UPDATE gallery SET title_gallery = ? WHERE id_gallery = ?", array($title,$this->getId()));
        $this->title = $title;
    }
    public function setPath($path)
    {
        $this->path = $path;
    }
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }
    //////////
}
