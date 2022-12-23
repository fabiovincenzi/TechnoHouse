<?php

require_once './model/php/bootstrap.php';
//Utente si sta loggando
if(isset($_POST["username"]) && isset($_POST["password"])){
    $login_result = $dbh->checkLogin($_POST["username"], $_POST["password"]);
    if(count($login_result)==0){
        //Login fallito
        $viewBag["ErrorMSG"] = "Errore! Credenziali errate";
    }
    else{
        //Login ok
        registerLoggedUser($login_result[0]);
    }
}



if(isUserLoggedIn()){
    $viewBag["titolo"] = "Blog TW - Admin";
    $viewBag["nome"] = "home.php";
    if($_GET["formmsg"]){
        $viewBag["formmsg"] = $_GET["formmsg"];      
    }
}
else{
    $viewBag["titolo"] = "Blog TW - Login";
    $viewBag["page"] = "./view/primary/login.php";    
}

//Base Template
$viewBag["title"] = "Login";
$viewBag["page"] = "./view/primary/login.php";

$viewBag["sript"] = array(
    "https://code.jquery.com/jquery-3.3.1.slim.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js",
    "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
);
require_once './view/primary/base_login.php'
?>  