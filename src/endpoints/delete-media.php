<?php

use CMSS\MediaManager;
use CMSS\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

$csrfTokenManager = new CsrfTokenManager();

if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete-media', $csrf))) {
    send_response(new Response(403, 'Invalid CSRF token'));
}

$media['id'] = (int) $_GET['id'];

echo json_encode($media);

$response = MediaManager::getInstance()->delete($media);

send_response($response);