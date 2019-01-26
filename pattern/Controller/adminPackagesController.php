<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/packageList.php");

class adminPackagesController
{
    private $packageList;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->packageList  = PackageList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyAll();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderModifyTemplate($id)
    {
        loggerSingleton::getInstance()->writeLog("RenderModifyPackage", levelLogger::DEBUG);
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderUpdatePackage($id, $packageName, $price, $sizeUploadLimit, $daily, $max)
    {
        $this->getPackage();
        $package = $this->packageList->getOnePackage($id);
        loggerSingleton::getInstance()->writeLog("Update package", levelLogger::DEBUG);
        if ($package !== null) {
            $package->setName($packageName);
            $package->setPrice($price);
            $package->setSizeUploadLimit($sizeUploadLimit);
            $package->setDailyUpload($daily);
            $package->setMaximumUpload($max);
            return $this->renderTemplate();
        }
    }
    public function renderAddNewPackage()
    {
        loggerSingleton::getInstance()->writeLog("RenderAddNewPackage", levelLogger::DEBUG);
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->skeletonForm('new');
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderNewPackage($packageName, $sizeUploadLimit, $daily, $max)
    {
        loggerSingleton::getInstance()->writeLog("renderNewPackage", levelLogger::DEBUG);
        $this->header->enableSecurity();
        $this->packageList->addNewPackage($packageName, $sizeUploadLimit, $daily, $max);
        return $this->renderTemplate();
    }
    private function renderBodyAll()
    {
        $html = $this->renderPackage();
        return $html;
    }
    private function renderBodyModify($id)
    {
        $html = $this->renderPackageModify($id);
        return $html;
    }
    private function renderPackageModify($id)
    {
        loggerSingleton::getInstance()->writeLog("RenderModifyPackage IN", levelLogger::DEBUG);
        $html = "";
        $this->getPackage();
        $package = $this->packageList->getOnePackage($id);
        if ($package !== false) {
            $html .= $this->skeletonForm('validate', $package->getName(), $package->getPrice(), $package->getSizeUploadLimit(), $package->getDailyUpload(), $package->getMaximumUpload(), $package->getId());
        }
        return $html;
    }
    private function skeletonForm($nameForm, $name = "", $price="", $upLimit ="", $daily = "", $maximum = "", $id = "")
    {
        $html .= '
        <form action="adminPackages.php" method="POST">
            <table class="container">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Size limit</th>
                        <th>Daily upload</th>
                        <th>Maximum upload</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="package" value="'.$name.'" placeholder="Package name">
                        </td>
                        <td>
                            <input type="text" name="price" value="'.$price.'" placeholder="Price">
                        </td>
                        <td>
                            <input type="text" name="sizeUploadlimit" value="'.$upLimit.'" placeholder="Upload limit">
                        </td>
                        <td>
                            <input type="text" name="daily" value="'.$daily.'" placeholder="Daily upload">
                        </td>
                        <td>
                            <input type="text" name="maximum" value="'.$maximum.'" placeholder="Maximum upload">
                        </td>
                        <td>
                        <form action="adminPackagesController.php" method="POST">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="submit" class="link" name="'.$nameForm.'" value="'.ucfirst($nameForm).'">
                        </form>
                    </td>
                    </tr>
                </tbody>
            </table>
        </form>';
        return $html;
    }
    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package", levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function renderPackage()
    {
        $html = "";
        $this->getPackage();
        $html .= '
            <form action="adminPackages.php" method="POST">
                <input type="submit" name="add" value="Add a new packages">
            </form>
            <table class="container">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Size limit</th>
                        <th>Daily upload</th>
                        <th>Maximum upload</th>
                        <th>Creation date</th>
                        <th>Modification date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($this->packageList->getList() as $package) {
            $html .= '
                                <tr>
                                    <td>'.$package->getName().'</td>
                                    <td>'.$package->getPrice().'</td>
                                    <td>'.$package->getSizeUploadLimit().'</td>
                                    <td>'.$package->getDailyUpload().'</td>
                                    <td>'.$package->getMaximumUpload().'</td>
                                    <td>'.$package->getCreationDate().'</td>
                                    <td>'.$package->getModificationDate().'</td>
                                    <td>
                                        <form action="adminPackages.php" method="POST">
                                            <input type="hidden" name="id" value='.$package->getId().'>
                                            <input type="submit" class="link" name="modify" value="Modify">
                                        </form>
                                    </td>
                                </tr>';
        }
        $html .= '
                </tbody>
            </table>';
        return $html;
    }
}
