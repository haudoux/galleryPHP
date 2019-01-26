<?php
    require("/var/www/html/pattern/Controller/profilController.php");
    $ctrl = new profilController();
    echo $ctrl->renderTemplate();
