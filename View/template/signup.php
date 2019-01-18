<?php
    require("/var/www/html/pattern/Controller/signupController.php");
    $ctrl = new signupController();
    echo $ctrl->renderTemplate();
