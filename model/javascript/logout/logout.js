axios.get('model/php/api/api-logout.php').then(response => {
    if(response.data["result"]){
        window.location.replace("./controller_login.php");   
    }else{
        window.location.replace("./index.php");
    }
});