<?php
$success = false;

$IS_LOCAL = (strpos($_SERVER['HTTP_HOST'] ?? 'localhost', 'localhost') !== false);

$conn = @new mysqli("cs2410-web01pvm.aston.ac.uk", "cs2team57", "EruuMu42kZHszDadyUWhXXNkc", "cs2team57_db");

if ($conn->connect_error) {
    $conn = @new mysqli("localhost", "root", "", "cs2team57");
    
    if ($conn->connect_error) {
        class MockDB {
            public $connect_error = null;
            public function query($sql) { 
                $result = new stdClass();
                $result->num_rows = 2;
                $result->fetch_assoc = function() {
                    static $i = 0;
                    $i++;
                    if ($i == 1) return ['id' => 1, 'username' => 'admin', 'role' => 'admin'];
                    if ($i == 2) return ['id' => 2, 'username' => 'user1', 'role' => 'user'];
                    return false;
                };
                return $result;
            }
            public function real_escape_string($s) { return addslashes($s); }
            public function set_charset($c) { return true; }
        }
        $conn = new MockDB();
        $success = false;
    } else {
        $success = true;
    }
} else {
    $success = true;
}

define('SITE_NAME', 'Serenique');
define('SITE_URL', $IS_LOCAL ? 'http://localhost/Team-Project/public_html' : 'https://cs2410-web01pvm.aston.ac.uk/~cs2team57');
define('IS_LOCAL', $IS_LOCAL);
define('BASE_URL', $IS_LOCAL ? 'http://localhost/Team-Project/public_html' : 'https://cs2410-web01pvm.aston.ac.uk/~cs2team57');

function getDB() {
    global $conn;
    return $conn;
}

function sanitize($data) {
    global $conn;
    if (is_object($conn) && method_exists($conn, 'real_escape_string')) {
        return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))), ENT_QUOTES, 'UTF-8');
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function e($data) {
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    $url = BASE_URL . '/' . ltrim($path, '/');
    header('Location: ' . $url);
    exit;
}

function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}
?>