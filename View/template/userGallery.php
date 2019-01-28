<?php
    session_start();
    require("/var/www/html/pattern/Controller/userSystem/userGalleryController.php");
    $ctrl = new userGalleryController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_SESSION['userId'], $_POST['id']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("validate", levelLogger::DEBUG);
        echo $ctrl->updateGallery($_SESSION['userId'], $_POST['id'], $_POST['title'], $_POST['description']);
    } else {
        loggerSingleton::getInstance()->writeLog("else  ", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate($_SESSION['userId']);
    }
