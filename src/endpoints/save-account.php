<?php

use CMSS\Database;
use CMSS\UserManager;

$pdo = Database::getInstance()->pdo();

$user_id = isset($_POST['id']) ? (int) $_POST['id'] : -1;

$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$user = [
    'email' => $_POST['email'],
    'firstname' => $_POST['firstname'],
    'surname' => $_POST['surname'],
    'role' => $_POST['role'],
    'password_hash' => $hash,
    'user_id' => $user_id,
];

$response = UserManager::getInstance()->save($user);

$response->data['redirect'] = site_url() . '/cmss/account?id=' . $response->data['user_id'];

send_response($response);