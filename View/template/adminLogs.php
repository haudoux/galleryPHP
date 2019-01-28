<?php
    require("/var/www/html/pattern/Controller/adminController/adminLogsController.php");
    $ctrl = new adminLogsController();
    echo $ctrl->renderTemplate();
