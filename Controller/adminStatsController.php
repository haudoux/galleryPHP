<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/userList.php");
require_once("/var/www/html/pattern/Model/packageList.php");


class adminStatsController
{
    private $header;
    private $footer;
    private $userList;
    private $packageList;


    public function __construct()
    {
        $this->packageList  = PackageList::getInstance();
        $this->userList     = UserList::getInstance();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate()
    {
        $this->header->enableSecurity();
        $this->header->setStylesheet("../css/adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= self::renderBody();
        $html .= $this->footer->renderTemplate();
        return $html;
    }

    private function renderBody()
    {
        $this->getUser();
        $this->getPackage();
        $html = '
        <table class="container">
        <thead>
            <tr>
                <th>Name</th>
                <th>Upload in kb</th>
                <th>Limit in kb</th>
                <th>Upload in nb</th>
                <th>Limit in nb</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($this->userList->getList() as $user) {
            loggerSingleton::getInstance()->writeLog($user->getPackageId(), levelLogger::DEBUG);

            $packageUser = $this->packageList->getOnePackage($user->getPackageId());
            $html .= '
                        <tr>
                            <td>'.$user->getUid().'</td>
                            <td>'.$user->getUploadKb().'</td>
                            <td>'.$packageUser->getUploadLimit().'</td>
                            <td>'.$user->getUploadNb().'</td>
                            <td>'.$packageUser->getMaximumUpload().'</td>
                        </tr>';
        }
        $html .= '
        </tbody>
    </table>';

        return $html;
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
}
