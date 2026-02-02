<?php
/**
 * About Us Page
 */
require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | About Us</title>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 mb-4" style="font-family: 'Playfair Display', serif;">About Serenique</h1>
                <p class="lead">We believe in the power of clean, natural beauty.</p>
                <p>Serenique was founded with a simple mission: to create premium skincare and beauty products that are as kind to your skin as they are to the environment.</p>
                <p>Our products are:</p>
                <ul>
                    <li>✨ 100% Cruelty-Free</li>
                    <li>🌿 Made with Organic Ingredients</li>
                    <li>♻️ Sustainably Packaged</li>
                    <li>🧪 Dermatologically Tested</li>
                </ul>
                <p>Join thousands of customers who have discovered their natural glow with Serenique.</p>
                <a href="products.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
            </div>
            <div class="col-lg-6">
                <img src="frontend/images/aboutUs.jpeg" alt="About Serenique" class="img-fluid rounded shadow">
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

