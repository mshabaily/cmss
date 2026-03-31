<?php

use CMSS\UserManager;

$user['id'] = (int) $_GET['id'];

$response = UserManager::getInstance()->delete($user);

send_response($response);