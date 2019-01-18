<?php

interface pictureInterface
{
    //Getter
    public function getId();
    public function getOwnerId();
    public function getOwner();
    public function getDescription();
    public function getTitle();
    public function getPath();
    public function getCreationDate();
    public function getModificationDate();
    public function getSize();
    
    //////////
    //Setter
    public function setId($id);
    public function setOwner($owner);
    public function setDescription($description);
    public function setTitle($title);
    public function setPath($path);
    public function setCreationDate($creationDate);
    public function setModificationDate($modificationDate);
    public function setSize($size);
    //////////
}
