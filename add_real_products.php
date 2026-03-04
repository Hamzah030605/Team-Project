<?php
/**
 * One-time script: inserts real products with real images.
 * Visit once, then DELETE this file.
 * URL: http://cs2team57.cs2410-web01pvm.aston.ac.uk/add_real_products.php
 */
require_once __DIR__ . '/includes/config.php';

// Admin user id = 1
$adminId = 1;

$products = [

    // ── MAKEUP ──────────────────────────────────────────────────────────
    [
        'name'        => 'No7 Gel Finish Nail Polish Colour',
        'price'       => 9.99,
        'description' => 'Long-lasting gel-finish nail polish with a high-shine, chip-resistant formula for a salon-quality look at home.',
        'category'    => 'Makeup',
        'image'       => 'frontend/images/Makeup/No7 Gel Finish Nail Polish Colour.jpeg',
        'stock'       => 45,
    ],
    [
        'name'        => 'No7 Gel Finish Top Coat 10ml',
        'price'       => 7.99,
        'description' => 'Seals and protects nail colour with a brilliant glossy finish that extends wear up to 10 days.',
        'category'    => 'Makeup',
        'image'       => 'frontend/images/Makeup/No7 Gel Finish Top Coat 10ml.jpeg',
        'stock'       => 60,
    ],
    [
        'name'        => 'No7 Nourishing Nail & Cuticle Care Pen',
        'price'       => 8.99,
        'description' => 'Intensive nourishing pen enriched with vitamins to hydrate cuticles and strengthen nails.',
        'category'    => 'Makeup',
        'image'       => 'frontend/images/Makeup/No7 Nourishing Nail & Cuticle Care Pen .avif',
        'stock'       => 40,
    ],
    [
        'name'        => 'No7 Stay Perfect Nail Colour',
        'price'       => 9.99,
        'description' => 'Stay Perfect nail colour delivers bold, even coverage with a cruelty-free brush for a flawless finish.',
        'category'    => 'Makeup',
        'image'       => 'frontend/images/Makeup/No7 Stay Perfect Nail Colour.jpeg',
        'stock'       => 50,
    ],
    [
        'name'        => 'No7 Stay Perfect Top Coat',
        'price'       => 7.99,
        'description' => 'Fast-drying top coat that locks in colour and prevents chipping for a long-lasting manicure.',
        'category'    => 'Makeup',
        'image'       => 'frontend/images/Makeup/No7 Stay Perfect Top Coat.avif',
        'stock'       => 55,
    ],

    // ── HAIRCARE ─────────────────────────────────────────────────────────
    [
        'name'        => 'Garnier Ultimate Blends Glowing Lengths Pineapple',
        'price'       => 7.99,
        'description' => 'Pineapple-infused formula that smooths and adds luminous shine to lengths and ends.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Garnier Ultimate Blends Glowing Lengths Pineapple.avif',
        'stock'       => 70,
    ],
    [
        'name'        => 'Garnier Ultimate Blends Hair Food Coconut Oil 3-in-1',
        'price'       => 8.99,
        'description' => 'Versatile 3-in-1 coconut oil treatment — use as a mask, conditioner or leave-in for ultra-soft hair.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Garnier Ultimate Blends Hair Food, Coconut Oil 3-in-.avif',
        'stock'       => 65,
    ],
    [
        'name'        => "L'Oréal Paris Elvive Glycolic Gloss 5 Minute Lamination",
        'price'       => 12.99,
        'description' => 'Salon-style 5-minute lamination treatment with glycolic acid for mirror-shine, glass-smooth hair.',
        'category'    => 'Haircare',
        'image'       => "frontend/images/hair/L'Oréal Paris Elvive Glycolic Gloss 5 Minute Lamination.avif",
        'stock'       => 48,
    ],
    [
        'name'        => "L'Oréal Paris Elvive Glycolic Gloss Conditioner 150ml",
        'price'       => 9.99,
        'description' => 'Glycolic acid conditioner that smooths the hair surface for incredible reflective shine.',
        'category'    => 'Haircare',
        'image'       => "frontend/images/hair/L'Oréal Paris Elvive Glycolic Gloss Conditoner 150ml.avif",
        'stock'       => 55,
    ],
    [
        'name'        => "L'Oréal Paris Elvive Glycolic Gloss Leave-In Serum",
        'price'       => 11.99,
        'description' => 'No-rinse leave-in serum that delivers continuous shine and frizz control throughout the day.',
        'category'    => 'Haircare',
        'image'       => "frontend/images/hair/L'Oréal Paris Elvive Glycolic Gloss Leave-In Serum.avif",
        'stock'       => 42,
    ],
    [
        'name'        => "L'Oréal Paris Elvive Glycolic Gloss Shampoo 200ml",
        'price'       => 8.99,
        'description' => 'Cleansing shampoo with glycolic acid that removes buildup and boosts natural hair shine.',
        'category'    => 'Haircare',
        'image'       => "frontend/images/hair/L'Oréal Paris Elvive Glycolic Gloss Shampoo 200ml.avif",
        'stock'       => 60,
    ],
    [
        'name'        => 'Monday Leave In Conditioner Moisture 150ml',
        'price'       => 10.99,
        'description' => 'Lightweight moisture-boosting leave-in conditioner that detangles and softens without weighing hair down.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Monday Leave In Conditioner Moisture 150ml.avif',
        'stock'       => 38,
    ],
    [
        'name'        => 'Pantene 7-in-1 Weightless Hair Oil Mist with Biotin',
        'price'       => 9.99,
        'description' => 'Feather-light oil mist with biotin that conditions, detangles, protects and adds shine in one step.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene 7-in-1 Weightless Hair Oil Mist with Biotin.avif',
        'stock'       => 52,
    ],
    [
        'name'        => 'Pantene Grow Abundant Anti-Hair Loss Scalp Serum 60ml',
        'price'       => 12.99,
        'description' => 'Targeted scalp serum clinically shown to reduce hair loss and strengthen hair from the root.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene Grow Abundant Anti-Hair Loss Scalp Serum 60ml .avif',
        'stock'       => 35,
    ],
    [
        'name'        => 'Pantene Grow Abundant Anti-Hair Loss Shampoo',
        'price'       => 7.99,
        'description' => 'Caffeine and biotin enriched shampoo that strengthens hair to reduce breakage with every wash.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene Grow Abundant Anti-Hair Loss Shampoo.avif',
        'stock'       => 70,
    ],
    [
        'name'        => 'Pantene Molecular Bond Repair Hair Conditioner',
        'price'       => 9.99,
        'description' => 'Advanced bond-repair conditioner that rebuilds damaged hair structure from the inside out.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene Molecular Bond Repair Hair Conditioner wit.avif',
        'stock'       => 45,
    ],
    [
        'name'        => 'Pantene Pro-V Repair & Protect Keratin Protect Hair',
        'price'       => 8.99,
        'description' => 'Keratin-infused Pro-V formula that repairs damage and protects against future breakage.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene Pro-V Repair & Protect Keratin Protect Hair.avif',
        'stock'       => 58,
    ],
    [
        'name'        => 'Pantene ProV Moisture Recharge Heat & Glow',
        'price'       => 9.99,
        'description' => 'Heat-activated moisture treatment that protects against styling damage while adding brilliant gloss.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene ProV Moisture Recharge Heat & Glow.avif',
        'stock'       => 40,
    ],
    [
        'name'        => 'Pantene Repair & Protect Hair Oil With Vitamin E',
        'price'       => 10.99,
        'description' => 'Vitamin E enriched hair oil that deeply nourishes, adds shine and protects from heat damage.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Pantene Repair & Protect Hair Oil With Vitamın E.avif',
        'stock'       => 48,
    ],
    [
        'name'        => 'TRESemmé Conditioner Beauty-Full Strength 680ml',
        'price'       => 8.99,
        'description' => 'Pro-performance large-size conditioner that strengthens and adds volume to fine, flat hair.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/TRESemmé Conditioner Beauty-Full Strength 680ml.avif',
        'stock'       => 62,
    ],
    [
        'name'        => 'Toni & Guy Sea Salt Texturising Spray 200ml',
        'price'       => 7.99,
        'description' => 'Creates effortless beachy waves and lived-in texture with a natural matte finish.',
        'category'    => 'Haircare',
        'image'       => 'frontend/images/hair/Toni & Guy Sea Salt Texturising Spray 200ml.avif',
        'stock'       => 55,
    ],

    // ── FRAGRANCE ─────────────────────────────────────────────────────────
    [
        'name'        => 'Cosmic Kylie Jenner Eau de Parfum 100ml',
        'price'       => 49.99,
        'description' => 'A warm, cosmic floral scent with notes of bergamot, jasmine and sandalwood.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Cosmic Kylie Jenner Eau de Parfum 100ml.avif',
        'stock'       => 30,
    ],
    [
        'name'        => 'Cosmic Kylie Jenner Intense Eau de Parfum 100ml',
        'price'       => 54.99,
        'description' => 'A more intense version of Cosmic with deeper amber, musk and vanilla base notes.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Cosmic Kylie Jenner Intense Eau de Parfum 100ml.avif',
        'stock'       => 28,
    ],
    [
        'name'        => 'DIOR Addict Peachy Glow Eau De Parfum 50ml',
        'price'       => 89.99,
        'description' => 'A feminine floral fruity fragrance with sparkling peach, rose and creamy sandalwood.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/DIOR Addict Peachy Glow Eau De Parfum 50ml.avif',
        'stock'       => 22,
    ],
    [
        'name'        => 'DIOR Addict Rosy Glow Eau De Parfum 50ml',
        'price'       => 89.99,
        'description' => 'Delicate and romantic with sheer rose, pink pepper and white musk for a glowing femininity.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/DIOR Addict Rosy Glow Eau De Parfum 50ml.avif',
        'stock'       => 20,
    ],
    [
        'name'        => "DIOR J'adore Eau De Parfum 50ml",
        'price'       => 99.99,
        'description' => "The iconic DIOR floral bouquet — a timeless blend of ylang-ylang, rose and jasmine.",
        'category'    => 'Fragrance',
        'image'       => "frontend/images/perfume/DIOR J'adore Eau De Parfum 50ml.avif",
        'stock'       => 18,
    ],
    [
        'name'        => 'DIOR Miss Dior Eau de Parfum 100ml',
        'price'       => 129.99,
        'description' => 'The full-size iconic Miss Dior — a joyful burst of fresh peony and rose with a musky drydown.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/DIOR Miss Dior Eau de Parfum 100ml.avif',
        'stock'       => 15,
    ],
    [
        'name'        => 'DIOR Miss Dior Eau de Parfum 30ml',
        'price'       => 69.99,
        'description' => 'Travel-size Miss Dior — fresh, floral and fearlessly feminine with rose and precious woods.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/DIOR Miss Dior Eau de Parfum 30ml.avif',
        'stock'       => 25,
    ],
    [
        'name'        => 'Emporio Armani Diamonds Rose Eau de Toilette 50ml',
        'price'       => 69.99,
        'description' => 'A sparkling floral with lychee, rose and jasmine for a vibrant, modern femininity.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Emporio Armani Diamonds Rose Eau de Toilette 50ml.avif',
        'stock'       => 27,
    ],
    [
        'name'        => 'Emporio Armani Power of You Eau de Parfum for Her',
        'price'       => 74.99,
        'description' => 'A bold and empowering fragrance with pink pepper, rose and woody amber.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Emporio Armani Power of You Eau de Parfum for her.avif',
        'stock'       => 24,
    ],
    [
        'name'        => "Lancôme La Vie Est Belle Eau de Parfum 30ml",
        'price'       => 59.99,
        'description' => 'The happiness fragrance — an iconic iris gourmand with praline and patchouli.',
        'category'    => 'Fragrance',
        'image'       => "frontend/images/perfume/Lancôme La Vie Est Belle Eau de Parfum 30ml.avif",
        'stock'       => 32,
    ],
    [
        'name'        => 'Prada Paradoxe Eau de Parfum 30ml',
        'price'       => 79.99,
        'description' => 'A modern paradox of white florals — jasmine, neroli and white musks that reinvent themselves.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Prada Paradoxe Eau de Parfum 30ml.avif',
        'stock'       => 20,
    ],
    [
        'name'        => 'Rabanne Olympea Eau De Parfum 80ml',
        'price'       => 84.99,
        'description' => 'A bold goddess scent — green tea, vanilla and water jasmine wrapped in a warm sensuality.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Rabanne Olympea Eau De Parfum 80ml .avif',
        'stock'       => 22,
    ],
    [
        'name'        => 'TOM FORD Black Orchid Eau de Parfum 30ml',
        'price'       => 89.99,
        'description' => 'Dark, luxurious and seductive — black truffle, ylang-ylang and patchouli in a rich oriental.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/TOM FORD Black Orchid Eau de Parfum Spray 30ml.avif',
        'stock'       => 14,
    ],
    [
        'name'        => "TOM FORD Ombré Leather Eau de Parfum 100ml",
        'price'       => 159.99,
        'description' => 'A sensual leather with cardamom, jasmine and amber — bold and unapologetically seductive.',
        'category'    => 'Fragrance',
        'image'       => "frontend/images/perfume/TOM FORD Ombré Leather Eau de Parfum 100ml.avif",
        'stock'       => 10,
    ],
    [
        'name'        => 'Valentino Born In Roma Uomo Intense Eau de Parfum',
        'price'       => 79.99,
        'description' => 'An intense masculine woody fragrance with vetiver, bergamot and intense cedar.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/Valentino Born In Roma Uomo Intense Eau de.avif',
        'stock'       => 18,
    ],
    [
        'name'        => 'YSL Black Opium Eau de Parfum 30ml',
        'price'       => 64.99,
        'description' => 'Addictive and edgy — black coffee, white flowers and vanilla in an iconic rock chic bottle.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/YSL Black Opium Eau de Parfum 30ml.avif',
        'stock'       => 28,
    ],
    [
        'name'        => 'YSL Libre Berry Crush Fruity Floral Eau De Parfum 30ml',
        'price'       => 74.99,
        'description' => 'A vibrant fruity twist on the iconic Libre — mixed berries, lavender and musk.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/YSL Libre Berry Crush - Fruity Floral Eau De Parfum 30ml .avif',
        'stock'       => 22,
    ],
    [
        'name'        => 'YSL Libre Eau de Parfum 30ml',
        'price'       => 64.99,
        'description' => 'The spirit of freedom — Moroccan lavender and Madagascan vanilla in a bold, sensual blend.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/YSL Libre Eau de Parfum 30ml.avif',
        'stock'       => 30,
    ],
    [
        'name'        => 'YSL Libre Intense Eau De Parfum 90ml',
        'price'       => 109.99,
        'description' => 'An intensified version of Libre with deeper amber, musk and vanilla facets.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/YSL Libre Intense Eau De Parfum 90ml.avif',
        'stock'       => 16,
    ],
    [
        'name'        => 'YSL MYSLF Eau de Parfum 60ml',
        'price'       => 89.99,
        'description' => 'A daring citrus woody fragrance — bergamot, ambroxan and vanilla for the modern man.',
        'category'    => 'Fragrance',
        'image'       => 'frontend/images/perfume/YSL MYSLF Eau de Parfum 60ml.avif',
        'stock'       => 20,
    ],

    // ── SKINCARE ──────────────────────────────────────────────────────────
    [
        'name'        => 'CeraVe Intensive Moisturising Lotion 5% Hydro-Urea 473ml',
        'price'       => 14.99,
        'description' => 'Clinically proven lotion with 5% hydroxy urea for very dry, itchy skin — restores the skin barrier.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Intensive Moisturising Lotion with 5% Hydro-Urea for Very Dry, Itchy Skin 473ml ',
        'stock'       => 40,
    ],
    [
        'name'        => 'CeraVe Moisturising Cream Pot with Hyaluronic Acid',
        'price'       => 12.99,
        'description' => 'Rich cream pot with hyaluronic acid and ceramides that deeply hydrates and restores the skin barrier.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Moisturising Cream Pot with Hyaluronic Acid &.avif',
        'stock'       => 55,
    ],
    [
        'name'        => 'CeraVe Moisturising Cream Pump with Hyaluronic Acid',
        'price'       => 12.99,
        'description' => 'Convenient pump-dispenser moisturiser with hyaluronic acid for continuous 24-hour hydration.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Moisturising Cream Pump with Hyaluronic Acid.avif',
        'stock'       => 50,
    ],
    [
        'name'        => 'CeraVe Moisturising Lotion 1L',
        'price'       => 16.99,
        'description' => 'Large family-size moisturising lotion with ceramides and hyaluronic acid for everyday body hydration.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Moisturising Lotion 1L.avif',
        'stock'       => 45,
    ],
    [
        'name'        => 'CeraVe Moisturising Lotion with Ceramides for Face and Body',
        'price'       => 12.99,
        'description' => 'Lightweight lotion with three essential ceramides that moisturises face and body without greasiness.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Moisturising Lotion with Ceramides. Face and.avif',
        'stock'       => 60,
    ],
    [
        'name'        => 'CeraVe Moisturising Lotion with Hyaluronic Acid',
        'price'       => 11.99,
        'description' => 'Fast-absorbing lotion with hyaluronic acid that delivers instant and lasting moisture for normal to dry skin.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/CeraVe Moisturising Lotion with Hyaluronic Acid &.avif',
        'stock'       => 58,
    ],
    [
        'name'        => 'CeraVe Advanced Repair Ointment for Very Dry Skin',
        'price'       => 13.99,
        'description' => 'Intensive protective ointment with petrolatum and ceramides for very dry, cracked and damaged skin.',
        'category'    => 'Skincare',
        'image'       => 'frontend/images/skincare/Cerave Advanced Repair Ointment for Very Dry and.avif',
        'stock'       => 35,
    ],
];

