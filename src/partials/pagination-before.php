<?php

if (!defined('ITEMS_PER_PAGE')) {
    define('ITEMS_PER_PAGE', 8);
}

$page_num = (int) ($_GET['page'] ?? 1);

$offset = ($page_num - 1) * ITEMS_PER_PAGE;

$current_page_items = array_slice($items, $offset, ITEMS_PER_PAGE);
$remaining_items = array_slice($items, $offset + ITEMS_PER_PAGE);

$max_pages = ceil(count($items) / ITEMS_PER_PAGE);
