<div class="image-field flex-column" data-selected-media="-1">

    <? if ($field['value']) {
        $media = cmss_media($field['value']); ?>
        <div class="image-item">
            <img src="<?= $media['url']; ?>" class="main-image">
        </div>
    <? } ?>
    <button class="select-media button">Select Media</button>
</div>