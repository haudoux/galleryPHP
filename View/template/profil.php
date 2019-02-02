<?php
    require("/var/www/html/pattern/Controller/userSystem/profilController.php");
    $ctrl = new profilController();
    echo $ctrl->renderTemplate();
