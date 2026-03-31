<?php

use CMSS\Mailer;
use CMSS\UserManager;
use CMSS\Response;


$address = $_POST['address'];

$id = UserManager::getInstance()->get_user_id($address);

if (!$id) {
    send_response(new Response(400, "No user with that email"));
}

$response = UserManager::getInstance()->generate_reset_hash($id);

if ($response->get_code() != 200) {
    send_response($response);
}

$hash = $response->data['hash'];

$body = "You can reset your password with this link: " . site_url() . "/cmss/reset-password?hash=" . $hash;

$response = Mailer::getInstance()->send('system@cmss.shabaily.com', $address, 'CMSS Password Reset', $body);

send_response($response);