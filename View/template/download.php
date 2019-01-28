<?php
    require("/var/www/html/pattern/Controller/downloadSystem/downloadController.php");
    if (isset($_POST['sepia'])) {
        $ctrl = new downloadController();
        echo $ctrl->renderModifyPicture($_POST['id'], $_POST['sepiaEnable'], $_POST['sepia'], $_POST['blurEnable'], $_POST['blurRadius'], $_POST['resizeEnable'], $_POST['percent'], $_POST['original']);
    } else {
        $ctrl = new downloadController();
        echo $ctrl->renderTemplate($_POST['id']);
    }
