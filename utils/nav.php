<?php // navigációt segítő methodok
require_once dirname(__DIR__)."/config.php";
class Nav {
  public static function redirect( $url ) {
    $home_url = BASE_URL;
    header("location: " . $home_url . "/" . $url );
  }
}