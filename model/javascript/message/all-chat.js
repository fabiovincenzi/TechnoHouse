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
    chats.forEach(user => {
        let all_chat = `
                <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Chat</h5>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">

                                        <li class="p-2 border-bottom bg-white">
                                            <a href="#!" class="d-flex justify-content-between chatListLine">
                                                <div class="d-flex flex-row">
                                                    <img src="" alt=""
                                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="60">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0">${user["name"]} ${user["surname"]}</p>
                                                        <p class="small text-muted">Hello, Are you there?</p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="small text-muted mb-1">Just now</p>
                                                    <span class="badge bg-danger float-end">1</span>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
    });
    return content;
}