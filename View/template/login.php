<?php
//This is Facade pattern
    require("/var/www/html/pattern/Controller/loginSystem/loginController.php");
    $ctrl = new loginController();
    echo $ctrl->renderTemplate();
