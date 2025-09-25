<?php
require_once('./configs/database.php');

header("Content-Type: application/json");

// Allow CORS (if needed for frontend requests)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Read raw POST body
$rawData = file_get_contents("php://input");

if (!$rawData) {
    http_response_code(400);
    echo json_encode(["error" => "No data received"]);
    exit;
}

// Decode JSON
$data = json_decode($rawData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

// Validate required fields
$required = ['name', 'phone', 'place', 'coordinates'];
$missing = [];

foreach ($required as $field) {
    if (empty($data[$field])) {
        $missing[] = $field;
    }
}

if ($missing) {
    http_response_code(400);
    echo json_encode([
        "error" => "Missing required fields: " . implode(", ", $missing),
        "missing" => $missing
    ]);
    exit;
}

// Sanitize input
$name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8');
$place = htmlspecialchars($data['place'], ENT_QUOTES, 'UTF-8');
$coordinates = json_encode($data['coordinates']); // store as JSON string

try {
    // Prepare insert query
    $stmt = $pdo->prepare("
        INSERT INTO geo_data (name, phone, place, coordinates, created_at)
        VALUES (:name, :phone, :place, :coordinates, NOW())
    ");

    $stmt->execute([
        ':name' => $name,
        ':phone' => $phone,
        ':place' => $place,
        ':coordinates' => $coordinates
    ]);

    echo json_encode(["success" => true, "message" => "Data saved successfully"]);
} catch (PDOException $e) {
    http_response_code(500);

    // Log full error internally
    error_log("Database error: " . $e->getMessage());

    // Return generic JSON to client
    echo json_encode(["error" => "Internal server error"]);
}
