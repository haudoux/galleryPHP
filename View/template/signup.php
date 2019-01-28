<?php
    require("/var/www/html/pattern/Controller/loginSystem/signupController.php");
    $ctrl = new signupController();
    echo $ctrl->renderTemplate();
