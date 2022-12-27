function generateProfile(user){
    let page = `
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">
 
              <div class="p-4 bg-black row">
                    <div class="mr-3 col-5">
                        <img src="" alt="${user[0]["name"]} ${user[0]["surname"]} profile photo" width="130" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="text-white col-7">
                        <h4 id="name-surname">${user[0]["name"]} ${user[0]["surname"]}</h4>
                    </div>
              </div>
              <div class="border-bottom p-4 justify-content-end text-center">
                 <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                       <h5 class="font-weight-bold mb-0 d-block" id="n-photo">${user["n-photo"]}</h5>
                       <small class="text-muted"> <em class="fas fa-image mr-1"></em>Photos</small> 
                    </li>
                    <li class="list-inline-item">
                       <a class="font-weight-bold mb-0 d-block" id="followers" data-bs-toggle="modal" data-bs-target="#modal-info">
                        ${user["followers"]}
                       </a>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Followers</small> 
                    </li>
                    <li class="list-inline-item">
                       <a class="font-weight-bold mb-0 d-block" id="following" data-target="modal-info">${user["following"]}</a>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Following</small> 
                    </li>
                    <li class="list-inline-item">
                        <a class="font-weight-bold mb-0 d-block" id="saved" data-target="modal-info">${user["saved"]}</a>
                        <small class="text-muted"> <em class="fas fa-user mr-1"></em>Saved</small> 
                     </li>
                 </ul>
              </div>
              <div class="px-4 py-3">
                 <h5 class="mb-0">About</h5>
                 <div class="p-4 rounded shadow-sm bg-light">
                    <p class="font-italic mb-0">Web Developer</p>
                    <p class="font-italic mb-0">Lives in New York</p>
                    <p class="font-italic mb-0">Photographer</p>
                 </div>
              </div>
              <div class="py-4 px-4">
                 <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Recent photos</h5>
                    <a href="#" class="btn btn-link text-muted">Show all</a> 
                 </div>
                 <div class="row">
                    <div class="col-lg-6 mb-2 pr-lg-1" id="users-posts">
                  </div>
                 </div>
              </div>
           </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    `
    return page;
}

function generatePosts(posts){
   posts.forEach(post => {
      let single_post = `
      <a id="${post["idPost"]}">
         <img src="${post["image"]}" alt="${post["name"]} photo" class="img-fluid rounded shadow-sm">
      </a>`;
      div_posts.innerHTML+=single_post;
   });
}

function addListeners(){
   const modal = document.getElementById("modal-info");
   document.getElementById('followers').addEventListener("click", function(evenet){
      console.log(modal);
      modal.title = 'followers';
   });
   document.getElementById('following').addEventListener("click", function(evenet){
   });
   document.getElementById('saved').addEventListener("click", function(evenet){

   });
}

function addUserInfo(user_infos){
   main.innerHTML = user_infos;
}

function visualizeProfile(){
   let posts = {};
   let user = {};
   axios.get('model/php/api/api-post.php').then(response => {
      console.log(response.data);
      if(response.data["logged"]){
         user = response.data["users-info"];
         posts = response.data["users-posts"];
         let content_profile = generateProfile(user);
         addUserInfo(content_profile);
         addListeners();
         generatePosts(posts);
      }else{
         window.location.replace("./controller_login.php");   
      }
   });

}

const main = document.querySelector("main");
const div_posts = document.getElementById("users-posts");
axios.get('model/php/api/api-profile.php').then(response => {
   console.log(response);
   if(response.data["logged"]){
      visualizeProfile();
   }else{
      window.location.replace("./controller_login.php");   
   }
});

