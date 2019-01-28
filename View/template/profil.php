<?php
    require("/var/www/html/pattern/Controller/home/profilController.php");
    $ctrl = new profilController();
    echo $ctrl->renderTemplate();
