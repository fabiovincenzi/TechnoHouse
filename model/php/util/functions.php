<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idUser']);
}

function registerLoggedUser($user){
    $_SESSION["idUser"] = $user["email"];
    $_SESSION["email"] = $user["password"];
}

function selectChat($chat){
    $_SESSION["idSelectedChat"] = $chat["idChat"];
}
?>