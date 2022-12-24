<?php
require_once './model/php/bootstrap.php';
if(isUserLoggedIn()){
    //Base Template
    $viewBag["title"] = "Profile";
    $viewBag["page"] = "./view/primary/profile.php";
    $viewBag["script"] = array(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    );
    require './view/primary/base.php';
}
else{    
    header("location: controller_login.php");
}

?>  