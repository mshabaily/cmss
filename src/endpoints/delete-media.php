<?php

use CMSS\MediaManager;

$media['id'] = (int) $_GET['id'];

echo json_encode($media);

$response = MediaManager::getInstance()->delete($media);

send_response($response);