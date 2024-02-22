<?php
require_once dirname(__DIR__)."/utils/helpers.php";
require_once dirname(__DIR__)."/utils/nav.php";
require_once dirname(__DIR__)."/handlers/db.php";
require_once dirname(__DIR__)."/handlers/mail.php";
class AuthSystem {
  private $db;

  public function __construct() {
    session_start();
    $this->db = new Database();
  }

  public function registerUser($name, $email, $password, $confirm_password) {
    $name = Helpers::purge($name);
    $email = Helpers::purge($email);
    $password = Helpers::purge($password);
    $confirm_password = Helpers::purge($confirm_password);

    if ($password !== $confirm_password) {
      Helpers::setPopUp('register_error', 'A jelszavak nem egyeznek!');
      Nav::redirect("authmodule/pages/register.php");
    } else {
      $user = $this->db->getUserByEmail($email);
      if ($user) {
        Helpers::setPopUp('register_error', 'Az email cím már létezik!');
        Nav::redirect("authmodule/pages/register.php");
      } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $this->db->register($name, $email, $hashed_password);
        Helpers::setPopUp('register_success', 'Regisztráció sikeres, most már bejelentkezhetsz!');
        Nav::redirect("authmodule");
      }
    }
  }

  public function loginUser($email, $password) {
    $email = Helpers::purge($email);
    $password = Helpers::purge($password);

    $user = $this->db->login($email, $password);
    if ($user) {
      unset($user['password']);
      $_SESSION['user'] = $user;
      Nav::redirect("authmodule/pages/profile.php");
    } else {
      Helpers::setPopUp('login_error', 'Hibás bejelentkezési adatok!');
      Nav::redirect("authmodule");
    }
  }

  public function logoutUser() {
    unset($_SESSION['user']);
    Nav::redirect("authmodule");
  }

  public function forgotPassword($email) {
    // user kinyerése dbből
    $email = Helpers::purge($email);
    $user = $this->db->getUserByEmail($email);
    if ($user) {
      // reset tokennel
      $token = bin2hex(random_bytes(50));
      $this->db->setToken($email, $token);
      $link = BASE_URL . 'authmodule/pages/reset.php?email=' . $email . '&token=' . $token;
      
      // az email html szövegének összeállítása
      $message = '<p>Szia ' . $user['name'] . ',</p><p>kérlek kattints az alábbi linkre hogy visszaállítsd a jelszavad:</p><p><a href="' . $link . '">' . $link . '</a></p>';

      $mailData = [
        "to" => $user["email"],
        "name" => $user["name"],
        "html_body" => $message
      ];

      if (Mail::sendMail($mailData)) {
        Helpers::setPopUp('forgot_success', 'A visszaállításhoz szükséges link elküldve a megadott emailcímre!');
        Nav::redirect("authmodule/pages/forgot.php");
      } else {
        Helpers::setPopUp('forgot_error', 'Hiba történt a email feldolgozása során!');
        Nav::redirect("authmodule/pages/forgot.php");
      }
    } else {
      Helpers::setPopUp('forgot_error', 'Az email nem létezik!');
      Nav::redirect("authmodule/pages/forgot.php");
    }
  }

  public function resetPassword($token, $password, $confirm_password) {
    $token = Helpers::purge($token);
    $password = Helpers::purge($password);
    $confirm_password = Helpers::purge($confirm_password);

    if ($password !== $confirm_password) {
      Helpers::setPopUp('reset_error', 'A jelszavak nem egyeznek!');
      Nav::redirect("authmodule/pages/reset.php?token=" . $token);
    } else {
      $user = $this->db->getUserByToken($token);
      if ($user) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $this->db->updatePassword($user['email'], $hashed_password);
        Helpers::setPopUp('reset_success', 'A jelszó visszaállítás sikeres!');
        Nav::redirect("authmodule/pages/reset.php?token=" . $token);
      } else {
        Helpers::setPopUp('reset_error', 'Érvénytelen token!');
        Nav::redirect("authmodule/pages/reset.php?token=" . $token);
      }
    }
  }
  public function deleteUser($id, $email) {  
    $id = Helpers::purge($id);
    $email = Helpers::purge($email);
    $this->db->delUser($id);
    
    $deletedUser = $this->db->getUserByEmail($email);
    if (!$deletedUser) {
      Helpers::setPopUp('deluser_success', $email . " email című felhasználó törlése sikeres");
      Nav::redirect("authmodule/pages/users.php");
    } else {
      Helpers::setPopUp('deluser_error', $email . " email című felhasználó törlése sikertelen");
      Nav::redirect("authmodule/pages/users.php");
    }
  }

  public function getUsers($sort) {
    $users = $this->db->getUsers($sort);
    $_SESSION['users'] = $users;
    $_SESSION['sorting'] = $sort;
    Nav::redirect("authmodule/pages/users.php");
  }

  public function filterUsers($name, $email, $created_at, $updated_at) {
    $users = $this->db->filterUsers($name, $email, $created_at, $updated_at, $_SESSION['sorting']);
    if (count($users) < 1) {
      Helpers::setPopUp('filter_error', 'Az adott szűrésre nincs találat!');
      $_SESSION['filter_active'] = 0;
      Nav::redirect("authmodule/pages/users.php");
    } else {
      $_SESSION["users"] = $users;
      Nav::redirect("authmodule/pages/users.php");
    }
  }
}

$authSystem = new AuthSystem();

if (isset($_POST['register'])) {
  $authSystem->registerUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
} elseif (isset($_POST['login'])) {
  $authSystem->loginUser($_POST['email'], $_POST['password']);
} elseif (isset($_GET['logout'])) {
  $authSystem->logoutUser();
} elseif (isset($_POST['forgot'])) {
  $authSystem->forgotPassword($_POST['email']);
} elseif (isset($_POST['reset'])) {
  $authSystem->resetPassword($_POST['token'], $_POST['password'], $_POST['confirm_password']);
} elseif (isset($_POST['fetch_users'])) {
  $authSystem->getUsers($_POST['fetch_users']);
} elseif (isset($_POST['deluser_id']) && isset($_POST['deluser_email'])) {
  $authSystem->deleteUser($_POST['deluser_id'], $_POST['deluser_email']);
} elseif (isset($_POST['sort_users'])) {
  $authSystem->getUsers($_POST['sort_users']);
} elseif (isset($_POST['filter_users'])) {
  $authSystem->filterUsers($_POST['filter_name'], $_POST['filter_email'], $_POST['filter_created_at'], $_POST['filter_updated_at']);
}