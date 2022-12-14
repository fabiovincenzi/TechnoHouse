<?php
require_once './model/php/bootstrap.php';
//Base Template
if (isUserLoggedIn()) {
    $viewBag["title"] = "Image Settings";
    $viewBag["script"] = array(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js",
        "https://unpkg.com/axios/dist/axios.min.js",
        "https://code.jquery.com/jquery-3.5.1.min.js",
        "./model/javascript/settings/settings-image.js",
        "cropperjs/cropper.min.js"
    );
    require './view/primary/base_login.php';
}else{
    header("location: controller_login.php");
}
?>  