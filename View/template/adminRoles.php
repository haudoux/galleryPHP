<?php
    require("/var/www/html/pattern/Controller/adminController/adminRolesController.php");
    $ctrl = new adminRolesController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("View modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_POST['id']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("View validate", levelLogger::DEBUG);
        echo $ctrl->updateRole($_POST['id'], $_POST['role']);
    } else {
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
