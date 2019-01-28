<?php
    require("/var/www/html/pattern/Controller/loginSystem/signupSystemController.php");
    $ctrl = new signupSystemController();
    echo $ctrl->renderTemplate($_POST['username'], $_POST['email'], $_POST['pwd'], $_POST['pwd-repeat'], $_POST['package']);
