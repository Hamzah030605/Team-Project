<?php
/**
 * Homepage
 */
require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | Home</title>
    <script src="frontend/home.js"></script>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main>
        <div class="background-image d-flex justify-content-center align-items-center text-center">
            <img src="frontend/images/aboutUs.jpeg" alt="Beauty products flatlay" class="bg-img-file" />
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2 class="display-4 text-white fw-bold hero-title-shadow">Natural Glow, Simplified.</h2>
                <p class="text-white lead mb-4 hero-text-shadow">Premium organic skincare for sensitive skin.</p>
                <a href="products.php" class="btn btn-light btn-lg rounded-pill px-4 hero-cta-btn">Shop New Arrivals</a>
            </div>
        </div>

        <br class="d-none d-lg-block"><br class="d-none d-lg-block">

        <section class="container my-5">
            <h2 class="text-center mb-5 section-title">Top Categories</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <a href="products.php?category=skincare" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="frontend/images/skincare.png" alt="Skincare" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Skincare</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="products.php?category=makeup" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="frontend/images/makeup.png" alt="Makeup" class="img-fluid rounded-circle shadow-sm">
                            </div>
                            <h4 class="fw-semibold">Makeup</h4>
                            <span class="btn btn-link text-dark text-decoration-none">Shop Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="products.php?category=tools" class="category-link">
                        <div class="category-card text-center">
                            <div class="img-wrapper mb-3">
                                <img src="frontend/images/tools.png" alt="Tools" class="img-fluid rounded-circle shadow-sm">
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
