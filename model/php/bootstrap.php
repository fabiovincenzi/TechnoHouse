<?php
session_start();
$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"]. "/TechnoHouse";

define("USER_TABLE", "User");
define("MESSAGE_TABLE", "Message");
define("ERROR", "errorMSG");

define("UPLOAD_DIR", $_SERVER["DOCUMENT_ROOT"]."/upload/"); //upload directory
define("DATA_DIR", $_SERVER["DOCUMENT_ROOT"]."/data/"); //upload directory
define("DATA_RELATIVE_DIR", "/data/"); //upload relative directory
define("DIR_SEPARATOR", "/");
define("DIR_DATA_DEFAULT", "data/");

define("TAG_LOGGED", "logged");
define("TAG_USER_ID", "idUser");
define("TAG_USER_NAME", "name");

define("TAG_USER_SURNAME", "surname");
define("TAG_USER_IMAGE", "userImage");

define("TAG_USER_FOLLOWERS", "followers");
define("TAG_USER_FOLLOWING", "following");

define("TAG_USER", "user");
define("TAG_USER_NPHOTOS", "n-photo");
define("TAG_USER_SAVED", "saved");
define("TAG_TARGET_FOLLOWING", "target");
define("TAG_USER_INFO", "users-info"); //upload directory
define("TAG_USER_POST", "users-posts"); //upload directory
define("TAG_USER_EMAIL", "email");
define("TAG_USER_BIRTHDATE", "birthDate");
define("TAG_BIRTHDATE", "birthdate");
define("TAG_USER_PHONE", "phoneNumber");
define("TAG_PHONE_NUMBER", "phone-number");
define("TAG_OLD_PSW", "old-password");
define("TAG_NEW_PSW", "new-password");
define("TAG_USER_PASSWORD", "password");
define("DEFAULT_IMAGE", "default.png");
define("TAG_CONFIRM_PSW", "confirm-password");


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
define("TAG_SEARCH", "search");
define("TAG_SEPARATOR", " ");
define("TAG_ACTION_FOLLOW", "action-follow");
define("SEND_POST_USER", "1");
define("ACTION_UNFOLLOW", "1");
define("ACTION_FOLLOW", "2");
define("GET_USER_FEED", "2");
define("GET_FOLLOWERS", "1");
define("TAG_ME", "me");
define("TAG_FOLLOW", "follow");
define("GET_POST_BY_ID", "3");
define("DELETE_POST", "4");

// SEARCH
define("N_RANDOM_POSTS", 10);
define("TAG_SEARCH_POSTS", "search-post");

// POST INFOS
define("TAG_POST_USER", "User_idUser");
define("TAG_POST_ID", "idPost");
define("TAG_POST_TITLE", "title");
define("TAG_GET_POST", "Post_idPost");
define("TAG_POST_PATH", "path");

//NOTIFICATIONS TYPES
define("NEW_FOLLOWER", "newFollower");
define("NEW_SAVE", "newSave");
define("NEW_QUESTION", "newQuestion");
define("NEW_ANSWER", "newAnswer");
define("NEW_POST", "newPost");


// MAIL
define("MAIL_SOURCE", "our.project.php22@gmail.com");
define("FOLLOW_SUBJECT", "You have a new follower!");
define("WELCOME_SUBJECT", "Welcome to TechnoHouse!");
define("WELCOME_MESSAGE", "You have successfully created your account!");
define("MESSAGE_SUBJECT", "You have a new message!");
define("SETTINGS_SUBJECT", "Settings informations !");
define("IMAGE_MESSGAGE", "You have successfully changed you profile image!");
define("USER_MESSGAGE", "You have successfully changed you profile settings! It's not you ? Please contact our email our check out this video : https://www.youtube.com/watch?v=oHg5SJYRHA0");
define("PASSWORD_MESSGAGE", "You have successfully changed you password! It's not you ? Please contact our email our check out this video : https://www.youtube.com/watch?v=oHg5SJYRHA0 ");



require_once($_SERVER["DOCUMENT_ROOT"]."/database/database.php"); //database directory
$dbh = new Database("localhost", "root", "", "technohouse", 3306);
require_once($_SERVER["DOCUMENT_ROOT"]."/model/php/util/functions.php"); //functions directory
?>