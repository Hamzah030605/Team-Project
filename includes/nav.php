<?php
/**
 * Navigation Bar Include
 * Uses dynamic URLs for both LOCAL and ASTON SERVER
 */

// Get user state
$_isLoggedIn = isLoggedIn();
$_username = getCurrentUsername();
$_isAdmin = isAdmin();

// URL helper for nav
$u = SITE_URL;
?>
<header class="py-3"> 
    <div class="container d-flex justify-content-center align-items-center">
        <div class="d-flex align-items-center">
            <img src="<?php echo $u; ?>/frontend/images/logo2.png" alt="Serenique Logo" class="logo-img me-3" />
            <h1 class="m-0">Serenique</h1>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold d-lg-none" href="#">Menu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo $u; ?>/homepage.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $u; ?>/aboutus.php">About Us</a></li>
                
                <!-- SKINCARE -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo $u; ?>/products.php?category=Skincare" role="button" data-bs-toggle="dropdown">Skincare</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare">All Skincare</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare&sub=serum">Serums</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare&sub=cleanser">Cleansers</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare&sub=cream">Creams</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare&sub=toner">Toners</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Skincare&sub=mask">Masks</a></li>
                    </ul>
                </li>

                <!-- MAKEUP -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo $u; ?>/products.php?category=Makeup" role="button" data-bs-toggle="dropdown">Makeup</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Makeup">All Makeup</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Makeup&sub=lipstick">Lipsticks</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Makeup&sub=foundation">Foundation</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Makeup&sub=mascara">Mascara</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Makeup&sub=eyeshadow">Eyeshadow</a></li>
                    </ul>
                </li>

                <!-- HAIRCARE -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo $u; ?>/products.php?category=Haircare" role="button" data-bs-toggle="dropdown">Haircare</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Haircare">All Haircare</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Haircare&sub=shampoo">Shampoo</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Haircare&sub=conditioner">Conditioner</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Haircare&sub=oil">Hair Oils</a></li>
                    </ul>
                </li>

                <!-- TOOLS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo $u; ?>/products.php?category=Tools" role="button" data-bs-toggle="dropdown">Tools</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Tools">All Tools</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Tools&sub=brush">Brushes</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Tools&sub=sponge">Sponges</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Tools&sub=roller">Face Rollers</a></li>
                    </ul>
                </li>

                <!-- FRAGRANCE -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo $u; ?>/products.php?category=Fragrance" role="button" data-bs-toggle="dropdown">Fragrance</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Fragrance">All Fragrance</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Fragrance&sub=parfum">Perfumes</a></li>
                        <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?category=Fragrance&sub=mist">Body Mists</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="<?php echo $u; ?>/products.php">All Products</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $u; ?>/contact.php">Contact Us</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <form class="d-flex search-form" role="search" action="<?php echo $u; ?>/products.php" method="GET">
                    <input class="form-control" type="search" name="search" placeholder="Search products..." aria-label="Search" />
                    <button class="btn btn-search" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </form>

                <button id="mode-toggle" class="btn p-0 border-0" aria-label="Toggle Light and Dark Mode">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                        <path id="moon-icon" d="M6 .278a.768.768 0 0 1 .016.04l.008.034a2.031 2.031 0 0 0 .981 3.511 2.031 2.031 0 0 1 .981 3.511c-1.488 2.07-4.266 2.633-6.387.98-.13-.102-.252-.212-.364-.33A6.5 6.5 0 1 0 6 .278z"/>
                    </svg>
                </button>

                <a href="<?php echo $u; ?>/cart.php" class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 2l1.5 4h9L18 2H6zM3 6h18l-1.5 14H4.5L3 6z"/>
                    </svg>
                </a>

                <div class="dropdown">
                    <a href="#" class="nav-icon dropdown-toggle no-arrow" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        <?php if ($_isLoggedIn): ?>
                            <li><span class="dropdown-item-text fw-bold">Hi, <?php echo e($_username); ?>!</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if ($_isAdmin): ?>
                                <li><a class="dropdown-item" href="<?php echo $u; ?>/admin/dashboard.php">🔐 Admin Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/orders.php">📋 My Orders</a></li>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/add_product.php">➕ Add Product</a></li>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/products.php?mine=1">📦 My Products</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/logout.php">🚪 Logout</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/login.php">Login</a></li>
                            <li><a class="dropdown-item" href="<?php echo $u; ?>/register.php">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
