<?php

function isUserLoggedIn(){
    return !empty($_SESSION['iduser']);
}

function registerLoggedUser($user){
    $_SESSION["iduser"] = $user["iduser"];
    $_SESSION["email"] = $user["email"];
}
?>