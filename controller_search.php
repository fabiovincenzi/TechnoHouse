<?php
require_once './model/php/bootstrap.php';
if (isUserLoggedIn()) {
    //Base Template
    $viewBag["title"] = "Search";
    $viewBag["script"] = array(
        "https://unpkg.com/axios/dist/axios.min.js",
        "./model/javascript/search/search.js"
    );
    require './view/primary/base.php';
}else{
    header("location: controller_login.php");
}
?>  