// ── Insert ────────────────────────────────────────────────────────────────
$inserted = 0;
$skipped  = 0;
$errors   = [];

$stmt = $conn->prepare(
    "INSERT INTO products (name, price, description, category, image, stock, posted_by, created_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
);

foreach ($products as $p) {
    // Skip duplicates
    $chk = $conn->prepare("SELECT id FROM products WHERE name = ?");
    $chk->bind_param("s", $p['name']);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows > 0) { $skipped++; $chk->close(); continue; }
    $chk->close();

    $stmt->bind_param(
        "sdsssis",
        $p['name'], $p['price'], $p['description'],
        $p['category'], $p['image'], $p['stock'], $adminId
    );

    if ($stmt->execute()) {
        $inserted++;
    } else {
        $errors[] = "Failed: {$p['name']} — " . $stmt->error;
    }
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head><title>Product Import</title>
<style>
  body { font-family: monospace; padding: 24px; background: #fdf8f5; }
  h2   { color: #d27b5a; }
  .ok  { color: green; }
  .warn{ color: orange; }
  .err { color: red; }
  table{ border-collapse: collapse; margin-top: 12px; }
  td,th{ border: 1px solid #ddd; padding: 6px 12px; font-size: .85rem; }
  th   { background: #f0ebe6; }
</style>
</head>
<body>
<h2>Product Import Results</h2>
<p class="ok">✅ Inserted: <strong><?php echo $inserted; ?></strong></p>
<p class="warn">⏭ Skipped (already exist): <strong><?php echo $skipped; ?></strong></p>

<?php if ($errors): ?>
<h3 class="err">Errors:</h3>
<ul><?php foreach ($errors as $e): ?><li class="err"><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?></ul>
<?php endif; ?>

<h3>Products now in database:</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Image</th></tr>
<?php
$all = $conn->query("SELECT id, name, category, price, stock, image FROM products ORDER BY category, name");
while ($row = $all->fetch_assoc()):
?>
<tr>
  <td><?php echo $row['id']; ?></td>
  <td><?php echo htmlspecialchars($row['name']); ?></td>
  <td><?php echo htmlspecialchars($row['category']); ?></td>
  <td>£<?php echo number_format($row['price'], 2); ?></td>
  <td><?php echo $row['stock']; ?></td>
  <td style="font-size:.75rem;color:#888"><?php echo htmlspecialchars($row['image']); ?></td>
</tr>
<?php endwhile; ?>
</table>

<p style="margin-top:20px;color:red;font-weight:bold;">
  DELETE this file (add_real_products.php) from the server immediately!
</p>
<p><a href="/products.php">→ View Products Page</a></p>
</body>
</html>
