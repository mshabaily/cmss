<? $page = $_GET['page'] ? $_GET['page'] : 1; ?>

<? $max_pages = ceil(count($remainder) / ITEMS_PER_PAGE) + 1; ?>

<div class="pagination flex-row">
    <p>Page <?= $page; ?> of <?= $max_pages; ?></p>
    <div class="end flex-row">
        <a href=<?= parse_url(current_location(), PHP_URL_PATH) . "?page=" . $page - 1; ?>>
            Previous Page
        </a>
        <a href=<?= parse_url(current_location(), PHP_URL_PATH) . "?page=" . $page + 1; ?>>
            Next Page
        </a>
    </div>
</div>