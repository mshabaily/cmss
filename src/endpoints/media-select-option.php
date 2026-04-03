<? $media = cmss_media((int) $_GET['media_id']);

$info = getimagesize($media['url']); ?>

<div class="option" style="display: none;" data-media-id="<?= $media['media_id']; ?>">
    <div class="title">
        <h3>
            <?= $media['file_name']; ?>
        </h3>
    </div>
    <div class="main flex-row">
        <img src="<?= $media['url'] ?>" class="main-image">
        <button href="cmss/delete-media" class="delete">
            Delete
        </button>
        <button class="select button">
            Select
        </button>
        <button class="back">
            Back
        </button>
        <div class="info flex-column">
            <a href="<?= $media['url']; ?>" target="_blank">
                url:
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