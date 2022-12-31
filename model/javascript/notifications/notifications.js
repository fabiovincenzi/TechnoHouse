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
        axios.get(`model/php/api/api-post.php?action=3&id=${not["Post_idPost"]}`).then(post => { 
            console.log(post);
            post=post.data[0];
            axios.get(`model/php/api/api-user.php?id=${not["User_idUser"]}`).then(user => {    
                user = user.data[0]; 
                ul.innerHTML += `

                                                <li class="p-2 border-bottom bg-white">
                                                    <a href="" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">`;
                switch (not["type"]) {
                    case 'NEW_FOLLOWER':
                        ul.innerHTML += `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Follower!</p><p>${user["name"]} ${user["surname"]} started following you!</p>   
                                        </div>`;
                        break;
                    case 'NEW_SAVE':
                        ul.innerHTML += `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Save!</p><p>${user["name"]} ${user["surname"]} saved your post: </p><a>${post["title"]}</a> 
                                        </div>`;
                        break;
                    case 'NEW_QUESTION':
                        ul.innerHTML += `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Question!</p><p>${user["name"]} ${user["surname"]} asked a question to your post: </p>   
                                        </div>`;
                        break;
                    case 'NEW_ANSWER':
                        ul.innerHTML += `
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">New Answer!</p><p>${user["name"]} ${user["surname"]} answered to a question in your post: </p>   
                                        </div>`;
                        break;
                    case 'NEW_POST':
                        break;
                }
                ul.innerHTML += `
                                                        </div>
                                                    </a>
                                                </li>`;
                
                
            });
        });
    });
}