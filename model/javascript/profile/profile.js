function generateProfile(){
    let page = `
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">
 
              <div class="p-4 bg-black row">
                    <div class="mr-3 col-5">
                        <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="text-white col-7">
                        <h4 id="name-surname">NAME-SURNAME</h4>
                    </div>
              </div>
              <div class="border-bottom p-4 justify-content-end text-center">
                 <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                       <h5 class="font-weight-bold mb-0 d-block" id="n-photo" >N-PHOTO</h5>
                       <small class="text-muted"> <em class="fas fa-image mr-1"></em>Photos</small> 
                    </li>
                    <li class="list-inline-item">
                       <h5 class="font-weight-bold mb-0 d-block"id="followers">FOLLOWERS</h5>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Followers</small> 
                    </li>
                    <li class="list-inline-item">
                       <h5 class="font-weight-bold mb-0 d-block" id="following">FOLLOWING</h5>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Following</small> 
                    </li>
                    <li class="list-inline-item">
                        <h5 class="font-weight-bold mb-0 d-block" id="saved">SAVED</h5>
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
                    <div class="col-lg-6 mb-2 pr-lg-1">
                     <a id="ID-POST">
                        <img src="" alt="DESCRIZIONE POST" class="img-fluid rounded shadow-sm">
                     </a>
                  </div>
                 </div>
              </div>
           </div>
        </div>
    `
    return page;
}

function visualizeProfile(){
   let profie = generateProfile();
   main.innerHTML = profie;
}

const main = document.querySelector("main");
axios.get('model/php/api/api-profile.php').then(response => {
   console.log(response);
   if(response.data["logged"]){
      visualizeProfile();
   }else{
      window.location.replace("./controller_login.php");   
   }
});