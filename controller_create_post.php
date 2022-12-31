<?php
require_once './model/php/bootstrap.php';
//if(isUserLoggedIn()){
    //Base Template
    $viewBag["title"] = "Create Post";
    $viewBag["script"] = array(
        "https://code.jquery.com/jquery-3.3.1.slim.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js",
        "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js",
        "https://unpkg.com/axios/dist/axios.min.js",
        "model/javascript/post/createPost.js",
        "https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg"
    );
    require './view/primary/base.php';
    /*
}
else{
    header("location: controller_login.php");
}
*/
?>  