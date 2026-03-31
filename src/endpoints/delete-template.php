<?php

use CMSS\TemplateManager;

$template['id'] = (int) $_GET['id'];

$response = TemplateManager::getInstance()->delete($template);

send_response($response);