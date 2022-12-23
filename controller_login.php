<?php

require_once './model/php/bootstrap.php';
//Utente si sta loggando
if(isset($_POST["email"]) && isset($_POST["password"])){
    var_dump($_POST);
    $login_result = $dbh->checkLogin($_POST["username"], $_POST["password"]);

        registerLoggedUser($login_result[0]);
        $viewBag["title"] = "Login";
        $viewBag["page"] = "./view/primary/feed.php";
        require_once './view/primary/base.php';

    
}else{
    //Base Template
    $viewBag["title"] = "Login";
    $viewBag["page"] = "./view/primary/login.php";
    $viewBag["script"] = array(
        "https://code.jquery.com/jquery-3.3.1.slim.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js",
        "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js",
        "https://unpkg.com/axios/dist/axios.min.js",
        "./model/javascript/login/login.js"
    );
    require_once './view/primary/base_login.php';
}
?>  