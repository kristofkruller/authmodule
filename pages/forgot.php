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
  <title>Elfelejtett jelszó</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
</head>

<body class="bg-warning bg-gradient">

  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header">
            <h1 class="fw-bold text-secondary">Elfelejtett jelszó</h1>
          </div>
          <div class="card-body p-5">
            <?php
            echo Helpers::showPopUp('forgot_error', 'danger');
            echo Helpers::showPopUp('forgot_success', 'success');
            ?>
            <form action="<?php echo ACTION_CALL ?>" method="POST">
              <input type="hidden" name="forgot" value="1">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>
              <div class="mb-3 d-grid">
                <input type="submit" value="Visszaállító link küldése" class="btn btn-primary">
              </div>
              <p class="text-center">Még nincs profilod? <a href="/authmodule/pages/register.php">Regisztráció</a></p>
              <p class="text-center">Vissza a <a href="/authmodule">kezdőlapra</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>