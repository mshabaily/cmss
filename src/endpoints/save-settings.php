<?php

use CMSS\Settings;

$site_title = $_POST['site_title'];
$favicon = $_POST['favicon'];
$front_page = $_POST['front_page'];

$response = Settings::getInstance()->save($site_title, $favicon, $front_page);

send_response($response);