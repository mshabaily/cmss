<?php

use CMSS\UserManager;
use CMSS\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

$csrfTokenManager = new CsrfTokenManager();

if (!$csrfTokenManager->isTokenValid(new CsrfToken('change-password', $csrf))) {
    send_response(new Response(403, 'Invalid CSRF token'));
}

$user_id = (int) $_POST['user_id'];
$current_user = cmss_user($user_id);

if ($current_user['email'] != $_POST['email']) {
    send_response(new Response(401, "Username doesn't match the account associated with the reset link"));
}

$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$user = [
    'email' => $current_user['email'],
    'firstname' => $current_user['firstname'],
    'surname' => $current_user['surname'],
    'role' => $current_user['role'],
    'password_hash' => $hash,
    'user_id' => $user_id,
];

$response = UserManager::getInstance()->save($user);

$response->data['redirect'] = site_url() . '/cmss';

send_response($response);