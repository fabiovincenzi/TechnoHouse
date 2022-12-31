const main = document.querySelector('main');

axios.get('model/php/api/api-allchat.php').then(response => {
    //console.log(response.data['all-chat']);
    if (response.data["logged"]) {
        main.innerHTML = generateBase();
        console.log(response.data);
        if(response.data['all-chat'].length > 0){
            getAllChat(response.data['all-chat']);
            addListener();
        }
      } else {
        window.location.replace("./controller_login.php");   
      }
});


function addListener(){
    let button = document.getElementById("delete-chat");
    button.addEventListener("click", function(event){
        let idChat = button.value;
        axios.get(`model/php/api/api-delete-chat.php?idChat=${idChat}`).then(response=>{
            location.reload()
        });    
    });
}

function generateBase(){
    let base = `
                <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Chat</h5>
                            <div class="card">
                                <div class="card-body">
                                    <ul id="all-chat" class="list-unstyled mb-0">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
    return base;
}


function getAllChat(chats){
    const ul = document.getElementById("all-chat");
    let content = "";
    chats.forEach(chat => {
        console.log(chat);
        let single_chat = `
                    <li class="p-2 border-bottom bg-white">
                        <a value=${chat["idChat"]} href="./controller_chat.php?idChat=${chat["idChat"]}" class="d-flex justify-content-between chatListLine">
                            <div class="d-flex flex-row">
                                <img src="${chat["userImage"]}" alt="${chat["name"]} ${chat["surname"]} profile image" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="60">
                                <div class="pt-1">
                                    <p class="fw-bold mb-0">${chat["name"]} ${chat["surname"]}</p>
                                </div>
                            </div>
                        </a>
                        <button id="delete-chat" type="button" value="${chat["idChat"]}">Delete Chat</button> 
                    </li>`;
        content += single_chat
    });
    ul.innerHTML = content;
}