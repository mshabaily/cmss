<?php

use CMSS\UserManager;
use CMSS\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

$csrfTokenManager = new CsrfTokenManager();

if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete-account', $csrf))) {
    send_response(new Response(403, 'Invalid CSRF token'));
}

$user['id'] = (int) $_GET['id'];

$response = UserManager::getInstance()->delete($user);

send_response($response);