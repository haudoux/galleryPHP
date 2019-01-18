<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/roleList.php");

class adminRolesController
{
    private $roleList;
    private $header;
    private $footer;

    public function __construct()
    {
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
        loggerSingleton::getInstance()->writeLog("RenderModifyRole", levelLogger::DEBUG);
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBodyAll()
    {
        $html = $this->renderRole();
        return $html;
    }
    private function renderBodyModify($id)
    {
        $html = $this->renderRoleModify($id);
        return $html;
    }
    private function renderRoleModify($id)
    {
        loggerSingleton::getInstance()->writeLog("RenderModifyRole IN", levelLogger::DEBUG);
        $html = "";
        $this->getRole();
        $role       = $this->roleList->getOneRole($id);
        if ($roleList !== false) {
            $html .= '
                <form action="adminRoles.php" method="POST">
                    <table class="container">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Creation date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="role" value='.$role->getName().'>
                                </td>
                                <td>
                                <form action="adminRolesController.php" method="POST">
                                    <input type="hidden" name="id" value='.$role->getId().'>
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
    public function updateRole($id, $roleName)
    {
        $this->getRole();
        $role = $this->roleList->getOneRole($id);
        loggerSingleton::getInstance()->writeLog("Update role", levelLogger::DEBUG);
        if ($role !== null) {
            $role->setName($roleName);
            echo $this->renderTemplate();
        }
    }
    private function getRole()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Role", levelLogger::DEBUG);
        $this->roleList->loadRoleFromDb();
    }
    private function renderRole()
    {
        $html = "";
        $this->getRole();
        $html .= '
            <table class="container">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Creation date</th>
                        <th>Modification date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($this->roleList->getList() as $role) {
            $html .= '
                                <tr>
                                    <td>'.$role->getName().'</td>
                                    <td>'.$role->getCreationDate().'</td>
                                    <td>'.$role->getModificationDate().'</td>
                                    <td>
                                        <form action="adminRoles.php" method="POST">
                                            <input type="hidden" name="id" value='.$role->getId().'>
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
