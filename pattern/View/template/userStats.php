<?php
    require("/var/www/html/pattern/Controller/userStatsController.php");
    $ctrl = new userStatsController();
    echo $ctrl->renderTemplate();
