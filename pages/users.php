<?php
session_start();
require_once dirname(__DIR__)."/utils/nav.php";
require_once dirname(__DIR__)."/utils/helpers.php";
require_once dirname(__DIR__)."/handlers/db.php";

if (!Helpers::isLoggedIn()) {
  Helpers::setPopUp('forgot_error', 'Felhasználó nincs bejelentkezve');
  Nav::redirect("authmodule/");
}

$sess_user = $_SESSION['user'];
$users = $_SESSION['users'];
$filter_active = $_SESSION['filter_active'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Felhasználók</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css' />
  <link rel='stylesheet' href='../styles/users.css' />
  <link rel='stylesheet' href='../styles/ui-datepicker.css' />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="../script/datepicker-settings.js"></script>
  <script src="../script/users.js"></script>
</head>

<body class="<?php if (isset($sess_user) && $sess_user && count($users) > 0) { ?>
  bg-light bg-gradient
  <?php } else { ?>
  bg-warning bg-gradient
  <?php } ?> ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 w-100 px-0">
        <div id="shadowCard" class="card shadow my-2 my-md-5">
          <div class="row card-header align-self-center w-100">
            <h2 class="fw-bold text-secondary">Felhasználók</h2>
          </div>
          <div class="card-body p-5 overflow-y-scroll">
            <?php
            echo Helpers::showPopUp('deluser_error', 'danger');
            echo Helpers::showPopUp('deluser_success', 'success');
            echo Helpers::showPopUp('filter_error', 'danger');

            if (isset($sess_user) && $sess_user) {
              for($i = 0; $i < count($users); ++$i) {?>
                <form action="<?php echo ACTION_CALL ?>" method="POST">
                  <table id="usersTable" class="table table-striped table-bordered table-hover">
                    <?php if ($sess_user['id'] != $users[$i]['id']) { ?>
                      <input type="hidden" name="deluser_id" value="<?php echo $users[$i]['id']; ?>">
                      <input type="hidden" name="deluser_email" value="<?php echo $users[$i]['email']; ?>">
                    <?php } ?>
                    <tr>
                      <th style="width: 120px !important;">Név</th>
                      <td>
                        <?php echo $users[$i]['name']; ?>
                      </td>
                      <td style="width: 80px;">
                      <?php if ($sess_user['id'] != $users[$i]['id']) { ?>
                        <input class="btn btn-sm btn-danger delete-btn" type="submit" value="Törlés" data-id="<?php echo $users[$i]['id']; ?>">
                      <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td>
                        <?php echo $users[$i]['email']; ?>
                      </td>
                      <td></td>     
                    </tr>
                    <tr>
                      <th>Létrehozva</th>
                      <td>
                        <?php echo $users[$i]['created_at']; ?>
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Frissült</th>
                      <td>
                        <?php echo $users[$i]['updated_at']; ?>
                      </td>
                      <td></td>
                    </tr>
                  </table>
                </form>
              <?php } ?>
            <?php } elseif (count($users) === 1 && $users[0]['email'] === $sess_user['email']) { ?>
              <table class="table table-striped table-bordered">
                <tr>
                  <td class="text-center">
                    <?php echo 'További adat nem elérhető, a te usered az egyetlen'; ?>
                  </td>
                </tr>
              </table>
            <?php } else { ?>
              <table class="table table-striped table-bordered">
                <tr>
                  <td class="text-center">
                    <?php echo 'Adat nem elérhető'; ?>
                  </td>
                </tr>
              </table>
            <?php } ?>
          </div>
          <div class="d-flex justify-content-between card-footer px-5 text-end">
            <div class="d-flex flex-column align-items-start">
              <form action="<?php echo ACTION_CALL ?>" method="POST" class="d-flex mb-3">
                <select name="sort_users" class="form-select">
                  <option value="ASC">Növekvő</option>
                  <option value="DESC">Csökkenő</option>
                </select>
                <input type="submit" id="sort_ok"
                  class="btn btn-danger"
                  value="Rendezd!">
              </form>
              <button id="showFormBtn" 
                class='btn <?php if ($filter_active === 1) { ?> 
                  btn-warning'>Szűrés aktív</button>
                  <form action="<?php echo ACTION_CALL ?>" method="POST" class="mt-2">
                    <input type="hidden" name="fetch_users" value="1">
                    <input type="submit" class="btn btn-warning" value="Szűrés törlése">
                  </form>
                  <?php } else { ?> btn-primary'>Szűrés</button>
                  <?php } ?>
              <form id="filterForm" action="<?php echo ACTION_CALL ?>" method="POST" class="d-flex flex-column align-items-start hidden">
                <input type="hidden" name="filter_users" value="1">
                <div class="my-1 d-flex flex-column align-items-start">
                  <label for="name">Név:</label>
                  <input type="text" id="name" name="filter_name" class="form-control">
                </div>
                <div class="my-1 d-flex flex-column align-items-start">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="filter_email" class="form-control">
                </div>
                <div class="my-1 d-flex flex-column align-items-start">
                  <label for="created_at">Létrehozás dátuma:</label>
                  <input type="text" id="created_at" name="filter_created_at" class="form-control">
                </div>
                <div class="my-1 d-flex flex-column align-items-start">
                  <label for="updated_at">Frissítés dátuma:</label>
                  <input type="text" id="updated_at" name="filter_updated_at" class="form-control">
                </div>
                <input type="submit" value="Szűrj!" class="btn btn-primary mt-3">
                <div id="closeFilter" class="btn btn-sm btn-danger hidden">X</div>
              </form>
            </div>
            <a href="/authmodule/pages/profile.php" class="btn btn-xl btn-secondary align-self-center">Saját profil</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
