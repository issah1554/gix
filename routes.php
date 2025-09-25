<?php
// routes.php

// Get the requested URL path
$request = $_SERVER['REQUEST_URI'];

// Remove query string if present
$request = strtok($request, '?');

// Trim slashes
$request = trim($request, '/');

// Simple routing array
$routes = [
    'ardhi/api/submit' => 'submit',
];

// Match route
if (array_key_exists($request, $routes)) {
    $function = $routes[$request];
    $function();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found...']);
}

// Route handlers

function submit()
{
    require 'submit.php';
}
