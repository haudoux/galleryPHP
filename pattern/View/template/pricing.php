<?php
    require("/var/www/html/pattern/Controller/pricingController.php");
    if (isset($_POST['buy'])) {
        $ctrl = new pricingController();
        echo $ctrl->setPackage($_POST['id']);
    } else {
        $ctrl = new pricingController();
        echo $ctrl->RenderTemplate();
    }
