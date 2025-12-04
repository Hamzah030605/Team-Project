<?php
/**
 * Admin Dashboard
 * View all users and products, delete any user/product
 */
require_once __DIR__ . '/../session.php';

requireAdmin();

$conn = getDB();
$message = '';
$messageType = '';

// Handle delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete_user') {
        $userId = (int)($_POST['user_id'] ?? 0);
        if ($userId && $userId != getCurrentUserId()) {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                $message = 'User deleted successfully.';
                $messageType = 'success';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete_product') {
        $productId = (int)($_POST['product_id'] ?? 0);
        if ($productId) {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            if ($stmt->execute()) {
                $message = 'Product deleted successfully.';
                $messageType = 'success';
            }
            $stmt->close();
        }
    }
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Get all products with seller info
$products = $conn->query("SELECT p.*, u.username as seller_name FROM products p LEFT JOIN users u ON p.posted_by = u.id ORDER BY p.created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Stats
$userCount = count($users);
$productCount = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <title>Serenique | Admin Dashboard</title>
    <style>
        .admin-header { background: linear-gradient(135deg, #d27b5a 0%, #b86a4d 100%); color: white; padding: 2rem 0; margin-bottom: 2rem; }
        .admin-header h1 { font-family: 'Playfair Display', serif; }
        .stat-card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h2 { color: #d27b5a; font-size: 2.5rem; margin: 0; }
        .stat-card p { color: #666; margin: 0; }
        .section-card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .section-card h3 { font-family: 'Playfair Display', serif; border-bottom: 2px solid #f8f5f2; padding-bottom: 0.5rem; margin-bottom: 1rem; }
        .table th { background: #f8f5f2; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>🔐 Admin Dashboard</h1>
                <div>
                    <span class="me-3">Welcome, <?php echo e(getCurrentUsername()); ?></span>
                    <a href="../homepage.php" class="btn btn-outline-light btn-sm">View Site</a>
                    <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo e($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <h2><?php echo $userCount; ?></h2>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <h2><?php echo $productCount; ?></h2>
                    <p>Total Products</p>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="section-card">
            <h3>👥 All Users</h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td>
                                <?php echo e($user['username']); ?>
                                <?php if ($user['id'] == getCurrentUserId()): ?>
                                    <span class="badge bg-info">You</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'secondary'; ?>">
                                    <?php echo $user['role']; ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != getCurrentUserId()): ?>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user? This will also delete all their products.');">
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Products Section -->
        <div class="section-card">
            <h3>📦 All Products</h3>
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
                            <td><?php echo e($product['name']); ?></td>
                            <td>£<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo e($product['category'] ?? '-'); ?></td>
                            <td><?php echo e($product['seller_name'] ?? 'Unknown'); ?></td>
                            <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                            <td>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                    <input type="hidden" name="action" value="delete_product">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mb-4">
            <a href="../homepage.php" class="btn btn-secondary">← Back to Site</a>
            <a href="../products.php" class="btn btn-primary">View Products Page</a>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
