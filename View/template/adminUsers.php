<?php
    require("/var/www/html/pattern/Controller/adminController/adminUsersController.php");
    $ctrl = new adminUsersController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("View modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_POST['id']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("View validate", levelLogger::DEBUG);
        echo $ctrl->updateUser($_POST['id'], $_POST['uid'], $_POST['package'], $_POST['role'], $_POST['email'], $_POST['uploadKb'], $_POST['uploadNb']);
    } else {
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
