<?php

use CMSS\UserManager;

$response = UserManager::getInstance()->identify_reset_hash($_GET['hash']);

$user_id = $response->data['user_id']; ?>

<? cmss_header(); ?>

<main class="user-form flex-column" data-user-id="<?= $user_id; ?>">
    <content class="flex-column">
        <div class="card flex-column">
            <div class="title">Reset your password</div>
            <img src="<?= cmss_asset('logo-alt.png'); ?>" class="logo">
            <div class="form flex-column">
                <label for="email">Username</label>
                <input name="email">
                <label for="password">New Password</label>
                <input name="password">
                <button class="change-password submit dim-effect">Change Password</button>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?> 