function generateLoginForm(){
    let login_form = 
    `<section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                <form action="#" method="POST">
                <p></p>
                <h3 class="mb-5">Sign in</h3>
                <div class="form-outline mb-4">
                        <label for="email">email</label>
                        <input name="email" type="email" id="email" placeholder="Email" class="form-control form-control-lg" />
                </div>
        
                <div class="form-outline mb-4">
                        <label for="password">Password</label>
                        <input name="password" name="email" type="password" id="password" placeholder="Password" class="form-control form-control-lg" />
                </div>
        
                <div class="form-check d-flex justify-content-start mb-4">
                        <input type="checkbox" id="showPassword" />
                        <label for="showPassword"> Show password</label>
                </div>
                        <input id="submit-form" class="btn btn-primary btn-lg btn-block w-100" name="submit" type="submit" value="Invia"/>
                        <span>Or </span><a href="./controller_signup.php">Sign up</a>
                </form>
                </div>
                </div>
                </div>
        </div>
        </div>
    </section>`
    return login_form;
}

function login(email, password){
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    axios.post('model/php/api/api-login.php', formData).then(response => {
        console.log(response);
        if (response.data["logged"]) {
            window.location.replace("./index.php");
        } else {
            document.querySelector("p").innerText = response.data["errorMSG"];
        }
    });
}

function visualizeLoginForm(){
    let my_form = generateLoginForm();
    main.innerHTML = my_form;
    // Gestisco tentativo di login
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault();
        const email = document.querySelector("#email").value;
        const password = document.querySelector("#password").value;
        login(email, password);
    });
}
const main = document.querySelector("main");
const input = document.getElementById("submit-form");



axios.get('model/php/api/api-login.php').then(response => {
    console.log(response);
     if (response.data["logged"]) {
        window.location.replace("./index.php");   
     } else {
        visualizeLoginForm();
        addListener();
     }
});


function addListener(){
    document.getElementById('showPassword').onclick = function() {
        if ( this.checked ) {
           document.getElementById('password').type = "text";
        } else {
           document.getElementById('password').type = "password";
        }
    };    
}