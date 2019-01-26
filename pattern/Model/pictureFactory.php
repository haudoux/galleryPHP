<?php

interface pictureFactory
{
    public function makePicture($id, $ownerId, $owner, $description, $title, $path, $creationDate, $modificationDate, $size);
}
