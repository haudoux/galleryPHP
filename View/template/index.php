<?php
    require("/var/www/html/pattern/Controller/indexController.php");
    $ctrl = new indexController();
    if (isset($_POST['next'])) {
        echo $ctrl->renderTemplateNext();
    } elseif (isset($_POST['previous'])) {
        echo $ctrl->renderTemplatePrevious();
    } else {
        echo $ctrl->renderTemplate();
    }
