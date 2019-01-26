<?php
    require("/var/www/html/pattern/Controller/downloadController.php");
    if (isset($_POST['sepia'])) {
        $ctrl = new downloadController();
        echo $ctrl->renderModifyPicture($_POST['id'],$_POST['sepia'], $_POST['blurRadius'], $_POST['width'], $_POST['height'], $_POST['original']);
    } else {
        $ctrl = new downloadController();
        echo $ctrl->renderTemplate($_POST['id']);
    }
