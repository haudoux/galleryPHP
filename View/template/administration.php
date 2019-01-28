<?php
    require("/var/www/html/pattern/Controller/adminController/administrationController.php");
    $ctrl = new administrationController();
    echo $ctrl->renderTemplate();
