<?php
    require("/var/www/html/pattern/Controller/adminStatsController.php");
    $ctrl = new adminStatsController();
    echo $ctrl->renderTemplate();
