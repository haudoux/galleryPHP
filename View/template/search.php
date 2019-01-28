<?php
    require("/var/www/html/pattern/Controller/home/searchController.php");
    $ctrl = new searchController();
    if (isset($_POST['next'])) {
        echo $ctrl->renderTemplateNext();
    } elseif (isset($_POST['previous'])) {
        echo $ctrl->renderTemplatePrevious();
    } elseif (isset($_POST['search'])) {
        echo $ctrl->renderTemplate($_POST['search']);
    } else {
        header("Location: index.php");
    }
