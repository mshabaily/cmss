<?php

use CMSS\MediaManager;
use CMSS\Response;

if (!isset($_FILES['file'])) {
    MediaManager::getInstance()->error('No file uploaded');
    send_response(new Response(400, 'Upload error'));
}

$file = $_FILES['file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    MediaManager::getInstance()->error('Upload error: ' . $file['error']);
    send_response(new Response(500, 'Upload error'));
}

$response = MediaManager::getInstance()->upload($file);

send_response($response);