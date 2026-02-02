<?php
/**
 * Products Listing Page
 * Shows all products filtered by category, subcategory, or search
 */
require_once __DIR__ . '/session.php';

$u = SITE_URL;

// Get filters
$category = trim($_GET['category'] ?? '');
$subcategory = trim($_GET['sub'] ?? '');
$search = trim($_GET['search'] ?? '');
$mine = isset($_GET['mine']) && isLoggedIn();

$conn = getDB();

// Build query
$sql = "SELECT p.*, u.username as seller_name FROM products p 
        LEFT JOIN users u ON p.posted_by = u.id WHERE 1=1";
$params = [];
$types = "";

if ($category) {
    $sql .= " AND p.category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($subcategory) {
    $sql .= " AND LOWER(p.name) LIKE LOWER(?)";
    $params[] = "%$subcategory%";
    $types .= "s";
}

if ($search) {
    $sql .= " AND (LOWER(p.name) LIKE LOWER(?) OR LOWER(p.description) LIKE LOWER(?))";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "ss";
}

if ($mine) {
    $sql .= " AND p.posted_by = ?";
    $params[] = getCurrentUserId();
    $types .= "i";
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Page title
$pageTitle = 'All Products';
if ($category && $subcategory) {
    $pageTitle = ucfirst($category) . ' - ' . ucfirst($subcategory);
} elseif ($category) {
    $pageTitle = $category;
}
if ($mine) $pageTitle = 'My Products';
if ($search) $pageTitle = 'Search: ' . e($search);

$success = getFlash('success');
$error = getFlash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | <?php echo e($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo $u; ?>/frontend/products.css">
    <style>
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; padding: 2rem 0; }
        .product-card { background: var(--card-bg, #fff); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .product-card:hover { transform: translateY(-5px); }
        .product-card img { width: 100%; height: 250px; object-fit: cover; }
        .product-card-body { padding: 1.25rem; }
        .product-card-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 0.5rem; color: var(--text-color, #333); }
        .product-card-price { color: #d27b5a; font-weight: 600; font-size: 1.1rem; }
        .product-card-category { font-size: 0.75rem; color: #888; background: #f0f0f0; padding: 2px 8px; border-radius: 10px; display: inline-block; }
        .filter-section { background: var(--card-bg, #f8f8f8); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main class="container py-4">
        <!-- Special Offer Banner -->
        <div class="promo-banner mb-4" style="background: linear-gradient(135deg, #d27b5a 0%, #e8a87c 100%); color: white; padding: 1rem 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 15px;">
            <div style="font-size: 2.5rem;">🎁</div>
            <div>
                <h4 style="margin: 0; font-size: 1.2rem;">3 FOR 2 - Buy 3, Get Cheapest FREE!</h4>
                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Mix & match any products. Discount applied at checkout.</p>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav mb-3">
            <a href="<?php echo $u; ?>/products.php" style="color: #d27b5a;">All Products</a>
            <?php if ($category): ?>
                <span> / </span>
                <a href="<?php echo $u; ?>/products.php?category=<?php echo urlencode($category); ?>" style="color: #d27b5a;"><?php echo e($category); ?></a>
            <?php endif; ?>
            <?php if ($subcategory): ?>
                <span> / </span>
                <span><?php echo ucfirst(e($subcategory)); ?></span>
            <?php endif; ?>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo e($pageTitle); ?></h1>
            <?php if (isLoggedIn()): ?>
                <a href="<?php echo $u; ?>/add_product.php" class="btn btn-primary">+ Add Product</a>
            <?php endif; ?>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo e($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="filter-section">
            <form class="row g-3 align-items-end" method="GET">
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="Skincare" <?php echo $category === 'Skincare' ? 'selected' : ''; ?>>Skincare</option>
                        <option value="Makeup" <?php echo $category === 'Makeup' ? 'selected' : ''; ?>>Makeup</option>
                        <option value="Tools" <?php echo $category === 'Tools' ? 'selected' : ''; ?>>Tools</option>
                        <option value="Haircare" <?php echo $category === 'Haircare' ? 'selected' : ''; ?>>Haircare</option>
                        <option value="Fragrance" <?php echo $category === 'Fragrance' ? 'selected' : ''; ?>>Fragrance</option>
                        <option value="Bath & Body" <?php echo $category === 'Bath & Body' ? 'selected' : ''; ?>>Bath & Body</option>
                        <option value="Wellness" <?php echo $category === 'Wellness' ? 'selected' : ''; ?>>Wellness</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" value="<?php echo e($search); ?>" placeholder="Search products...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-3">
                    <?php if ($category || $subcategory || $search): ?>
                        <a href="<?php echo $u; ?>/products.php" class="btn btn-outline-secondary w-100">Clear Filters</a>
                    <?php elseif (isLoggedIn()): ?>
                        <a href="<?php echo $u; ?>/products.php?mine=1" class="btn btn-outline-primary w-100">My Products Only</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <p class="text-muted mb-3"><?php echo count($products); ?> product(s) found</p>

        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <h3>No products found</h3>
                <p>Try adjusting your filters or <a href="<?php echo $u; ?>/products.php">view all products</a>.</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <?php 
                    $imagePath = $product['image'] ?? 'assets/images/products/default.svg';
                    if (strpos($imagePath, 'http') !== 0) {
                        $imagePath = $u . '/' . ltrim($imagePath, '/');
                    }
                    ?>
                    <div class="product-card">
                        <a href="<?php echo $u; ?>/product.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($product['name']); ?>">
                        </a>
                        <div class="product-card-body">
                            <span class="product-card-category"><?php echo e($product['category']); ?></span>
                            <h3 class="product-card-title mt-2"><?php echo e($product['name']); ?></h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-card-price">£<?php echo number_format($product['price'], 2); ?></span>
                                <small class="text-muted">by <?php echo e($product['seller_name']); ?></small>
                            </div>
                            <p class="small text-muted mt-2"><?php echo e(substr($product['description'], 0, 80)); ?>...</p>
                            
                            <div class="product-actions d-flex gap-2 mt-3">
                                <?php if (isLoggedIn()): ?>
                                    <form action="<?php echo $u; ?>/cart_add.php" method="POST" class="flex-grow-1">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">🛒 Add to Cart</button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?php echo $u; ?>/login.php" class="btn btn-sm btn-outline-primary flex-grow-1">Login to Buy</a>
                                <?php endif; ?>
                                
                                <?php if (isLoggedIn() && ($product['posted_by'] == getCurrentUserId() || isAdmin())): ?>
                                    <a href="<?php echo $u; ?>/delete_product.php?id=<?php echo $product['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Delete this product?');">
                                        🗑️
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
