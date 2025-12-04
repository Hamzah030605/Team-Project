<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Test</title>
</head>
<body>
<h1>Database Test Results</h1>

<?php
try {
    $pdo->query("SELECT 1");
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} catch (PDOException $e) {
    die("<p style='color: red;'>✗ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>");
}

try {
    $userCount = $pdo->query("SELECT COUNT(*) AS c FROM users")->fetch()['c'];
    echo "<p style='color: green;'>✓ Users table exists: " . htmlspecialchars($userCount) . " records</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Users table error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

try {
    $productCount = $pdo->query("SELECT COUNT(*) AS c FROM products")->fetch()['c'];
    echo "<p style='color: green;'>✓ Products table exists: " . htmlspecialchars($productCount) . " records</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Products table error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>All Tables in Database:</h3>";
    if (empty($tables)) {
        echo "<p>No tables found</p>";
    } else {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    echo "<p>Cannot show tables: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</body>
</html>