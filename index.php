<?php

require_once './model/php/bootstrap.php';
//Base Template
$viewBag["title"] = "TechnoHouse";
$viewBag["page"] = "./view/primary/feed.php";
$viewBag["posts"] = 0; //
$viewBag["script"] = array(
    "https://code.jquery.com/jquery-3.3.1.slim.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js",
    "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js",
    "https://unpkg.com/axios/dist/axios.min.js",
    "model/javascript/feed/feed.js"
);

require './view/primary/base.php';
?>