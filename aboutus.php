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

   
  <section class="hero-about text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 section-title">Effortless Beauty. Kind by Design.</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px; color: var(--text-color) !important;">Serenique blends skincare-forward formulas with refined aesthetics â€” for skin that feels as lovely as it looks. Discover the heart and soul behind our brand.</p>
        <div class="mt-4">
            <a class="btn btn-dark rounded-pill px-4 me-2" href="homepage.html">Explore Collections</a>
            <a class="btn btn-outline-dark rounded-pill px-4" href="contactUs.html">Get In Touch</a>
        </div>
    </div>
  </section>
  <hr class="my-0">

  <main class="container py-5">
    
    <section class="py-5">
      <div class="row align-items-center">
        <div class="col-lg-5 mb-4 mb-lg-0">
          <div class="founder-image-wrapper">
            <img src="uploads/aboutuspage.png" alt="Founder of Serenique" class="img-fluid shadow-lg">
          </div>
        </div>

        <div class="col-lg-7">
          <h2 class="section-title text-start">Who We Are</h2>
          <p class="lead" style="color: var(--text-color);">Serenique was born from a belief that beauty should feel natural, nourishing, and thoughtfully made. We craft products that marry effective, skin-friendly ingredients with elegant finishes â€” designed for everyday luxury.</p>

          <h3 class="fw-semibold mt-4">Our Mission</h3>
          <p style="color: var(--text-color);">To empower confidence by creating cosmetics that care for skin, respect the planet, and celebrate individuality.</p>

          <blockquote class="blockquote mt-4 border-start border-3 ps-3" style="border-color: var(--primary-color) !important;">
            <p class="mb-0" style="color: var(--text-color);"><em>"Serenique began as a quiet obsession with texture and tone â€” harmony between makeup and skin care. We make products I trust on my own skin."</em></p>
            <footer class="blockquote-footer mt-1" style="color: var(--text-color);">
                <cite title="Founder's Name">The Founder</cite>
            </footer>
          </blockquote>
        </div>
      </div>
    </section>

    <hr>

    <section class="py-5 text-center">
      <h2 class="section-title">Our Values</h2>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="value p-3">
            <div class="value-icon">ðŸŒ¿</div>
            <h4 class="fw-semibold">Authenticity</h4>
            <p class="text-muted" style="color: var(--text-color) !important;">Beauty starts with being true to yourself â€” products that enhance, never mask.</p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="value p-3">
            <div class="value-icon">âœ¨</div>
            <h4 class="fw-semibold">Quality First</h4>
            <p class="text-muted" style="color: var(--text-color) !important;">Premium ingredients and meticulous formulation are our standard.</p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="value p-3">
            <div class="value-icon">ðŸ’›</div>
            <h4 class="fw-semibold">Kindness</h4>
            <p class="text-muted" style="color: var(--text-color) !important;">Gentle on skin, kind to animals, mindful of the planet.</p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="value p-3">
            <div class="value-icon">ðŸ”¬</div>
            <h4 class="fw-semibold">Innovation</h4>
            <p class="text-muted" style="color: var(--text-color) !important;">We blend skincare science and beauty artistry to move routines forward.</p>
          </div>
        </div>
      </div>
    </section>

    <hr>

    <section class="py-5">
      <div class="row align-items-center">
        <div class="col-lg-6">
            <h2 class="section-title text-start">The Serenique Promise</h2>
            <p class="lead" style="color: var(--text-color);">We prioritize safe, efficacious botanicals and thoughtfully selected actives. Our promise is built on **transparent labeling**, **cruelty-free testing**, and **mindful packaging choices**.</p>
            <p style="color: var(--text-color);">We are committed to delivering products that not only make you look good but feel good about what you're putting on your skin and the impact you're having on the world.</p>
        </div>
        <div class="col-lg-6">
            <ul class="list-unstyled mt-3 ps-3">
                <li class="d-flex align-items-start mb-2">
                    <span class="value-icon me-3">âœ”ï¸?</span>
                    <div>
                        <h5 class="fw-semibold mb-0">Clean Formulation</h5>
                        <p class="text-muted mb-0" style="color: var(--text-color) !important;">No parabens, sulfates, or phthalates ever.</p>
                    </div>
                </li>
                <li class="d-flex align-items-start mb-2">
                    <span class="value-icon me-3">ðŸ?°</span>
                    <div>
                        <h5 class="fw-semibold mb-0">Ethical Sourcing</h5>
                        <p class="text-muted mb-0" style="color: var(--text-color) !important;">Cruelty-free commitment with vegan options available.</p>
                    </div>
                </li>
                <li class="d-flex align-items-start mb-2">
                    <span class="value-icon me-3">â™»ï¸?</span>
                    <div>
                        <h5 class="fw-semibold mb-0">Sustainable Packaging</h5>
                        <p class="text-muted mb-0" style="color: var(--text-color) !important;">Prioritizing sustainable and recyclable primary containers.</p>
                    </div>
                </li>
            </ul>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

