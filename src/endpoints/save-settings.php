<?php

use CMSS\Settings;

$site_title = $_POST['site_title'];
$favicon = $_POST['favicon'];

$response = Settings::getInstance()->save($site_title, $favicon);

send_response($response);