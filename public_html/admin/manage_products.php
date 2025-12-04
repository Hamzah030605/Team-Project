<?php
/**
 * Admin - Manage Products
 * View, edit, and manage all products
 */

require_once __DIR__ . '/../includes/session.php';

// Require admin access
requireAdmin();

$username = getCurrentUsername();
$message = '';
$messageType = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);
    
    try {
        $pdo = getPDOConnection();
        
        if ($action === 'toggle_status' && $productId) {
            $stmt = $pdo->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$productId]);
            $message = 'Product status updated successfully.';
            $messageType = 'success';
        } elseif ($action === 'toggle_featured' && $productId) {
            $stmt = $pdo->prepare("UPDATE products SET is_featured = NOT is_featured WHERE id = ?");
            $stmt->execute([$productId]);
            $message = 'Product featured status updated.';
            $messageType = 'success';
        } elseif ($action === 'delete' && $productId) {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $message = 'Product deleted successfully.';
            $messageType = 'success';
        }
    } catch (PDOException $e) {
        $message = 'An error occurred.';
        $messageType = 'danger';
    }
}

// Get all products
$products = [];
$search = sanitize($_GET['search'] ?? '');
$category = sanitize($_GET['category'] ?? '');

try {
    $pdo = getPDOConnection();
    
    $sql = "SELECT p.*, u.username as seller_name FROM products p LEFT JOIN users u ON p.posted_by = u.id WHERE 1=1";
    $params = [];
    
    if ($search) {
        $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $params[] = '%' . $search . '%';
        $params[] = '%' . $search . '%';
    }
    
    if ($category) {
        $sql .= " AND LOWER(p.category) = LOWER(?)";
        $params[] = $category;
    }
    
    $sql .= " ORDER BY p.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenique | Manage Products</title>
    <link rel="icon" type="image/x-icon" href="../frontend/images/logo2.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary-color: #d27b5a; --secondary-color: #f8f5f2; }
        body { font-family: 'Poppins', sans-serif; background: #f8f5f2; }
        .admin-header { background: linear-gradient(135deg, #d27b5a 0%, #b86a4d 100%); color: white; padding: 1.5rem 0; }
        .admin-header h1 { font-family: 'Playfair Display', serif; }
        .sidebar { background: white; min-height: calc(100vh - 100px); padding: 1.5rem; box-shadow: 2px 0 10px rgba(0,0,0,0.05); }
        .sidebar a { display: block; padding: 0.75rem 1rem; color: #333; text-decoration: none; border-radius: 8px; margin-bottom: 0.5rem; }
        .sidebar a:hover, .sidebar a.active { background: var(--secondary-color); color: var(--primary-color); }
        .content-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .content-card h5 { font-family: 'Playfair Display', serif; border-bottom: 2px solid var(--secondary-color); padding-bottom: 0.5rem; }
        .table th { background: var(--secondary-color); }
        .product-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-0">Manage Products</h1>
                <div class="d-flex align-items-center gap-3">
                    <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
                    <a href="../add_product.php" class="btn btn-light btn-sm">+ Add Product</a>
                    <a href="../homepage.php" class="btn btn-outline-light btn-sm">View Site</a>
                    <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <nav>
                    <a href="dashboard.php">📊 Dashboard</a>
                    <a href="manage_users.php">👥 Manage Users</a>
                    <a href="manage_products.php" class="active">📦 Manage Products</a>
                    <hr>
                    <a href="../homepage.php">🏠 Back to Site</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 py-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="m-0 border-0 pb-0">All Products (<?php echo count($products); ?>)</h5>
                        <form class="d-flex gap-2" method="GET">
                            <select name="category" class="form-select form-select-sm" style="width: auto;">
                                <option value="">All Categories</option>
                                <option value="skincare" <?php echo $category === 'skincare' ? 'selected' : ''; ?>>Skincare</option>
                                <option value="makeup" <?php echo $category === 'makeup' ? 'selected' : ''; ?>>Makeup</option>
                                <option value="haircare" <?php echo $category === 'haircare' ? 'selected' : ''; ?>>Haircare</option>
                                <option value="body" <?php echo $category === 'body' ? 'selected' : ''; ?>>Body</option>
                                <option value="tools" <?php echo $category === 'tools' ? 'selected' : ''; ?>>Tools</option>
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                            <button class="btn btn-sm btn-primary">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Seller</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td>
                                        <img src="../frontend/<?php echo htmlspecialchars($product['image'] ?? 'images/Serumv1.png'); ?>" 
                                             alt="" class="product-thumb">
                                    </td>
                                    <td>
                                        <a href="../product.php?id=<?php echo $product['id']; ?>" target="_blank">
                                            <?php echo htmlspecialchars(substr($product['name'], 0, 30)); ?>
                                        </a>
                                    </td>
                                    <td>£<?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['category'] ?? '-'); ?></td>
                                    <td><?php echo (int)$product['stock']; ?></td>
                                    <td><?php echo htmlspecialchars($product['seller_name'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $product['is_active'] ? 'success' : 'secondary'; ?>">
                                            <?php echo $product['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $product['is_featured'] ? 'warning' : 'light text-dark'; ?>">
                                            <?php echo $product['is_featured'] ? '⭐ Featured' : 'Normal'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle Active">
                                                <?php echo $product['is_active'] ? '🚫' : '✅'; ?>
                                            </button>
                                        </form>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="toggle_featured">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-info" title="Toggle Featured">
                                                <?php echo $product['is_featured'] ? '★' : '☆'; ?>
                                            </button>
                                        </form>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

