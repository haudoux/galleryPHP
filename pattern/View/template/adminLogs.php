<?php
    require("/var/www/html/pattern/Controller/adminLogsController.php");
    $ctrl = new adminLogsController();
    echo $ctrl->renderTemplate();
