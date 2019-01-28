<?php
    require("/var/www/html/pattern/Controller/adminController/adminPackagesController.php");
    $ctrl = new adminPackagesController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("View modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_POST['id']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("View validate", levelLogger::DEBUG);
        echo $ctrl->renderUpdatePackage($_POST['id'], $_POST['package'], $_POST['price'], $_POST['sizeUploadlimit'], $_POST['daily'], $_POST['maximum']);
    } elseif (isset($_POST['add'])) {
        echo $ctrl->renderAddNewPackage();
    } elseif (isset($_POST['new'])) {
        echo $ctrl->renderNewPackage($_POST['package'], $_POST['price'], $_POST['sizeUploadlimit'], $_POST['daily'], $_POST['maximum']);
    } else {
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
