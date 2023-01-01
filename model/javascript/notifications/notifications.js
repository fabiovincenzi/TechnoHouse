const main = document.querySelector('main');

axios.get('model/php/api/api-notifications.php').then(response => {
    console.log(response);
    main.innerHTML = generateBase();
    getAllNotifications(response.data);
});

function generateBase(){
    let base = `
                <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Notifications</h5>
                            <div class="card">
                                <div class="card-body">
                                    <ul id="notifications" class="list-unstyled mb-0">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
    return base;
}



function getAllNotifications(notifications){
    const ul = document.getElementById("notifications");
    notifications.forEach(not => {
        ul.innerHTML += `
                        <li class="p-2 border-bottom bg-white">
                                <div id="notification${not["idNotification"]}" class="d-flex flex-row">
                                </div>
                        </li>`;            
        axios.get(`model/php/api/api-user.php?id=${not["User_idUser"]}`).then(user => {    
            user = user.data[0]; 
            axios.get(`model/php/api/api-post.php?action=3&idPost=${not["Post_idPost"]}`).then(post => {
                const el = document.getElementById(`notification${not["idNotification"]}`);
                console.log(not["type"]);
                post=post.data[0];
                switch (not["type"]) {
                    case 'NEW_FOLLOWER':
                        el.innerHTML = `
                                        <div class="pt-1">
                                        <p class="fw-bold mb-0">New Follower!</p><a href="./controller_otheruser.php?idUser=${user["idUser"]}">${user["name"]} ${user["surname"]} </a><p>started following you!</p>   
                                        </div>`;
                        break;
                    case 'NEW_SAVE':
                        el.innerHTML = `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Save!</p><p>${user["name"]} ${user["surname"]} saved your post: </p><a href="./controller_single_post.php?idPost=${ ["idPost"]}">${post["title"]}</a> 
                                        </div>`;
                        break;
                    case 'NEW_QUESTION':
                        el.innerHTML = `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Question!</p><p>${user["name"]} ${user["surname"]} asked a question to your post: </p><a href="./controller_single_post.php?idPost=${post["idPost"]}">${post["title"]}</a>   
                                        </div>`;
                        break;
                    case 'NEW_ANSWER':
                        el.innerHTML = `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Answer!</p><p>${user["name"]} ${user["surname"]} answered to a question in your post: </p><a href="./controller_single_post.php?idPost=${post["idPost"]}">${post["title"]}</a>   
                                        </div>`;
                        break;
                    case 'NEW_POST':
                        el.innerHTML = `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Post!</p><p>${user["name"]} ${user["surname"]} that you follow added a new post:</p><a href="./controller_single_post.php?idPost=${post["idPost"]}">${post["title"]}</a>   
                                        </div>`;
                        break;
                    case 'NEW_MESSAGE':
                        el.innerHTML = `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New message!</p><p>${user["name"]} ${user["surname"]} sent you a</p><a href="./controller_chat.php?idChat=${not["Chat_idChat"]}">message</a>   
                                        </div>`;
                        break;
                }
            });
        });
    });
}