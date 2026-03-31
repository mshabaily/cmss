<?php

use CMSS\Database;
use CMSS\TemplateManager;
use CMSS\Response;

try {
    $pdo = Database::getInstance()->pdo();
} catch (\Throwable $e) {
    Database::getInstance()->error("Connection failed");
    send_response(new Response(500, "Couldn't connect the the database"));
}

$fields = $_POST['fields'] ?? [];

if (!is_array($fields) || empty($fields)) {
    Database::getInstance()->error("Fields missing");
    send_response(new Response(422, "Fields missing"));
}

$json_fields = json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($json_fields === false) {
    Database::getInstance()->error("Failed to encode fields as JSON: " . json_last_error_msg());
    send_response(new Response(500, "Failed to encode fields as JSON"));
}

$title = $_POST['title'] ?? 'Untitled';
$author_id = 1;

$template_id = isset($_POST['id']) ? (int) $_POST['id'] : -1;

$template = [
    'fields' => $json_fields,
    'title' => $title,
    'author_id' => $author_id,
    'template_id' => $template_id
];

$response = TemplateManager::getInstance()->save($template);

$response->data['redirect'] = site_url() . '/cmss/edit-template?id=' . $response->data['template_id'];

send_response($response);