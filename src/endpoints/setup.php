<?php

if (file_exists(ROOT_PATH . '/.env')) {
    __login_redirect();
}

cmss_header(); ?>

<main class="user-form database flex-column">
    <content class="flex-column">
        <div class="card flex-column">
            <div class="title">Database Setup</div>
            <div class="form flex-column">
                <p>To get started with CMSS, enter the details of your database</p>
                <label for="db_host">Database Host</label>
                <input name="db_host">
                <label for="db_name">Database Name</label>
                <input name="db_name">
                <label for="db_username">Database Username</label>
                <input name="db_username">
                <label for="db_user_password">Database User Password</label>
                <input name="db_user_password">
                <button class="install-database submit dim-effect">Install tables</button>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>