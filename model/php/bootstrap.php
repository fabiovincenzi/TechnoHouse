<?php
session_start();
$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"]. "/TechnoHouse";

define("USER_TABLE", "User");
define("MESSAGE_TABLE", "Message");


define("UPLOAD_DIR", $_SERVER["DOCUMENT_ROOT"]."/upload/"); //upload directory
define("DATA_DIR", $_SERVER["DOCUMENT_ROOT"]."/data/"); //upload directory
define("DIR_SEPARATOR", "/");

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

// CHAT
define("TAG_USER_CHAT_SOURCE", "User_idUser"); //used in api-following
define("TAG_USER_CHAT_DESTINATION", "User_idUser1"); //used in api-following
define("TAG_CHAT_ID", "idChat"); //userd in api-followers
define("TAG_SOURCE", "source"); //userd in api-followers
define("TAG_DESTINATION", "destination"); //userd in api-followers
define("TAG_USER_ALL_CHAT", "all-chat");
define("TAG_USER_SINGLE_CHAT", "chat");
define("TAG_LAST_MESSAGE", "last-message");
define("TAG_CHAT_BODY", "body");
define("TAG_CHAT_DATE", "data");
define("TAG_TOTAL_MESSAGES", "total-messages");

// ACTIONS
define("TAG_ACTION", "action");
define("TAG_ACTION_FOLLOW", "action-follow");
define("SEND_POST_USER", "1");
define("ACTION_UNFOLLOW", "1");
define("ACTION_FOLLOW", "2");
define("GET_USER_FEED", "2");
define("GET_FOLLOWERS", "1");
define("TAG_ME", "me");
define("TAG_FOLLOW", "follow");

// POST INFOS
define("TAG_POST_ID", "idPost");
define("TAG_POST_TITLE", "title");
define("TAG_GET_POST", "Post_idPost");

require_once($_SERVER["DOCUMENT_ROOT"]."/model/php/util/functions.php"); //functions directory
require_once($_SERVER["DOCUMENT_ROOT"]."/database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
?>