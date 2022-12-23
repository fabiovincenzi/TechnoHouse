<?php
session_start();
define("UPLOAD_DIR", "./upload/"); //upload directory
require_once("./model/php/util/functions.php"); //functions directory
require_once("./database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>