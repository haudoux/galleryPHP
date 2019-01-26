<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/userList.php");
require_once("/var/www/html/pattern/Model/packageList.php");
require_once("/var/www/html/pattern/Model/roleList.php");

class adminUsersController
{
    private $userList;
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
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyAll();
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderModifyTemplate($id)
    {
        loggerSingleton::getInstance()->writeLog("RenderModifyUser", levelLogger::DEBUG);
        $this->header->enableSecurity();
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
        loggerSingleton::getInstance()->writeLog("RenderModifyUser IN", levelLogger::DEBUG);
        $html = "";
        $this->getUser();
        $this->getPackage();
        $this->getRole();
        $packageList = $this->packageList->getList();
        $roleList = $this->roleList->getList();
        $user = $this->userList->getOneUser($id);
        loggerSingleton::getInstance()->writeLog("get", levelLogger::DEBUG);
        if ($user !== false) {
            loggerSingleton::getInstance()->writeLog("False", levelLogger::DEBUG);
            loggerSingleton::getInstance()->writeLog("Rendering user to modify ".$user->getUid(), levelLogger::DEBUG);
            $html .= '
                <form action="adminUsers.php" method="POST">
                    <table class="container">
                        <thead>
                            <tr>
                                <th>User name</th>
                                <th>Package</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Consumption kb</th>
                                <th>Consumption nb</th>
                                <th>Validate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="uid" value="'.$user->getUid().'"></td>
                                <td>
                                    <select name="package">';
            foreach ($packageList as $pack) {
                $html .= '<option value='.$pack->getId();
                if (strcmp($pack->getName(), $user->getPackageName()) == 0) {
                    $html .= ' selected="selected"';
                }
                $html .= '>'.$pack->getName().'</option>';
            }
                                        
            $html .= '
                                    </select>
                                </td>
                                <td>
                                    <select name="role">';
            foreach ($roleList as $role) {
                $html .= '<option value='.$role->getId();
                if (strcmp($role->getName(), $user->getRoleId()) == 0) {
                    $html .= ' selected="selected"';
                }
                $html .= '>'.$role->getName().'</option>';
            }
                                        
            $html .= '
                                    </select>
                                </td>
                                <td><input type="text" name="email" value="'.$user->getEmail().'"></td>
                                <td><input type="text" name="uploadKb" value="'.$user->getUploadKb().'"></td>
                                <td><input type="text" name="uploadNb" value="'.$user->getUploadNb().'"></td>
                                <td>
                                <form action="adminUsersController.php" method="POST">
                                    <input type="hidden" name="id" value='.$user->getId().'>
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
    public function updateUser($id, $uid, $package, $role, $email, $uploadKb, $uploadNb)
    {
        $this->getUser();
        $user = $this->userList->getOneUser($id);
        loggerSingleton::getInstance()->writeLog("Update user", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r($id, true), levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r($role, true), levelLogger::DEBUG);
        if ($user !== null) {
            $user->setUid($uid);
            $user->setPackageId($package);
            $user->setRoleId($role);
            $user->setEmail($email);
            $user->setUploadKb($uploadKb);
            $user->setUploadNb($uploadNb);
            echo $this->renderTemplate();
        }
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::DEBUG);
        $this->userList->loadUserFromDb();
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
                        <th>Role</th>
                        <th>Email</th>
                        <th>Consumption kb</th>
                        <th>Consumption nb</th>
                        <th>Creation date</th>
                        <th>Modification date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($this->userList->getList() as $user) {
            $html .= '
                                <tr>
                                    <td>'.$user->getUid().'</td>
                                    <td>'.$user->getPackageName().'</td>
                                    <td>'.$user->getRoleId().'</td>
                                    <td>'.$user->getEmail().'</td>
                                    <td>'.$user->getUploadKb().'</td>
                                    <td>'.$user->getUploadNb().'</td>
                                    <td>'.$user->getCreationDate().'</td>
                                    <td>'.$user->getModificationDate().'</td>
                                    <td>
                                        <form action="adminUsers.php" method="POST">
                                            <input type="hidden" name="id" value='.$user->getId().'>
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
