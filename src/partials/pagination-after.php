<div class="pagination flex-row">
    <p>Page <?= $page_num; ?> of <?= $max_pages; ?></p>
    <div class="end flex-row">

        <? if ($page_num - 1 > 0) { ?>
            <a href=<?= parse_url(current_location(), PHP_URL_PATH) . "?page=" . $page_num - 1; ?>>
                Previous Page
            </a>
        <? } ?>


        <? if ($page_num + 1 <= $max_pages) { ?>
            <a href=<?= parse_url(current_location(), PHP_URL_PATH) . "?page=" . $page_num + 1; ?>>
                Next Page
            </a>
        <? } ?>
    </div>
</div>