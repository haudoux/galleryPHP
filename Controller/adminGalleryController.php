<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/headerController.php");
require_once("/var/www/html/pattern/Controller/footerController.php");

require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Model/userList.php");

class adminGalleryController
{
    private $gallery;
    private $userList;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->userList     = UserList::getInstance();
        $this->gallery      = new Gallery();
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
        loggerSingleton::getInstance()->writeLog("RenderModifyGallery", levelLogger::DEBUG);
        $this->header->enableSecurity();
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBodyAll()
    {
        $html = $this->renderGallery();
        return $html;
    }
    private function renderBodyModify($id)
    {
        $html = $this->renderGalleryModify($id);
        return $html;
    }
    private function renderGalleryModify($id)
    {
        $this->getUser();

        loggerSingleton::getInstance()->writeLog("RenderModifyGallery IN", levelLogger::DEBUG);
        $html = "";
        $this->getGallery();
        $pic = $this->gallery->getOnePicture($id);
        if ($pic !== false) {
            $html .= '
                <form action="adminGallery.php" method="POST">
                    <table class="container">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Owner</th>
                                <th>Validate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="title"             value="'.$pic->getTitle().'"></td>
                                <td><input type="text" name="description"       value="'.$pic->getDescription().'"></td>
                                <td>
                                    <select name="owner">';
            foreach ($this->userList->getList() as $user) {
                $html .= '<option value='.$user->getId();
                if (strcmp($user->getUid(), $pic->getOwner) == 0) {
                    $html .= ' selected="selected"';
                }
                $html .= '>'.$user->getUid().'</option>';
            }
                                        
            $html .= '
                                    </select>
                                <td>
                                <form action="adminGalleryController.php" method="POST">
                                    <input type="hidden" name="id" value='.$pic->getId().'>
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
    public function updateGallery($id, $title, $description, $owner)
    {
        $this->getGallery();
        $gallery = $this->gallery->getOnePicture($id);
        loggerSingleton::getInstance()->writeLog("Update gallery ".$title." ".$description." ".$owner, levelLogger::DEBUG);
        if ($gallery !== null) {
            $gallery->setTitle($title);
            $gallery->setDescription($description);
            $gallery->setOwner($owner);
            echo $this->renderTemplate();
        }
    }
    private function getGallery()
    {
        loggerSingleton::getInstance()->writeLog("Start loading Gallery", levelLogger::DEBUG);
        $this->gallery->loadPictureFromDb();
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::DEBUG);
        $this->userList->loadUserFromDb();
    }
    private function renderGallery()
    {
        $html = "";
        $this->getGallery();
        $html .= '
            <table class="container">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Owner</th>
                        <th>Size in kb</th>
                        <th>Creation date</th>
                        <th>Modification date</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($this->gallery->getList() as $pic) {
            $html .= '
                                <tr>
                                    <td>'.$pic->getTitle().'</td>
                                    <td><img src="../ressources/imagesUpload/'.$pic->getPath().'" width="100" height="100">
                                    <td>'.$pic->getDescription().'</td>
                                    <td>'.$pic->getOwner().'</td>
                                    <td>'.$pic->getSize().'</td>
                                    <td>'.$pic->getCreationDate().'</td>
                                    <td>'.$pic->getModificationDate().'</td>
                                    <td>
                                        <form action="adminGallery.php" method="POST">
                                            <input type="hidden" name="id" value='.$pic->getId().'>
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
