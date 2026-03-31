<? if (file_exists(ROOT_PATH . '/.env')) {
    __login_redirect();
} ?>

<?php

cmss_header(); ?>

<main class="user-form flex-column" data-user-id="<?= $user_id; ?>">
    <content class="flex-column">
        <div class="card flex-column">
            <div class="title">Reset your password</div>
            <img src="<?= cmss_asset('logo-alt.png'); ?>" class="logo">
            <div class="form flex-column">
                <label for="email">Enter your email</label>
                <input name="email">
                <button class="reset-password submit dim-effect">Send Reset Link</button>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>