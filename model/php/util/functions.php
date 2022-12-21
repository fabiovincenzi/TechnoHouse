<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idUser']);
}

function registerLoggedUser($user){
    $_SESSION["idUser"] = $user["idUser"];
    $_SESSION["email"] = $user["email"];
}

function selectChat($chat){
    $_SESSION["idSelectedChat"] = $chat["idChat"];
}
?>