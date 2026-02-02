<?php
/**
 * Database Configuration
 * - LOCAL (XAMPP): Uses localhost MySQL (marketplace_db)
 * - ASTON SERVER: Uses Aston MySQL (cs2team57_db)
 */

// Detect environment
$IS_LOCAL = (
    strpos($_SERVER['HTTP_HOST'] ?? 'localhost', 'localhost') !== false ||
    strpos($_SERVER['HTTP_HOST'] ?? '', '127.0.0.1') !== false
);

if ($IS_LOCAL) {
    // LOCAL XAMPP - Use local MySQL
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = "serenique_db";
} else {
    // ASTON SERVER - Use Aston MySQL
    $DB_HOST = "cs2410-web01pvm.aston.ac.uk";
    $DB_USER = "cs2team57";
    $DB_PASS = "EruuMu42kZHszDadyUWhXXNkc";
    $DB_NAME = "cs2team57_db";
}

// Create database connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Site configuration
define('SITE_NAME', 'Serenique');
define('SITE_URL', $IS_LOCAL ? 'http://localhost/public_html' : 'https://cs2410-web01pvm.aston.ac.uk/~cs2team57');

/**
 * Get MySQLi connection
 */
function getDB() {
    global $conn;
    return $conn;
}

/**
 * Sanitize input
 */
function sanitize($data) {
    global $conn;
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize for output
 */
function e($data) {
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}
?>
