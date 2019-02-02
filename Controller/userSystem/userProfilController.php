<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/userList.php");
require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/roleList.php");

class userProfilController
{
    private $userList;
    private $user;
    private $packageList;
    private $roleList;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->userList     = UserList::getInstance();
        $this->packageList  = PackageList::getInstance();
        $this->roleList     = RoleList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyAll();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderModifyTemplate($id)
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBodyAll()
    {
        $html = $this->renderUser();
        return $html;
    }
    private function renderBodyModify($id)
    {
        $html = $this->renderUserModify($id);
        return $html;
    }
    private function renderUserModify($id)
    {
        $html = "";
        $this->getUser();
        $this->getPackage();
        $this->getRole();
        $packageList = $this->packageList->getList();
        $roleList = $this->roleList->getList();
        if ($this->user !== false) {
            loggerSingleton::getInstance()->writeLog("Rendering user to modify ".$this->user->getUid(), levelLogger::DEBUG);
            $html .= '
                <form action="adminUsers.php" method="POST">
                    <table class="container">
                        <thead>
                            <tr>
                                <th>User name</th>
                                <th>Package</th>
                                <th>Email</th>
                                <th>Consumption kb</th>
                                <th>Consumption nb</th>
                                <th>Validate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="uid" value="'.$this->user->getUid().'"></td>
                                <td>
                                    <select name="package">';
            foreach ($packageList as $pack) {
                $html .= '<option value='.$pack->getId();
                if (strcmp($pack->getName(), $this->user->getPackage) == 0) {
                    $html .= ' selected="selected"';
                }
                $html .= '>'.$pack->getName().'</option>';
            }
                                                                
            $html .= '
                                    </select>
                                </td>
                                <td><input type="text" name="email" value="'.$this->user->getEmail().'"></td>
                                <td>'.$this->user->getUploadKb().'</td>
                                <td>'.$this->user->getUploadNb().'</td>
                                <td>
                                <form action="userProfil.php" method="POST">
                                    <input type="hidden" name="id" value='.$this->user->getId().'>
                                    <input type="submit" class="link" name="validate" value="Validate">
                                </form>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </form>';
        }
        return $html;
    }
    public function updateUser($uid, $package, $email)
    {
        $this->getUser();
        loggerSingleton::getInstance()->writeLog("Update user", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r($id, true), levelLogger::DEBUG);
        if ($this->user !== null) {
            $this->user->setUid($uid);
            $this->user->setPackageId($package);
            $this->user->setEmail($email);
            echo $this->renderTemplate();
        }
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::DEBUG);
        $this->userList->loadUserFromDb();
        $this->user = $this->userList->getOneUser($_SESSION['userId']);
    }
    private function getPackage()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Package", levelLogger::DEBUG);
        $this->packageList->loadPackageFromDb();
    }
    private function getRole()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Role", levelLogger::DEBUG);
        $this->roleList->loadRoleFromDb();
    }
    private function renderUser()
    {
        $html = "";
        $this->getUser();
        $html .= '
            <table class="container">
                <thead>
                    <tr>
                        <th>User name</th>
                        <th>Package</th>
                        <th>Email</th>
                        <th>Consumption kb</th>
                        <th>Consumption nb</th>
                        <th>Creation date</th>
                        <th>Modification date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$this->user->getUid().'</td>
                        <td>'.$this->user->getPackageName().'</td>
                        <td>'.$this->user->getEmail().'</td>
                        <td>'.$this->user->getUploadKb().'</td>
                        <td>'.$this->user->getUploadNb().'</td>
                        <td>'.$this->user->getCreationDate().'</td>
                        <td>'.$this->user->getModificationDate().'</td>
                        <td>
                            <form action="userProfil.php" method="POST">
                                <input type="hidden" name="id" value='.$this->user->getId().'>
                                <input type="submit" class="link" name="modify" value="Modify">
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>';
        return $html;
    }
}
