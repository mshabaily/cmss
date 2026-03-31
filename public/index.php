<?php declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict',
]);

session_start();

require __DIR__ . '/../src/functions/utils.php';

require __DIR__ . '/../src/functions/api.php';

use CMSS\Router;
Router::getInstance()->dispatch();