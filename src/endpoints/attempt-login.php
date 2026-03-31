<?php

use CMSS\Response;
use CMSS\UserManager;

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    send_response(new Response(400, 'Missing credentials'));
}

$user_id = UserManager::getInstance()->get_user_id($email);

if (!$user_id) {
    send_response(new Response(401, 'Login Failed'));
}

if (!UserManager::getInstance()->verify_account($user_id, $password)) {
    send_response(new Response(401, 'Login Failed'));
}

cmss_login_user($user_id);
send_response(new Response(200, 'Login successful'));