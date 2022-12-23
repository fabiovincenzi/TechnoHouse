<?php
require_once './model/php/bootstrap.php';
if(isUserLoggedIn()){
    //Base Template
    $viewBag["title"] = "Notification";
    $viewBag["page"] = "./view/primary/notification.php";
    $viewBag["sript"] = array(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    );
    require './view/primary/base.php';
}
else{
    $viewBag["titolo"] = "Blog TW - Login";
    $viewBag["page"] = "./view/primary/login.php";
    require_once './view/primary/base_login.php';
}

?>  