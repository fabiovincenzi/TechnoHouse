<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"/>
    <link href="style/style.css" rel="stylesheet"/>
    
    <title>Document</title>
</head>
<body>
   
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
      
                  <h3 class="mb-5">Sign in</h3>
      
                  <div class="form-outline mb-4">
                    <label for="usr-email">email</label>
                    <input type="email" id="usr-email" placeholder="Email" class="form-control form-control-lg" />
                  </div>
      
                  <div class="form-outline mb-4">
                    <label for="usr-password">Password</label>
                    <input type="password" id="usr-password" placeholder="Password" class="form-control form-control-lg" />
                  </div>
      
                  <!-- Checkbox -->
                  <div class="form-check d-flex justify-content-start mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                    <label class="form-check-label" for="form1Example3"> Remember password </label>
                  </div>
                    <button class="btn btn-primary btn-lg btn-block w-100" type="submit">Login</button>
                    <span>Or </span><a href="#">Sign up</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>      

<?php if(isset($viewBag["script"])):
        foreach($viewBag["script"] as $script):?>
            <script src="<?php echo $script; ?>"></script>
<?php
        endforeach;
    endif;
?>
</body>
</html>

