<?php
session_start();
$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"]. "/TechnoHouse";
define("UPLOAD_DIR", "./upload/"); //upload directory
define("TAG_LOGGED", "logged");
define("TAG_USER_ID", "idUser");
define("TAG_USER_FOLLOWERS", "followers");
define("TAG_USER_FOLLOWING", "following");
define("TAG_USER_NPHOTOS", "n-photo");
define("TAG_USER_SAVED", "saved");
define("TAG_TARGET_FOLLOWING", "target"); //upload directory
define("TAG_USER_INFO", "users-info"); //upload directory
define("TAG_USER_POST", "users-posts"); //upload directory
define("TAG_USER_EMAIL", "email");
require_once($_SERVER["DOCUMENT_ROOT"]."/model/php/util/functions.php"); //functions directory
require_once($_SERVER["DOCUMENT_ROOT"]."/database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>