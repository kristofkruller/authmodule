<?php
session_start();
require_once dirname(__DIR__)."/utils/nav.php";
require_once dirname(__DIR__)."/utils/helpers.php";

if (Helpers::isLoggedIn()) {
  Nav::redirect("authmodule/pages/profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regisztráció</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
</head>

<body class="bg-dark bg-gradient">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header">
            <h1 class="fw-bold text-secondary">Regisztráció</h1>
          </div>
          <div class="card-body p-5">
            <?php
            // Display error message if any
            echo Helpers::showPopUp('register_error', 'danger');
            ?>
            <form action="<?php echo ACTION_CALL ?>" method="POST">
              <input type="hidden" name="register" value="1">
              <div class="mb-3">
                <label for="name" class="form-label">Név</label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Jelszó megerősítése</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
              </div>
              <div class="mb-3 d-grid">
                <input type="submit" value="Regisztráció" class="btn btn-primary">
              </div>
              <p class="text-center">Van már regisztrált profilod? <a href="/authmodule">Bejelentkezés</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>