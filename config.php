<?php
include_once dirname(__DIR__)."/authmodule/vendor/autoload.php";
use Dotenv\Dotenv;

// dinamikus url generálás
define('BASE_URL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" . "://" . $_SERVER['HTTP_HOST']);
// statikus url generálás
// define('BASE_URL', "127.0.0.1");

// db cred
define('DB_HOST', '127.0.0.1:9115');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'auth');

// egyéb globális változók
define('ACTION_CALL', BASE_URL . '/authmodule/handlers/action.php');

// Looing for .env at the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// mailersend.com api
define('MAIL_API_KEY', $_ENV['MAIL_API_KEY']);
define('SENDER_MAIL', $_ENV['SENDER_MAIL']);