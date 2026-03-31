<? $media = cmss_media((int) $_GET['media_id']);

$info = getimagesize($media['url']); ?>
<div class="media-menu flex-column" style="display: none;">
    <img src="<?= cmss_asset('close.png'); ?>" class="close dim-effect">
    <div class="title">
        <h3>
            <?= $media['file_name']; ?>
        </h3>
    </div>
    <button href="/cmss/delete-media?id=<?=$media['media_id']; ?>" class="delete-media">
        Delete
    </button>
    <div class="main flex-row">
        <img src="<?= $media['url'] ?>" class="main-image">
        <div class="info flex-column">
            <a href="<?= $media['url']; ?>" target="_blank">url:
                <?= $media['url']; ?>
            </a>
            <p>Date Uploaded:
                <?= $media['date_added']; ?>
            </p>
            <p>Width:
                <?= $info[0]; ?>px
            </p>
            <p>Height:
                <?= $info[0]; ?>px
            </p>
            <p>File Size:
                <?= format_filesize($media['file_size']); ?>
            </p>
        </div>
    </div>
</div>