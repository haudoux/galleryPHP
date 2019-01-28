<?php
    require("/var/www/html/pattern/Controller/adminController/adminGalleryController.php");
    $ctrl = new adminGalleryController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("View modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_POST['id']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("View validate", levelLogger::DEBUG);
        echo $ctrl->updateGallery($_POST['id'], $_POST['title'], $_POST['description'], $_POST['owner']);
    } else {
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
