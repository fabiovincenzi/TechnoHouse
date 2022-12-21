<?php
session_start();
define("UPLOAD_DIR", "./upload/"); //upload directory
require_once("utils/functions.php"); //functions directory
require_once("db/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>