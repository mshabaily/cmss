<?

$items = cmss_all_media();

if (!$items) { ?>
    <p class="no-content">No media found, upload media to get started!</p>
<? } else { ?>

    <? include cmss_partial('pagination-before.php'); ?>

    <div class="media-items">

        <? foreach ($current_page_items as $media) { ?>
            <img src="<?= cmss_thumbnail($media) ?>" class="item dim-effect" data-id="<?= $media['media_id']; ?>">
        <? } ?>

    </div>

    <? include cmss_partial('pagination-after.php');

}