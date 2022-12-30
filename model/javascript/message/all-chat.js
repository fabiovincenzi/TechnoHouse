const main = document.querySelector('main');

axios.get('model/php/api/api-allchat.php').then(response => {
    //console.log(response.data['all-chat']);
    if (response.data["logged"]) {
        main.innerHTML = getAllChat(response.data['all-chat']);
      } else {
        window.location.replace("./controller_login.php");   
      }
});



function getAllChat(chats){
    let content = "";
    chats.forEach(chat => {
        console.log(chat);
        let single_chat = `
                <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Chat</h5>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">

                                        <li class="p-2 border-bottom bg-white">
                                            <a href="./controller_chat.php?idChat=${chat["idChat"]}" class="d-flex justify-content-between chatListLine">
                                                <div class="d-flex flex-row">
                                                    <img src="${chat["userImage"]}" alt="${chat["name"]} ${chat["surname"]} profile image" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="60">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0">${chat["name"]} ${chat["surname"]}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
        content += single_chat
    });
    return content;
}