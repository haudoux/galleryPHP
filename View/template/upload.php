<?php
    require("/var/www/html/pattern/Controller/uploadController.php");
    $ctrl = new uploadController();
    if (isset($_POST['submit'])) {
        loggerSingleton::getInstance()->writeLog("View submit", levelLogger::DEBUG);
        echo $ctrl->uploadPicture($_FILES["file"], $_POST['filetitle'], $_POST['filedesc']);
    } else {
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
