<?php
require_once dirname(__DIR__)."/config.php";
class Database {
  private const DSN = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
  private $conn;

  // method adatbázis kapcsolatra
  public function __construct() {
    try {
      $this->conn = new PDO(self::DSN, DB_USER, DB_PASS);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  // reg
  public function register($name, $email, $password) {
    $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'name' => $name,
      'email' => $email,
      'password' => $password
    ]);
  }

  // bejelentkezés
  public function login($email, $password) {
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      if (password_verify($password, $user['password'])) {
        return $user;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // email létezése check
  public function getUserByEmail($email) {
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  // token
  public function setToken($email, $token) {
    $sql = 'UPDATE users SET token = :token WHERE email = :email';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'token' => $token,
      'email' => $email
    ]);

    return true;
  }

  // jelszó frissítés
  public function updatePassword($email, $password) {
    $sql = 'UPDATE users SET password = :password, token = :token WHERE email = :email';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      'password' => $password,
      'token' => null,
      'email' => $email
    ]);

    return true;
  }

  // get felhasználó token alapján
  public function getUserByToken($token) {
    $sql = 'SELECT * FROM users WHERE token = :token';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  // del felhasználó users.phpból
  public function delUser($id) {
    $sql = 'DELETE FROM users WHERE id = :id';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
  }

  // minden user rendezéssel
  public function getUsers($sort) {
    $sort = Helpers::purge($sort);
    if ($sort === 'ASC') {
      $sql = 'SELECT * FROM users ORDER BY name ASC';
    } elseif ($sort === 'DESC') {
      $sql = 'SELECT * FROM users ORDER BY name DESC';
    } else {
      $sql = 'SELECT * FROM users';
      $_SESSION['filter_active'] = 0;
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    return $users;
  }

  // szűrés
  public function filterUsers($name, $email, $created_at, $updated_at, $sort) {
    $name = Helpers::purge($name);
    $email = Helpers::purge($email);
    $created_at = Helpers::purge($created_at);
    $updated_at = Helpers::purge($updated_at);

    $sql = 'SELECT * FROM users WHERE 1=1';
    $params = array();
  
    if (!empty($name)) {
      $sql .= ' AND name LIKE :name';
      $params['name'] = '%' . $name . '%';
      $_SESSION['filter_active'] = 1;
    }
    if (!empty($email)) {
      $sql .= ' AND email LIKE :email';
      $params['email'] = '%' . $email . '%';
      $_SESSION['filter_active'] = 1;
    }
    if (!empty($created_at)) {
      $sql .= ' AND created_at BETWEEN :created_at_start AND :created_at_end';
      $params['created_at_start'] = $created_at . ' 00:00:00';
      $params['created_at_end'] = $created_at . ' 23:59:59';
      $_SESSION['filter_active'] = 1;
    }
    if (!empty($updated_at)) {
      $sql .= ' AND updated_at BETWEEN :updated_at_start AND :updated_at_end';
      $params['updated_at_start'] = $updated_at . ' 00:00:00';
      $params['updated_at_end'] = $updated_at . ' 23:59:59';
      $_SESSION['filter_active'] = 1;
    }

    // Rendezés hozzáadása a lekérdezéshez
    if ($sort === 'ASC') {
      $sql .= ' ORDER BY name ASC';
    } elseif ($sort === 'DESC') {
      $sql .= ' ORDER BY name DESC';
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    return $users;
  }
}