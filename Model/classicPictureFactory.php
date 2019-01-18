<?php
require_once("/var/www/html/pattern/Model/pictureFactory.php");

class classicPictureFactory implements pictureFactory
{
    public function makePicture($id, $ownerId, $owner, $description, $title, $path, $creationDate, $modificationDate, $size)
    {
        return new Picture($id, $ownerId, $owner, $description, $title, $path, $creationDate, $modificationDate, $size);
    }
}
