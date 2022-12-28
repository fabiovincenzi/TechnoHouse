<?php
session_start();
$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"]. "/TechnoHouse";
define("UPLOAD_DIR", $_SERVER["DOCUMENT_ROOT"]."/upload/"); //upload directory
define("TAG_LOGGED", "logged");
define("TAG_USER_ID", "idUser");
define("TAG_USER_NAME", "name");
define("TAG_USER_SURNAME", "surname");
define("TAG_USER_IMAGE", "");

define("TAG_USER_FOLLOWERS", "followers");
define("TAG_USER_FOLLOWING", "following");

define("TAG_USER_NPHOTOS", "n-photo");
define("TAG_USER_SAVED", "saved");
define("TAG_TARGET_FOLLOWING", "target");
define("TAG_USER_INFO", "users-info"); //upload directory
define("TAG_USER_POST", "users-posts"); //upload directory
define("TAG_USER_EMAIL", "email");
define("TAG_USER_TO_FOLLOW", "User_idUser1"); //used in api-following
define("TAG_USER_THAT_FOLLOWS", "User_idUser"); //userd in api-followers


define("TAG_ACTION", "action");
define("SEND_POST_USER", "1");
define("GET_FOLLOWERS", "1");


// POST INFOS
define("TAG_POST_ID", "idPost");
define("TAG_POST_TITLE", "title");
define("TAG_GET_POST", "Post_idPost");


require_once($_SERVER["DOCUMENT_ROOT"]."/model/php/util/functions.php"); //functions directory
require_once($_SERVER["DOCUMENT_ROOT"]."/database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>