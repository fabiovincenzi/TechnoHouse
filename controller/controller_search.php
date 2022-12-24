<?php
$_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
require_once 'bootstrap.php';
//Base Template
$viewBag["title"] = "Search";
$viewBag["page"] = "./view/primary/search.php";
$viewBag["sript"] = array(
    "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.j"
);
require './view/primary/base.php';
?>  