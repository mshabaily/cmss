<div class="media-select card flex-column" style="display: none;" data-fieldkey=<?= $_GET['fieldkey']; ?>>
    <img src="<?= cmss_asset('close.png'); ?>" class="close dim-effect">
    <div class="primary">
        <div class="title">
            <h3>
                Select Media
            </h3>
        </div>
        <div class="main flex-column">
            <? define('ITEMS_PER_PAGE', 1000000); ?>
            <? include cmss_endpoint('load-media.php'); ?>
        </div>
    </div>
</div>