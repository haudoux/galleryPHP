<?php
    require("/var/www/html/pattern/Controller/adminController/adminStatsController.php");
    $ctrl = new adminStatsController();
    echo $ctrl->renderTemplate();
