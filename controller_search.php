<?php
require_once './model/php/bootstrap.php';
if (isUserLoggedIn()) {
    //Base Template
    $viewBag["title"] = "Search";
    $viewBag["page"] = "./view/primary/search.php";
    $viewBag["script"] = array(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.j",
        "https://unpkg.com/axios/dist/axios.min.js",
        "./model/javascript/search/search.js"
    );
    require './view/primary/base.php';
}else{
    header("location: controller_login.php");
}
?>  