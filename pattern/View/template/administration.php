<?php
    require("/var/www/html/pattern/Controller/administrationController.php");
    $ctrl = new administrationController();
    echo $ctrl->renderTemplate();
