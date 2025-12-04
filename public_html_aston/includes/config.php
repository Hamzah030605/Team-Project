<?php
/**
 * Database Configuration - ASTON SERVER VERSION
 */

// ASTON UNIVERSITY SERVER CREDENTIALS
$DB_HOST = "localhost";
$DB_USER = "cs2team57";
$DB_PASS = "EruuMu42kZHszDadyUWhXXNkc";
$DB_NAME = "cs2team57_db";

define('SITE_URL', '');
define('SITE_NAME', 'Serenique');

// Create database connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

/**
 * Get MySQLi connection
 */
function getDB() {
    global $conn;
    return $conn;
}

/**
 * Get site URL prefix
 */
function siteUrl($path = '') {
    return SITE_URL . $path;
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

