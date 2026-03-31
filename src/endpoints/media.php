<? cmss_header(); ?>

<? define('ITEMS_PER_PAGE', 30); ?>

<main class="media">
    <? cmss_sidebar(); ?>
    <content class="flex-column">
        <div class="wrapper flex-column">
            <div class="media card">
                <div class="title flex-row">
                    <h3>All Media</h3>
                    <button class="upload-media button" type="file">
                        Upload Media
                    </button>
                    <input class="hidden-input" style="display: none;" type="file">
                </div>
                <div class="media-container">
                    <? include cmss_endpoint('load-media.php'); ?>
                </div>
            </div>
        </div>
    </content>
</main>

<? cmss_footer(); ?>