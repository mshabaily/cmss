<?php

use CMSS\Response;
use CMSS\UserManager;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

$csrfTokenManager = new CsrfTokenManager();

if (!$csrfTokenManager->isTokenValid(new CsrfToken('login_form', $csrf))) {
    send_response(new Response(403, 'Invalid CSRF token'));
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    send_response(new Response(400, 'Missing credentials'));
}

$user_id = UserManager::getInstance()->get_user_id($email);

if (!$user_id) {
    send_response(new Response(401, 'Login Failed'));
}

if (!UserManager::getInstance()->verify_account($user_id, $password)) {
    send_response(new Response(401, 'Login Failed'));
}

cmss_login_user($user_id);
send_response(new Response(200, 'Login successful'));