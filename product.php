<?php
/**
 * Single Product Page
 * Displays product details with Add to Cart
 */
require_once __DIR__ . '/session.php';

// Get product ID
$productId = (int)($_GET['id'] ?? 0);

if (!$productId) {
    redirect('products.php');
}

$conn = getDB();

// Fetch product details
$stmt = $conn->prepare("
    SELECT p.*, u.username as seller_name 
    FROM products p 
    LEFT JOIN users u ON p.posted_by = u.id 
    WHERE p.id = ?
");
$stmt->bind_param("i", $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    redirect('products.php');
}

// Get reviews
$reviewStmt = $conn->prepare("
    SELECT r.*, u.username 
    FROM reviews r 
    JOIN users u ON r.user_id = u.id 
    WHERE r.product_id = ? 
    ORDER BY r.created_at DESC
");
$reviewStmt->bind_param("i", $productId);
$reviewStmt->execute();
$reviews = $reviewStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$reviewStmt->close();

// Calculate average rating
$avgRating = 0;
if (count($reviews) > 0) {
    $avgRating = array_sum(array_column($reviews, 'rating')) / count($reviews);
}

// Get similar products
$similarStmt = $conn->prepare("
    SELECT * FROM products 
    WHERE category = ? AND id != ? 
    ORDER BY RAND() LIMIT 4
");
$similarStmt->bind_param("si", $product['category'], $productId);
$similarStmt->execute();
$similarProducts = $similarStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$similarStmt->close();

// Check if user can delete
$canDelete = isLoggedIn() && (isAdmin() || $product['posted_by'] == getCurrentUserId());

// Flash messages
$success = getFlash('success');
$error = getFlash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | <?php echo e($product['name']); ?></title>
    <style>
        .product-page { padding: 2rem 0; }
        .product-image { width: 100%; max-height: 500px; object-fit: cover; border-radius: 12px; }
        .product-gallery { display: flex; gap: 10px; margin-top: 1rem; }
        .product-gallery img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent; }
        .product-gallery img:hover, .product-gallery img.active { border-color: #d27b5a; }
        .product-info { padding: 1rem 2rem; }
        .product-title { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 0.5rem; }
        .product-price { font-size: 2rem; color: #d27b5a; font-weight: 700; margin: 1rem 0; }
        .product-category { color: #888; font-size: 0.9rem; margin-bottom: 1rem; }
        .product-description { line-height: 1.8; margin: 1.5rem 0; }
        .add-to-cart-section { background: var(--card-bg, #f8f5f2); padding: 1.5rem; border-radius: 12px; margin: 1.5rem 0; }
        .qty-input { width: 80px; text-align: center; }
        .btn-add-cart { background: #d27b5a; color: white; border: none; padding: 15px 40px; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-add-cart:hover { background: #b8654a; transform: translateY(-2px); }
        .btn-buy-now { background: #2d3436; color: white; border: none; padding: 15px 40px; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-buy-now:hover { background: #1a1a1a; }
        .seller-info { display: flex; align-items: center; gap: 10px; padding: 1rem; background: var(--card-bg, #f8f8f8); border-radius: 8px; margin: 1rem 0; }
        .review-card { background: var(--card-bg, #f8f8f8); padding: 1.5rem; border-radius: 12px; margin-bottom: 1rem; }
        .stars { color: #ffc107; }
        .similar-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; }
        .similar-card { background: var(--card-bg, #fff); border-radius: 12px; overflow: hidden; transition: transform 0.3s; }
        .similar-card:hover { transform: translateY(-5px); }
        .similar-card img { width: 100%; height: 180px; object-fit: cover; }
        .similar-card-body { padding: 1rem; }
    </style>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main class="container product-page">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo e($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo url('homepage.php'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo url('products.php'); ?>">Products</a></li>
                <li class="breadcrumb-item"><a href="<?php echo url('products.php?category=' . urlencode($product['category'])); ?>"><?php echo e($product['category']); ?></a></li>
                <li class="breadcrumb-item active"><?php echo e($product['name']); ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-6 mb-4">
                <?php 
                $imagePath = $product['image'] ?? 'assets/images/products/default.svg';
                if (strpos($imagePath, 'http') !== 0) {
                    $imagePath = (strpos($imagePath, '/') === 0) ? BASE_URL . $imagePath : BASE_URL . '/' . ltrim($imagePath, '/');
                }
                ?>
                <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($product['name']); ?>" class="product-image" id="mainImage">
                
                <?php if ($canDelete): ?>
                    <div class="mt-3">
                        <a href="<?php echo url('delete_product.php?id=' . $product['id']); ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('Delete this product?');">
                            🗑️ Delete Product
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <span class="product-category"><?php echo e($product['category']); ?></span>
                    <h1 class="product-title"><?php echo e($product['name']); ?></h1>
                    
                    <!-- Rating -->
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="stars">
                            <?php 
                            $fullStars = floor($avgRating);
                            $halfStar = ($avgRating - $fullStars) >= 0.5;
                            echo str_repeat('★', $fullStars);
                            if ($halfStar) echo '½';
                            echo str_repeat('☆', 5 - $fullStars - ($halfStar ? 1 : 0));
                            ?>
                        </span>
                        <span class="text-muted">(<?php echo count($reviews); ?> reviews)</span>
                    </div>

                    <div class="product-price">£<?php echo number_format($product['price'], 2); ?></div>

                    <div class="product-description">
                        <?php echo nl2br(e($product['description'] ?? 'No description available.')); ?>
                    </div>

                    <!-- Add to Cart Section -->
                    <div class="add-to-cart-section">
                        <?php if (isLoggedIn()): ?>
                            <?php $stock = (int)($product['stock'] ?? 0); ?>
                            <?php if ($stock <= 0): ?>
                                <p class="mb-0 text-danger fw-bold">Out of stock — check back later.</p>
                            <?php else: ?>
                                <form action="<?php echo url('cart_add.php'); ?>" method="POST" class="d-flex align-items-center gap-3 flex-wrap">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="qty" class="mb-0">Qty:</label>
                                        <input type="number" name="qty" id="qty" value="1" min="1" max="<?php echo $stock; ?>" class="form-control qty-input">
                                        <span class="text-muted small">(<?php echo $stock; ?> in stock)</span>
                                    </div>
                                    
                                    <button type="submit" class="btn-add-cart">
                                        🛒 Add to Cart
                                    </button>
                                    
                                    <button type="submit" name="buy_now" value="1" class="btn-buy-now">
                                        ⚡ Buy Now
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="mb-3">Please log in to add items to your cart.</p>
                            <a href="<?php echo url('login.php'); ?>" class="btn-add-cart text-decoration-none d-inline-block">Login to Shop</a>
                        <?php endif; ?>
                    </div>

                    <!-- Seller Info -->
                    <div class="seller-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <div>
                            <small class="text-muted">Sold by</small>
                            <div class="fw-bold"><?php echo e($product['seller_name'] ?? 'Serenique Store'); ?></div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mt-4">
                        <h5>Product Features</h5>
                        <ul class="list-unstyled">
                            <li>✅ 100% Authentic Product</li>
                            <li>✅ Free Returns within 30 days</li>
                            <li>✅ Secure Payment</li>
                            <li>✅ Fast Delivery (2-5 business days)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="font-family: 'Playfair Display', serif;">Customer Reviews</h2>
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo url('add_review.php?product_id=' . $product['id']); ?>" class="btn btn-outline-primary">
                        ✍️ Write a Review
                    </a>
                <?php endif; ?>
            </div>

            <?php if (empty($reviews)): ?>
                <div class="text-center py-4">
                    <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                </div>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <div class="d-flex justify-content-between mb-2">
                            <strong><?php echo e($review['username']); ?></strong>
                            <span class="stars"><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></span>
                        </div>
                        <p class="mb-1"><?php echo nl2br(e($review['review'])); ?></p>
                        <small class="text-muted"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Similar Products -->
        <?php if (!empty($similarProducts)): ?>
        <section class="mt-5">
            <h2 style="font-family: 'Playfair Display', serif;" class="mb-4">You May Also Like</h2>
            <div class="similar-grid">
                <?php foreach ($similarProducts as $similar): ?>
                    <?php 
                    $simImage = $similar['image'] ?? 'assets/images/products/default.svg';
                    if (strpos($simImage, 'http') !== 0 && strpos($simImage, '/') !== 0) {
                        $simImage = SITE_URL . '/' . $simImage;
                    }
                    ?>
                    <a href="<?php echo url('product.php?id=' . $similar['id']); ?>" class="similar-card text-decoration-none">
                        <img src="<?php echo e($simImage); ?>" alt="<?php echo e($similar['name']); ?>">
                        <div class="similar-card-body">
                            <h6 class="mb-1" style="color: var(--text-color);"><?php echo e($similar['name']); ?></h6>
                            <span style="color: #d27b5a; font-weight: 600;">£<?php echo number_format($similar['price'], 2); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
