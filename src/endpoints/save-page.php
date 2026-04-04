<?php

use CMSS\Database;
use CMSS\PageManager;
use CMSS\Response;

if (!cmss_is_user_logged_in()) {
    send_response(new Response(500, "User must be logged in!"));
}

try {
    $pdo = Database::getInstance()->pdo();
} catch (\Throwable $e) {
    Database::getInstance()->error("Connection failed");
    send_response(new Response(500, "Couldn't connect to the database"));
}

$fields = $_POST['fields'] ?? [];

if (!is_array($fields) || empty($fields)) {
    Database::getInstance()->error("Fields missing");
    send_response(new Response(422, "Fields missing"));
}

$jsonFields = json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($jsonFields === false) {
    Database::getInstance()->error("Failed to encode fields as JSON: " . json_last_error_msg());
    send_response(new Response(500, "Failed to encode fields as JSON"));
}

$page_id = isset($_POST['id']) ? (int) $_POST['id'] : -1;
$title = $_POST['title'] ?? 'Untitled';
$template_id = (int) $_POST['template_id'] ?? 0;
$author_id = $_SESSION['user_id'];

$url = url_format($_POST['url'] ? $_POST['url'] : $title);

$page = [
    'page_id' => $page_id,
    'title' => $title,
    'template_id' => $template_id,
    'author_id' => $author_id,
    'url' => $url,
    'fields' => $jsonFields
];

$response = PageManager::getInstance()->save($page);

$response->data['redirect'] = site_url() . '/cmss/edit-page?id=' . $response->data['page_id'];

send_response($response);