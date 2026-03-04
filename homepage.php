<?php
/**
 * Homepage
 */
require_once __DIR__ . '/session.php';
$u = SITE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | Home</title>
    <link rel="stylesheet" href="<?php echo $u; ?>/frontend/home.css">
    <script src="<?php echo $u; ?>/frontend/home.js"></script>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main>
        <div class="background-image d-flex justify-content-center align-items-center text-center">
            <img src="<?php echo $u; ?>/frontend/images/aboutUs.jpeg" alt="Beauty products flatlay" class="bg-img-file" />
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2 class="display-4 text-white fw-bold hero-title-shadow">Natural Glow, Simplified.</h2>
                <p class="text-white lead mb-4 hero-text-shadow">Premium organic skincare for sensitive skin.</p>
                <a href="<?php echo url('products.php'); ?>" class="btn btn-light btn-lg rounded-pill px-4 hero-cta-btn">Shop New Arrivals</a>
            </div>
        </div>

        <br class="d-none d-lg-block"><br class="d-none d-lg-block">

        <section class="container my-5">
            <h2 class="text-center mb-5 section-title">Top Categories</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo url('products.php?category=Skincare'); ?>" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="<?php echo $u; ?>/frontend/images/skincare.png" alt="Skincare" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Skincare</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo url('products.php?category=Makeup'); ?>" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="<?php echo $u; ?>/frontend/images/makeup.png" alt="Makeup" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Makeup</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo url('products.php?category=Haircare'); ?>" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="<?php echo $u; ?>/frontend/images/skincare.png" alt="Haircare" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Haircare</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo url('products.php?category=Fragrance'); ?>" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="<?php echo $u; ?>/frontend/images/makeup.png" alt="Fragrance" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Fragrance</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo url('products.php?category=Tools'); ?>" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="<?php echo $u; ?>/frontend/images/tools.png" alt="Tools" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Tools</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <br><br>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
