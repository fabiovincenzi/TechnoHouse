const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const chatId = urlParams.get('idChat');
const main = document.querySelector('main');

axios.get(`model/php/api/api-chat.php?idChat=${chatId}`).then(response=>{
    if (response.data["logged"]){
        main.innerHTML = generateChat(response.data['destination']);
        populateMessages(response.data['chat'], response.data['source']);
        addListener();
      } else {
        window.location.replace("./controller_login.php");   
      }
    }
);

function populateMessages(messages, source){
    let content_div = document.getElementById("messages");
    content_div.innerHTML = ""; 
    messages.forEach(element => {
        let div = "";
        if(element["me"]){
            div = `
                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                    <div>
                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">${element["body"]}</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${element["data"]}</p>
                    </div>
                    <img class="profileImg" src="" alt="${source["name"]} ${source["surname"]} profile image" />
                </div>`;
        }else{
            div = `
                    <div class="d-flex flex-row justify-content-start">
                        <img class="profileImg" src="" alt="${element["name"]} ${element["surname"]} profile image" />
                            <div>
                                <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">${element["body"]}</p>
                                <p class="small ms-3 mb-3 rounded-3 text-muted">${element["data"]}</p>
                            </div>
                    </div>`;
                
        }
        content_div.innerHTML += div; 
    });
    content_div.scrollTop = content_div.scrollHeight;
}

function addListener(){
    let input = document.getElementById('input-msg');
    input.addEventListener('keypress', function(event){
        if (event.key === 'Enter') {
            if(input.value !== ""){
                sendMessage(input.value);  
                input.value = "";
            }
        }
    });
}

function sendMessage(message){
    const formData = new FormData();
    formData.append('body', message);
    formData.append('idChat', chatId);
    axios.post('model/php/api/api-chat.php', formData).then(response => {
        reloadChat();
    });
}

function reloadChat(){
    document.getElementById("messages").innerHTML = ""; 
    axios.get(`model/php/api/api-chat.php?idChat=${chatId}`).then(response=>{
        if (response.data["logged"]){
            populateMessages(response.data['chat'], response.data['source']);
            
          } else {
            window.location.replace("./controller_login.php");   
          }
        }
    );
}

function generateChat(other_user, messages){
    let chat = `
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h5 id="other-user" class="mb-0">${other_user["name"]} ${other_user["surname"]}</h5>
          </div>
            <div id="messages" class="card-body scroll">


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