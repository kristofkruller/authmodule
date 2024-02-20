<?php // alap mechanizmusok 
class Helpers {
  // string adat "tisztítás"
  public static function purge( $data ) {
    $data = trim( $data );
    $data = htmlspecialchars( $data );
    $data = stripcslashes( $data );
    return $data;
  }

  // bejelentkezés check
  public static function isLoggedIn() {
    if ( isset( $_SESSION["user"] ) ) {
      return true;
    } else {
      return false;
    }
  }

  // method popup beállítására
  public static function setPopUp($name, $message) {
    if (!empty($_SESSION[$name])) {
      unset($_SESSION[$name]);
    }
    
    $_SESSION[$name] = $message;
  }
  
  // method popup megjelenítésére
  public static function showPopUp($name, $type) {
    if (isset($_SESSION[$name])) {
      echo '<div class="alert alert-' . $type . '">' . $_SESSION[$name] . '</div>';
      unset($_SESSION[$name]);
    }
  }
}