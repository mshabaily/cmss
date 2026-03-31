<? cmss_header(); ?>

<main class="user-form login flex-column">
    <content class="flex-column">
        <div class="card flex-column">
            <div class="title">Enter login details</div>
            <img src="<?= cmss_asset('logo-alt.png'); ?>" class="logo">
            <div class="form flex-column">
                <label for="email">Username</label>
                <input name="email">
                <label for="password">Password</label>
                <input name="password">
                <a href="/cmss/forgot-password" class="forgotten-password dim-effect">
                    Forgotten password
                </a>
                <button class="submit dim-effect">Login</button>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>