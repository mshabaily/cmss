<?php

use CMSS\PageManager;

$page['id'] = (int) $_GET['id'];

$response = PageManager::getInstance()->delete($page);

send_response($response);