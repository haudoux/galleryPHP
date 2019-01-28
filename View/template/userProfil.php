<?php
    session_start();
    require("/var/www/html/pattern/Controller/userSystem/userProfilController.php");
    $ctrl = new userProfilController();
    if (isset($_POST['modify'])) {
        loggerSingleton::getInstance()->writeLog("modify", levelLogger::DEBUG);
        echo $ctrl->renderModifyTemplate($_SESSION['userId']);
    } elseif (isset($_POST['validate'])) {
        loggerSingleton::getInstance()->writeLog("validate", levelLogger::DEBUG);
        echo $ctrl->updateUser($_POST['uid'], $_POST['package'], $_POST['email']);
    } else {
        loggerSingleton::getInstance()->writeLog("else  ", levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog("View else", levelLogger::DEBUG);
        echo $ctrl->renderTemplate();
    }
