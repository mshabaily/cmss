<header class="flex-column">
    <div class="wrapper flex-row">
        <div class="start flex-row">
            <a href="<?= site_url(); ?>/cmss">
                <img src="<?= cmss_asset('logo.png'); ?>">
            </a>
        </div>
        <div class="end flex-row">
            <div class="search flex-row">
                <input placeholder="Search...">
                <img src="<?= cmss_asset('search.png'); ?>">
            </div>
            <img src="<?= cmss_asset('profile_placeholder.png'); ?>">
        </div>
        <div class="burger flex-column dim-effect">
            <rect></rect>
            <rect></rect>
            <rect></rect>
        </div>
    </div>
    <div class="body-dim" style="display: none;"></div>
</header>