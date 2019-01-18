<?php
class user
{
    private $id;
    private $packageId;
    private $packageName;
    private $roleId;
    private $uid;
    private $email;
    private $creationDate;
    private $modificationDate;
    private $uploadKb;
    private $uploadNb;

    public function __construct($id, $packageId, $packageName, $roleId, $uid, $email, $creationDate, $modificationDate, $uploadKb, $uploadNb)
    {
        $this->id               = $id;
        $this->packageId        = $packageId;
        $this->packageName      = $packageName;
        $this->roleId           = $roleId;
        $this->uid              = $uid;
        $this->email            = $email;
        $this->creationDate     = $creationDate;
        $this->modificationDate = $modificationDate;
        $this->uploadKb         = $uploadKb;
        $this->uploadNb         = $uploadNb;
    }
    //Getter
    public function getId()
    {
        return $this->id;
    }
    public function getPackageId()
    {
        return $this->packageId;
    }
    public function getPackageName()
    {
        return $this->packageName;
    }
    public function getRoleId()
    {
        return $this->roleId;
    }
    public function getUid()
    {
        return $this->uid;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
    public function getUploadKb()
    {
        return $this->uploadKb;
    }
    public function getUploadNb()
    {
        return $this->uploadNb;
    }
    //////////
    //Setter
    private function setId($id)
    {
        $this->id = $id;
    }
    public function setPackageId($packageId)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET fk_package_id = ? WHERE id_user = ?", array($packageId,$this->getId()));
        $packageName = dbSingleton::getInstance()->selectSQL("SELECT nom_package FROM package WHERE id_package =?", array($packageId));

        $this->packageId    = $packageId;
        $this->packageName  = $packageName['nom_package'];
    }
    public function setRoleId($roleId)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET fk_role_id = ? WHERE id_user = ?", array($roleId,$this->getId()));
        $this->roleId = $roleId;
    }
    public function setUid($uid)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET uid_user = ? WHERE id_user = ?", array($uid,$this->getId()));
        $this->uid = $uid;
    }
    public function setEmail($email)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET email_user = ? WHERE id_user = ?", array($paemailckageId,$this->getId()));
        $this->email = $email;
    }
    private function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    private function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }
    public function setUploadKb($uploadKb)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET upload_kb_consumption = ? WHERE id_user = ?", array($uploadKb,$this->getId()));
        $this->uploadKb = $uploadKb;
    }
    public function setUploadNb($uploadNb)
    {
        dbSingleton::getInstance()->execSQL("UPDATE user SET upload_nb_consumption = ? WHERE id_user = ?", array($uploadNb,$this->getId()));
        $this->uploadNb = $uploadNb;
    }
    //////////
}
