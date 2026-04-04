<!DOCTYPE html>
<html>

<head>
    <? use CMSS\Settings; ?>

    <meta name="viewport" content="width=device-width">

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/hugerte@1/skins/ui/oxide/skin.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/hugerte@1/skins/content/default/content.min.css">
    <script src="https://cdn.jsdelivr.net/npm/hugerte@1/hugerte.min.js"></script>

    <? $js_dir = ROOT_PATH . '/public/js';
    $js = glob($js_dir . '/*.js');

    foreach ($js as $file) {
        $name = basename($file);
        echo '<script src="/public/js/' . $name . '"></script>' . PHP_EOL;
    } ?>

    <? $css_dir = ROOT_PATH . '/public/css';
    $css = glob($css_dir . '/*.css');

    foreach ($css as $file) {
        $name = basename($file);
        echo '<link rel="stylesheet" href="/public/css/' . $name . '">' . PHP_EOL;
    } ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">


    <? if (!file_exists(ROOT_PATH . '/.env')) {
        include ROOT_PATH . '/src/endpoints/setup.php';
        exit;
    } ?>

    <? $favicon = Settings::getInstance()->get_favicon();
    $url = cmss_media($favicon)['url']; ?>

    <link rel="icon" type="image/png" href="<?= $url; ?>">
    <link rel="shortcut icon" href="<?= $url; ?>">

    <? if (Settings::getInstance()->get_site_title()) { ?>
        <title>
            <?= Settings::getInstance()->get_site_title(); ?>
        </title>
    <? } ?>

    <? if (!cmss_is_user_logged_in() && is_dashboard() && !is_password_reset() && !is_setup()) {
        include ROOT_PATH . '/src/endpoints/login.php';
        exit;
    } ?>

</head>

<body>