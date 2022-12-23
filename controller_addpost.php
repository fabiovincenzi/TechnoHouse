<?php
if (isset($_SESSION["id"])) {
    require_once './model/php/bootstrap.php';
    //Base Template
    $viewBag["title"] = "Add post";
    $viewBag["page"] = "./view/primary/add_post.php";
    $viewBag["sript"] = array(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.j"
    );
    require './view/primary/base.php';
}else{
    //redirect to the login
    require 'controller_login.php';
}
?>  