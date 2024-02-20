<?php
// composer
include_once"./vendor/autoload.php";
// start session
session_start();
require_once"./utils/helpers.php";
require_once"./utils/nav.php";

// átirányítás ha be van jelentkezve
if (Helpers::isLoggedIn()) {
  Nav::redirect("authmodule/pages/profile.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bejelentkezés</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
</head>

<body class="bg-dark bg-gradient">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-header">
            <h1 class="fw-bold text-secondary">Bejelentkezés</h1>
          </div>
          <div class="card-body p-5">
            <?php
            // popup ablakok 
            echo Helpers::showPopUp('register_success', 'success');
            echo Helpers::showPopUp('login_error', 'danger');

            ?>
            <form action="<?php echo ACTION_CALL ?>" method="POST">
              <input type="hidden" name="login" value="1">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <div class="mb-3">
                <a href="/authmodule/pages/forgot.php">Elfelejtett jelszó?</a>
              </div>
              <div class="mb-3 d-grid">
                <input type="submit" value="Login" class="btn btn-primary">
              </div>
              <p class="text-center">Még nincs profilod? <a href="/authmodule/pages/register.php">Regisztráció</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>