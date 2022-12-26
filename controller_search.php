<?php
require_once './model/php/bootstrap.php';
//Base Template
$viewBag["title"] = "Search";
$viewBag["page"] = "./view/primary/search.php";
$viewBag["script"] = array(
    "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.j"
);
require './view/primary/base.php';
?>  