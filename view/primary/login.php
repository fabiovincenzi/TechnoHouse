<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <?php if(isset($templateParams["ErrorMSG"])): ?>
              <p><?php echo $templateParams["ErrorMSG"]; ?></p>
            <?php endif; ?>
            <h3 class="mb-5">Sign in</h3>
            <form action="#" method="POST">
            <div class="form-outline mb-4">
              <label for="email">email</label>
              <input type="email" id="email" placeholder="Email" class="form-control form-control-lg" />
            </div>

            <div class="form-outline mb-4">
              <label for="password">Password</label>
              <input type="password" id="password" placeholder="Password" class="form-control form-control-lg" />
            </div>

            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-start mb-4">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
              <label class="form-check-label" for="form1Example3"> Remember password </label>
            </div>
              <button class="btn btn-primary btn-lg btn-block w-100" id="submit-form" type="submit">Login</button>
              <span>Or </span><a href="./controller_signup.php">Sign up</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


