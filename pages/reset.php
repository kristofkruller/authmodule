<?php
session_start();
require_once dirname(__DIR__)."/utils/nav.php";
require_once dirname(__DIR__)."/utils/helpers.php";

if (Helpers::isLoggedIn()) {
  Nav::redirect('authmodule/pages/profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jelszó visszaállítása</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
</head>

<body class="bg-success bg-gradient">
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
      <div class="col-lg-5">
        <div class="card shadow">
          <div class="card-header">
            <h1 class="fw-bold text-secondary">Jelszó visszaállítása</h1>
          </div>
          <div class="card-body p-5">
            <?php
            echo Helpers::showPopUp('reset_error', 'danger');
            echo Helpers::showPopUp('reset_success', 'success');
            ?>
            <form action="<?php echo ACTION_CALL ?>" method="POST">
              <input type="hidden" name="reset" value="1">
              <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
              <div class="mb-3">
                <label for="password" class="form-label">Új jelszó</label>
                <input type="password" name="password" class="form-control" id="password" required>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Jelszó megerősítése</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
              </div>
              <div class="d-grid">
                <input type="submit" class="btn btn-danger" value="Reset Password">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>