<?php
require_once("/var/www/html/pattern/Controller/loggerSystem/loggerSingleton.php");
require_once("/var/www/html/pattern/Controller/home/headerController.php");
require_once("/var/www/html/pattern/Controller/home/footerController.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Model/gallery.php");
require_once("/var/www/html/pattern/Model/userList.php");

class userGalleryController
{
    private $gallery;
    private $userList;
    private $pictToModify;
    private $header;
    private $footer;

    public function __construct()
    {
        $this->pictToModify = 0;
        $this->userList     = UserList::getInstance();
        $this->gallery      = new Gallery();
        $this->header       = new HeaderController();
        $this->footer       = new FooterController();
    }
    public function renderTemplate($id)
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyAll($id);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    public function renderModifyTemplate($id, $picture)
    {
        $this->header->enableSecurity(3);
        $this->header->setStylesheet("adminUsers.css");
        $html  = $this->header->renderTemplate();
        $html .= $this->renderBodyModify($id, $picture);
        $html .= $this->footer->renderTemplate();
        return $html;
    }
    private function renderBodyAll($id)
    {
        $html = $this->renderGallery($id);
        return $html;
    }
    private function renderBodyModify($id, $picture)
    {
        $html = $this->renderGalleryModify($id, $picture);
        return $html;
    }
    private function renderGalleryModify($id, $picture)
    {
        $this->getUser();
        $html = "";
        $this->getGallery($id);
        $pic = $this->gallery->getOnePicture($picture);
        if ($pic !== false) {
            $html .= '
                <form action="userGallery.php" method="POST">
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
                                <td>'.$pic->getOwner().' <td>
                                <form action="userGallery.php" method="POST">
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
    public function updateGallery($id, $picture, $title, $description)
    {
        $this->getGallery($id);
        $gallery = $this->gallery->getOnePicture($picture);
        loggerSingleton::getInstance()->writeLog("Update gallery ".$title." ".$description, levelLogger::DEBUG);
        if ($gallery !== null) {
            $gallery->setTitle($title);
            $gallery->setDescription($description);
            echo $this->renderTemplate($id);
        } else {
            loggerSingleton::getInstance()->writeLog("Something went wrong during the update of the picture : ".$picture, levelLogger::ERROR);
        }
    }
    private function getGallery($id)
    {
        loggerSingleton::getInstance()->writeLog("Start loading Gallery", levelLogger::INFO);
        $this->gallery->getPictureOfOneUser($id);
    }
    private function getUser()
    {
        loggerSingleton::getInstance()->writeLog("Start loading User", levelLogger::INFO);
        $this->userList->loadUserFromDb();
    }
    private function renderGallery($id)
    {
        $html = "";
        $this->getGallery($id);
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
                                        <form action="userGallery.php" method="POST">
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
