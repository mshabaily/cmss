<?php declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';

use Bepsvpt\SecureHeaders\SecureHeaders;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use CMSS\Router;

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->safeLoad();

$secureHeaders = SecureHeaders::fromFile(ROOT_PATH . '/src/config/security-headers.php');
$secureHeaders->send();

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_only_cookies', '1');

$secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict',
]);

session_start();

$csrfTokenManager = new CsrfTokenManager();

require ROOT_PATH . '/src/functions/utils.php';
require ROOT_PATH . '/src/functions/api.php';

Router::getInstance()->dispatch();