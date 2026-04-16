<?php

use CMSS\PageManager;
use CMSS\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

$csrfTokenManager = new CsrfTokenManager();

if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete-page', $csrf))) {
    send_response(new Response(403, 'Invalid CSRF token'));
}

$page['id'] = (int) $_GET['id'];

$response = PageManager::getInstance()->delete($page);

send_response($response);