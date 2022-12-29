const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get('idUser');
const main = document.querySelector('main');

axios.get(`model/php/api/api-chat.php?idUser=${userId}`).then(response=>{
    console.log(response);
    if (response.data["logged"]) {
        main.innerHTML = getAllChat(response.data['all-chat']);
      } else {
        window.location.replace("./controller_login.php");   
      }
    }
);