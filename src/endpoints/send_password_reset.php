<?php

use CMSS\Mailer;
use CMSS\UserManager;

$address = $_POST['address'];
$id = cmss_current_user()['user_id'];

$response = UserManager::getInstance()->generate_reset_hash($id);

if ($response->get_code() != 200) {
    send_response($response);
}

$hash = $response->data['hash'];

$body = "You can reset your password with this link:" . site_url() . "/reset-password?hash=" . $hash;

$response = Mailer::getInstance()->send('system@cmss.shabaily.com', $address, 'CMSS Password Reset', $body);

send_response($response);