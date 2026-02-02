<?php
require_once __DIR__ . '/../session.php';

requireAdmin();

$conn = getDB();
$message = '';
$messageType = '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $postedToken = $_POST['csrf_token'] ?? '';
    
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $postedToken)) {
        $message = 'Security check failed.';
        $messageType = 'danger';
    } else {
        if ($action === 'delete_user') {
            $userId = (int)($_POST['user_id'] ?? 0);
            
            if (!$userId || $userId === getCurrentUserId()) {
                $message = 'You cannot delete your own account.';
                $messageType = 'warning';
            } else {
                $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $userRow = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!$userRow) {
                    $message = 'User not found.';
                    $messageType = 'warning';
                } else {
                    if (($userRow['role'] ?? '') === 'admin') {
                        $adminCount = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='admin'")->fetch_assoc();
                        if ((int)($adminCount['c'] ?? 0) <= 1) {
                            $message = 'Cannot delete the last admin account.';
                            $messageType = 'warning';
                        } else {
                            $conn->begin_transaction();
                            try {
                                $stmt = $conn->prepare("DELETE FROM products WHERE posted_by = ?");
                                $stmt->bind_param("i", $userId);
                                $stmt->execute();
                                $stmt->close();

                                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                                $stmt->bind_param("i", $userId);
                                $stmt->execute();
                                $affected = $stmt->affected_rows;
                                $stmt->close();

                                $conn->commit();

                                if ($affected > 0) {
                                    $message = 'User and their products deleted successfully.';
                                    $messageType = 'success';
                                } else {
                                    $message = 'User could not be deleted.';
                                    $messageType = 'danger';
                                }
                            } catch (Exception $e) {
                                $conn->rollback();
                                $message = 'Delete failed: ' . $e->getMessage();
                                $messageType = 'danger';
                            }
                        }
                    } else {
                        $conn->begin_transaction();
                        try {
                            $stmt = $conn->prepare("DELETE FROM products WHERE posted_by = ?");
                            $stmt->bind_param("i", $userId);
                            $stmt->execute();
                            $stmt->close();

                            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                            $stmt->bind_param("i", $userId);
                            $stmt->execute();
                            $affected = $stmt->affected_rows;
                            $stmt->close();

                            $conn->commit();

                            if ($affected > 0) {
                                $message = 'User and their products deleted successfully.';
                                $messageType = 'success';
                            } else {
                                $message = 'User could not be deleted.';
                                $messageType = 'danger';
                            }
                        } catch (Exception $e) {
                            $conn->rollback();
                            $message = 'Delete failed: ' . $e->getMessage();
                            $messageType = 'danger';
                        }
                    }
                }
            }
        } elseif ($action === 'delete_product') {
            $productId = (int)($_POST['product_id'] ?? 0);
            if (!$productId) {
                $message = 'Invalid product.';
                $messageType = 'warning';
            } else {
                $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
                $stmt->bind_param("i", $productId);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $message = 'Product deleted successfully.';
                        $messageType = 'success';
                    } else {
                        $message = 'Product not found.';
                        $messageType = 'warning';
                    }
                } else {
                    $message = 'Product delete failed.';
                    $messageType = 'danger';
                }
                $stmt->close();
            }
        }
    }
}

$users = [];
$products = [];

$users_result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
if ($users_result) {
    $users = $users_result->fetch_all(MYSQLI_ASSOC);
}

$products_result = $conn->query("
    SELECT p.*, u.username as seller_name
    FROM products p
    LEFT JOIN users u ON p.posted_by = u.id
    ORDER BY p.created_at DESC
");
if ($products_result) {
    $products = $products_result->fetch_all(MYSQLI_ASSOC);
}

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
                                    <?php echo e($user['role']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != getCurrentUserId()): ?>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user? This will also delete all their products.');">
                                        <input type="hidden" name="csrf_token" value="<?php echo e($csrfToken); ?>">
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
                            <td>£<?php echo number_format((float)$product['price'], 2); ?></td>
                            <td><?php echo e($product['category'] ?? '-'); ?></td>
                            <td><?php echo e($product['seller_name'] ?? 'Unknown'); ?></td>
                            <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                            <td>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo e($csrfToken); ?>">
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