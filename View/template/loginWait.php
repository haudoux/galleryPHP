<?php
    require("/var/www/html/pattern/Controller/loginSystem/loginSystemController.php");
    $ctrl = new loginSystemController();
    echo $ctrl->renderTemplate($_POST['username'], $_POST['password']);
