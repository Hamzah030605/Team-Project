<?php
require_once __DIR__ . '/../includes/session.php';
requireAdmin();

$username = getCurrentUsername();
$message = '';
$messageType = '';

$conn = getDB();
$products = [];
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);
    
    if ($action === 'delete' && $productId) {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $productId);
            if ($stmt->execute()) {
                $message = 'Product deleted.';
                $messageType = 'success';
            }
        }
    }
}

// SIMPLE QUERY THAT WON'T FAIL
$sql = "SELECT p.id, p.name, p.price, p.category, p.created_at, u.username as seller_name 
        FROM products p 
        LEFT JOIN users u ON p.posted_by = u.id 
        WHERE 1=1";

if (!empty($search)) {
    $search_clean = $conn->real_escape_string($search);
    $sql .= " AND (p.name LIKE '%$search_clean%' OR p.description LIKE '%$search_clean%')";
}

if (!empty($category)) {
    $category_clean = $conn->real_escape_string($category);
    $sql .= " AND p.category = '$category_clean'";
}

$sql .= " ORDER BY p.created_at DESC";

$result = $conn->query($sql);
if ($result) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenique | Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f5f2; }
        .admin-header { background: #d27b5a; color: white; padding: 1rem 0; }
        .sidebar { background: white; padding: 1rem; }
        .content-card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table th { background: #f0f0f0; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0">Manage Products</h1>
                <div>
                    <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
                    <a href="../homepage.php" class="btn btn-outline-light btn-sm ms-3">View Site</a>
                    <a href="../logout.php" class="btn btn-light btn-sm ms-2">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-2 sidebar">
                <a href="dashboard.php">📊 Dashboard</a>
                <a href="manage_users.php">👥 Manage Users</a>
                <a href="manage_products.php" style="background:#f0f0f0;">📦 Manage Products</a>
                <hr>
                <a href="../homepage.php">🏠 Back to Site</a>
            </div>

            <div class="col-md-10">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="content-card">
                    <h5>All Products (<?php echo count($products); ?>)</h5>
                    
                    <form class="row g-2 mb-3" method="GET">
                        <div class="col-auto">
                            <select name="category" class="form-select form-select-sm">
                                <option value="">All Categories</option>
                                <option value="skincare" <?php echo $category === 'skincare' ? 'selected' : ''; ?>>Skincare</option>
                                <option value="makeup" <?php echo $category === 'makeup' ? 'selected' : ''; ?>>Makeup</option>
                                <option value="haircare" <?php echo $category === 'haircare' ? 'selected' : ''; ?>>Haircare</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-primary">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Seller</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td>£<?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['category'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($product['seller_name'] ?? 'Unknown'); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">
                                        No products found.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>