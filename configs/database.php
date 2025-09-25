<?php
date_default_timezone_set('Africa/Dar_es_Salaam');

// Database configuration
$host = 'localhost'; // Database host
$dbname = 'ardhi_db'; // Database name
$username = 'root';  // Database username
$password = '';   // Database password


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
