<?php
require __DIR__ . '/vendor/autoload.php';

// Normalize URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = rtrim($requestUri, '/') ?: '/';
$requestMethod = $_SERVER['REQUEST_METHOD'];

// --- API ROUTES ---
if (strpos($requestUri, '/gix') === 0) {

    // Ensure JSON response
    header('Content-Type: application/json');

    // Auth API
    if (strpos($requestUri, '/gix/submit') === 0) {
        require './submit.php';
        exit;
    }

    // Default API 404
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'ardhi: Endpoint not found']);
    exit;
}
