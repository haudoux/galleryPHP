<?php
    require("/var/www/html/pattern/Controller/searchController.php");
    $ctrl = new searchController();
    if (isset($_POST['next'])) {
        echo $ctrl->renderTemplateNext();
    } elseif (isset($_POST['previous'])) {
        echo $ctrl->renderTemplatePrevious();
    } else if (isset($_POST['search'])){
        echo $ctrl->renderTemplate($_POST['search']);
    } else {
        header("Location: index.php");
    }
