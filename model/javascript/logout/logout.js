axios.get('model/php/api/api-logout.php').then(response => {
    console.log(response);
    if(response.data["result"]){
        window.location.replace("./controller_login.php");   
    }else{
        window.location.replace("./index.php");
    }
});