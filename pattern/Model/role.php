<?php
class role
{
    private $id;
    private $name;
    private $modifyDescription;
    private $modifyDescriptionAll;
    private $viewStats;
    private $viewStatsAll;
    private $manageImage;
    private $manageImageAll;
    private $modifyProfil;
    private $modifyProfilAll;
    private $modifyPackage;
    private $modifyPackageAll;
    private $viewAction;
    private $creationDate;
    private $modificationDate;

    public function __construct(
        $id,
        $name,
                        /*$modifyDescription, $modifyDescriptionAll,
                        $viewStats, $viewStatsAll,
                        $manageImage, $manageImageAll,
                        $modifyProfil, $modifyProfilAll,
                        $modifyPackage, $modifyPackageAll,
                        $viewAction,*/
                        $creationDate,
        $modificationDate
    ) {
        $this->id                   = $id;
        $this->name                 = $name;
        /* $this->modifyDescription    = $modifyDescription;
         $this->modifyDescriptionAll = $modifyDescriptionAll;
         $this->viewStats            = $viewStats;
         $this->viewStatsAll         = $viewStatsAll;
         $this->manageImage          = $manageImage;
         $this->manageImageAll       = $manageImageAll;
         $this->modifyProfil         = $modifyProfil;
         $this->modifyProfilAll      = $modifyProfilAll;
         $this->modifyPackage        = $modifyPackage;
         $this->modifyPackageAll     = $modifyPackageAll;
         $this->viewAction           = $viewAction;*/
        $this->creationDate         = $creationDate;
        $this->modificationDate     = $modificationDate;
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
    public function getModifyDescription()
    {
        return $this->modifyDescription;
    }
    public function getModifyDescriptionAll()
    {
        return $this->modifyDescriptionAll;
    }
    public function getviewStats()
    {
        return $this->viewStats;
    }
    public function getViewStatsAll()
    {
        return $this->viewStatsAll;
    }
    public function getManageImage()
    {
        return $this->manageImage;
    }
    public function getManageImageAll()
    {
        return $this->manageImageAll;
    }
    public function getModifyProfil()
    {
        return $this->modifyProfil;
    }
    public function getModifyProfilAll()
    {
        return $this->modifyProfilAll;
    }
    public function getModifyPackage()
    {
        return $this->modifyPackage;
    }
    public function getModifyPackageAll()
    {
        return $this->modifyPackageAll;
    }
    public function getViewAction()
    {
        return $this->viewAction;
    }
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
    public function getRight()
    {
    }
    //////////
    //Setter
    private function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($name,$this->getId()));
        $this->name = $name;
    }
    public function setModifyDescription($modifyDescription)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyDescription,$this->getId()));
        $this->modifyDescription = $modifyDescription;
    }
    public function setModifyDescriptionAll($modifyDescriptionAll)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyDescriptionAll,$this->getId()));
        $this->modifyDescriptionAll = $modifyDescriptionAll;
    }
    public function setviewStats($viewStats)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($viewStats,$this->getId()));
        $this->viewStats = $viewStats;
    }
    public function setViewStatsAll($viewStatsAl)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($viewStatsAll,$this->getId()));
        $this->viewStatsAll = $viewStatsAll;
    }
    public function setManageImage($manageImage)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($manageImage,$this->getId()));
        $this->manageImage = $manageImage;
    }
    public function setManageImageAll($manageImageAll)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($manageImageAll,$this->getId()));
        $this->manageImageAll = $manageImageAll;
    }
    public function setModifyProfil($modifyProfil)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyProfil,$this->getId()));
        $this->modifyProfil = $modifyProfil;
    }
    public function setModifyProfilAll($modifyProfilAll)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyProfilAll,$this->getId()));
        $this->modifyProfilAll = $modifyProfilAll;
    }
    public function setModifyPackage($modifyPackage)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyPackage,$this->getId()));
        $this->modifyPackage = $modifyPackage;
    }
    public function setModifyPackageAll($modifyPackageAll)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($modifyPackageAll,$this->getId()));
        $this->modifyPackageAll = $modifyPackageAll;
    }
    public function setViewAction($viewAction)
    {
        dbSingleton::getInstance()->execSQL("UPDATE role SET name = ? WHERE id_role = ?", array($viewAction,$this->getId()));
        $this->viewAction = $viewAction;
    }
    private function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    private function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }
    //////////
}
