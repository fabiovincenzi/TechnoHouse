<?php
session_start();
$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"]. "/TechnoHouse";
define("UPLOAD_DIR", "./upload/"); //upload directory
define("TAG_USER_ID", "idUser"); //upload directory
require_once($_SERVER["DOCUMENT_ROOT"]."/model/php/util/functions.php"); //functions directory
require_once($_SERVER["DOCUMENT_ROOT"]."/database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>