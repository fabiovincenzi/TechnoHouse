console.log("Ciaoo");
function generateLoginForm(login_error = NULL){

    let error_msg = !login_error ? `<p>${login_error}</p>` : `<p></p>`;     
    let login_form = 
    `<form action="#" method="POST">
        ${error_msg}
        <h3 class="mb-5">Sign in</h3>
        <div class="form-outline mb-4">
        <label for="email">email</label>
        <input name="email" type="email" id="email" placeholder="Email" class="form-control form-control-lg" />
        </div>

        <div class="form-outline mb-4">
        <label for="password">Password</label>
        <input name="password" name="email" type="password" id="password" placeholder="Password" class="form-control form-control-lg" />
        </div>

        <!-- Checkbox -->
        <div class="form-check d-flex justify-content-start mb-4">
        <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
        <label class="form-check-label" for="form1Example3"> Remember password </label>
        </div>
        <input id="submit-form" class="btn btn-primary btn-lg btn-block w-100" name="submit" type="submit" value="Invia"/>
        <span>Or </span><a href="./controller_signup.php">Sign up</a>
    </form>`
}

const input = document.getElementById("submit-form");
axios.get('model/php/api/api-login.php?A=1').then(response => {
    console.log(response);
     if (response.data["logineseguito"]) {
        // Utente loggato
        //visualizzaArticoli(response.data["articoliautore"]);
     } else {
        // Utente NON loggato
        //visualizzaLoginForm();
     }
});