<?php
session_start();
require_once dirname(__DIR__)."/utils/nav.php";
require_once dirname(__DIR__)."/utils/helpers.php";

// session user
$user = null;
if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
  $user = $_SESSION['user'];
}

if (!Helpers::isLoggedIn() || $user == null) {
  Helpers::setPopUp('forgot_error', 'Felhasználó nincs bejelentkezve');
  Nav::redirect("authmodule/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Felhasználók</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
</head>

<body class="bg-success bg-gradient">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-lg-5">
        <div class="card shadow">
          <div class="card-header">
            <h2 class="fw-bold text-secondary">Felhasználók</h2>
          </div>
          <div class="card-body p-5">
            <?php 
            
            ?>
            <table class="table table-striped table-bordered">
              <tr>
                <th>Név</th>
                <td>
                  <?php 
                  if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
                    echo $user['name'];
                  } else {
                    echo 'Adat nem elérhető';
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <th>Email</th>
                <td>
                  <?php 
                  if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
                    echo $user['email'];
                  } else {
                    echo 'Adat nem elérhető';
                  }
                  ?>
                </td>              
              </tr>
              <tr>
                <th>Létrehozva</th>
                <td>
                  <?php 
                  if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
                    echo $user['created_at'];
                  } else {
                    echo 'Adat nem elérhető';
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <th>Frissült</th>
                <td>
                  <?php 
                  if (isset($_SESSION['user']) && $_SESSION['user'] !== null) {
                    echo $user['updated_at'];
                  } else {
                    echo 'Adat nem elérhető';
                  }
                  ?>
                </td>
              </tr>
            </table>
          </div>
          <div class="card-footer px-5 text-end">
            <a href="/authmodule/pages/profile.php" class="btn btn-light">Saját profil</a>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>

</html>
