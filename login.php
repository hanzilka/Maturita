<?php
session_start();
require_once("assets/php/connection.php");
require_once("Class/UserHandler.php");

$login = new UserHandler($connection);
$login->userLogin();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Přihlášení</title>
</head>
<body style="background: white !important;">
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
<section style="height: calc(100vh - 56px) !important;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">
        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
          <form method="post" style="width: 23rem;" autocomplete="off">
            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Přihlášení</h3>
            <div class="form-outline mb-4">
              <input type="text" id="user" name="user" class="form-control form-control-lg" placeholder="Jméno" autocomplete="off" required/>
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Heslo" autocomplete="off" required/>
            </div>

            <div class="pt-1 mb-4">
              <input type="submit" style="text-align: center; background: var(--blueish)" class="btn btn-block form-control form-control-lg" name="submit" value="Přihlásit se">
             <!--  <input type="checkbox" name="remember_me" class="form-check-input">
              <label class="form-check-label" for="flexCheckDefault">Zůstat přihlášen? </label> -->
            </div>
            
            <?php
            // Pokud se vyskytne chybová hláška, vytiskni jí
            if($login->getErrorMessage()) {
              echo $login->getErrorMessage();
            }
            ?>
            <p>Ještě nemáte účet? <a href="registrace.php" class="link-info">Zaregistrujte se zde</a></p>
          </form>
        </div>
      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
      <img src="pics/library.jpg"
          alt="Login image" class="w-100" style="object-fit: cover; object-position: center; height: calc(100vh - 56px) !important;">
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>