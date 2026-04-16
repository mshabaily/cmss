<?php

function __get_field_types(): array
{
    $config = ROOT_PATH . '/src/config/fieldtypes.json';

    if (!is_file($config)) {
        return [];
    }

    $json = file_get_contents($config);
    $data = json_decode($json, true);

    return $data;
}

function __fieldtype($name): string
{
    return ROOT_PATH . "/src/fieldtypes/$name";
}

function send_response($response): never
{
    http_response_code($response->get_code());
    header('Content-Type: application/json; charset=utf-8');

    $success = $response->get_code() >= 200 && $response->get_code() < 300;

    echo json_encode([
        'success' => $success,
        'message' => $response->get_message(),
        'data' => $response->data ?? null,
    ]);

    exit;
}

function __login_redirect()
{
    if (!headers_sent()) {
        header('Location: /cmss');
    } else {
        echo '<script>window.location.href="/cmss";</script>';
    }
    exit;
}

function is_dashboard()
{
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return str_starts_with($uri, '/cmss');
}

function is_password_reset() 
{
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return $uri == "/cmss/forgot-password" || str_starts_with($uri, "/cmss/reset-password");
}

function is_setup()
{
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return $uri == "/cmss/setup" || $uri == "/cmss/account-setup";
}

function cmss_endpoint($path) {
    return ROOT_PATH . '/src/endpoints/' . $path;
}

function format_filesize($bytes) {
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}