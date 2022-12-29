const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const chatId = urlParams.get('idChat');
const main = document.querySelector('main');

axios.get(`model/php/api/api-chat.php?idChat=${chatId}`).then(response=>{
    console.log(response);
    if (response.data["logged"]){
        main.innerHTML = generateChat(response.data['destination'], response.data['chat']);
        //aggiungo i messaggi
        addListener();
      } else {
        //window.location.replace("./controller_login.php");   
      }
    }
);

function addListener(){
    let input = document.getElementById('input-msg');
    input.addEventListener('keypress', function(event){
        if (event.key === 'Enter') {
            sendMessage(input.value);  
            input.value = "";
        }
    });
}

function sendMessage(message){
    const formData = new FormData();
    formData.append('body', message);
    formData.append('idChat', chatId);
    axios.post('model/php/api/api-chat.php', formData).then(response => {
        console.log(response);
        //aggiorno chat
    });
}

function generateChat(other_user, messages){
    console.log(c);
    let chat = `
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0"></h5>
          </div>
          <div class="card-body scroll">
            <div class="d-flex flex-row justify-content-start">
              <img class="profileImg" src=""
                alt="ALTRO">
              <div>
                <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">MESSAGGIO</p>
                <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
              </div>
            </div>

            <div class="d-flex flex-row justify-content-end mb-4 pt-1">
              <div>
                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">MESSAGGII</p>
                <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
              </div>
              <img src=""
                alt="SENDER" class="profileImg">
            </div>


          </div>
          <div class="card-footer d-flex justify-content-start align-items-center p-3">
            <label class="invisible" for="input-msg">Text a message</label>
            <input type="text" class="form-control form-control-lg" id="input-msg" placeholder="Type message">
          </div>
        </div>

      </div>
    </div>
</div>`;
return chat;
}