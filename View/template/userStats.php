<?php
    require("/var/www/html/pattern/Controller/userSystem/userStatsController.php");
    $ctrl = new userStatsController();
    echo $ctrl->renderTemplate();
