<?php
/**
 * One-time setup: adds subcategory column and assigns all products.
 * Visit once, then DELETE this file.
 * URL: http://cs2team57.cs2410-web01pvm.aston.ac.uk/setup_subcategories.php
 */
require_once __DIR__ . '/includes/config.php';

$log = [];

// 1. Add subcategory column if it doesn't exist
$cols = $conn->query("SHOW COLUMNS FROM products LIKE 'subcategory'");
if ($cols->num_rows === 0) {
    $conn->query("ALTER TABLE products ADD COLUMN subcategory VARCHAR(50) DEFAULT NULL AFTER category");
    $log[] = "✅ Added 'subcategory' column to products table.";
} else {
    $log[] = "ℹ️ 'subcategory' column already exists — skipping ALTER.";
}

// 2. Map: product name keyword  →  subcategory value
// subcategory values MUST match the ?sub= values in nav.php
$mappings = [

    // ── SKINCARE ─────────────────────────────────────────────────
    // Serums
    'Rose Hydrating Serum'               => 'serum',
    'Vitamin C Brightening Serum'        => 'serum',
    'AHA BHA Exfoliating Serum'          => 'serum',
    'Bakuchiol Anti-Aging Serum'         => 'serum',
    'Squalane Facial Oil'                => 'serum',
    'Niacinamide Pore Minimizer'         => 'serum',
    'Salicylic Acid Spot Treatment'      => 'serum',
    'Probiotic Skin Balance Serum'       => 'serum',
    'Peptide Eye Cream'                  => 'serum',
    // Cleansers
    'Gentle Foaming Cleanser'            => 'cleanser',
    'Rose Cleansing Balm'                => 'cleanser',
    'Enzyme Exfoliating Powder'          => 'cleanser',
    // Creams / Moisturisers
    'Retinol Night Cream'                => 'cream',
    'Hyaluronic Acid Moisturizer'        => 'cream',
    'Collagen Boosting Cream'            => 'cream',
    'Ceramide Barrier Repair Cream'      => 'cream',
    'Centella Calming Gel'               => 'cream',
    'Mineral Sunscreen SPF 50'           => 'cream',
    'CeraVe Intensive Moisturising Lotion 5% Hydro-Urea 473ml' => 'cream',
    'CeraVe Moisturising Cream Pot with Hyaluronic Acid'       => 'cream',
    'CeraVe Moisturising Cream Pump with Hyaluronic Acid'      => 'cream',
    'CeraVe Moisturising Lotion 1L'                            => 'cream',
    'CeraVe Moisturising Lotion with Ceramides for Face and Body' => 'cream',
    'CeraVe Moisturising Lotion with Hyaluronic Acid'          => 'cream',
    'CeraVe Advanced Repair Ointment for Very Dry Skin'        => 'cream',
    // Toners
    'Green Tea Antioxidant Toner'        => 'toner',
    // Masks
    'Overnight Recovery Mask'            => 'mask',

    // ── MAKEUP ───────────────────────────────────────────────────
    // Lipsticks
    'Sheer Matte Lipstick'               => 'lipstick',
    'Velvet Lip Gloss'                   => 'lipstick',
    'Lip Liner Pencil Set'               => 'lipstick',
    // Foundation / Base
    'Silk Foundation SPF 15'             => 'foundation',
    'Creamy Concealer Stick'             => 'foundation',
    'Setting Powder Translucent'         => 'foundation',
    'Primer Pore Blurring'               => 'foundation',
    'Setting Spray Matte Finish'         => 'foundation',
    // Mascara / Eyes
    'Volumizing Mascara'                 => 'mascara',
    'Waterproof Eyeliner Pen'            => 'mascara',
    'Lash Curler Deluxe'                 => 'mascara',
    // Eyeshadow
    'Eyeshadow Palette Nude'             => 'eyeshadow',
    'Eyeshadow Palette Sunset'           => 'eyeshadow',
    'Baked Highlighter'                  => 'eyeshadow',
    'Contour Palette'                    => 'eyeshadow',
    'Bronzer Duo'                        => 'eyeshadow',
    'Cream Blush Stick'                  => 'eyeshadow',
    'Brow Pomade'                        => 'eyeshadow',
    // No7 nail — map to foundation (base/nails)
    'No7 Gel Finish Nail Polish Colour'  => 'foundation',
    'No7 Gel Finish Top Coat 10ml'       => 'foundation',
    'No7 Nourishing Nail & Cuticle Care Pen' => 'foundation',
    'No7 Stay Perfect Nail Colour'       => 'foundation',
    'No7 Stay Perfect Top Coat'          => 'foundation',

    // ── HAIRCARE ─────────────────────────────────────────────────
    // Shampoo
    'Argan Oil Shampoo'                              => 'shampoo',
    'Dry Shampoo Volume'                             => 'shampoo',
    'Purple Shampoo Blonde'                          => 'shampoo',
    'Anti-Dandruff Shampoo'                          => 'shampoo',
    "L'Oréal Paris Elvive Glycolic Gloss Shampoo 200ml"  => 'shampoo',
    'Pantene Grow Abundant Anti-Hair Loss Shampoo'   => 'shampoo',
    // Conditioner
    'Keratin Repair Conditioner'                     => 'conditioner',
    'Leave-In Conditioner'                           => 'conditioner',
    "L'Oréal Paris Elvive Glycolic Gloss Conditioner 150ml" => 'conditioner',
    "L'Oréal Paris Elvive Glycolic Gloss Leave-In Serum"    => 'conditioner',
    'Monday Leave In Conditioner Moisture 150ml'             => 'conditioner',
    'Pantene Molecular Bond Repair Hair Conditioner'         => 'conditioner',
    'TRESemmé Conditioner Beauty-Full Strength 680ml'        => 'conditioner',
    // Hair Oils / Serums
    'Silk Hair Oil'                                  => 'oil',
    'Hair Growth Serum'                              => 'oil',
    'Scalp Treatment Serum'                          => 'oil',
    'Pantene 7-in-1 Weightless Hair Oil Mist with Biotin'    => 'oil',
    'Pantene Grow Abundant Anti-Hair Loss Scalp Serum 60ml'  => 'oil',
    'Pantene Repair & Protect Hair Oil With Vitamin E'       => 'oil',
    'Garnier Ultimate Blends Hair Food Coconut Oil 3-in-1'   => 'oil',
    // Others → shampoo (general wash/treatment)
    'Coconut Hair Mask'                              => 'shampoo',
    'Heat Protection Spray'                          => 'shampoo',
    'Curl Defining Cream'                            => 'conditioner',
    'Hair Thickening Spray'                          => 'shampoo',
    'Bond Repair Treatment'                          => 'conditioner',
    'Texture Spray Sea Salt'                         => 'shampoo',
    'Toni & Guy Sea Salt Texturising Spray 200ml'    => 'shampoo',
    'Garnier Ultimate Blends Glowing Lengths Pineapple' => 'shampoo',
    "L'Oréal Paris Elvive Glycolic Gloss 5 Minute Lamination" => 'conditioner',
    'Pantene Pro-V Repair & Protect Keratin Protect Hair' => 'shampoo',
    'Pantene ProV Moisture Recharge Heat & Glow'     => 'oil',

    // ── TOOLS ────────────────────────────────────────────────────
    // Brushes
    'Professional Brush Set 12pc'        => 'brush',
    'Lash Curler Deluxe'                 => 'brush',
    'Eyelash Curler'                     => 'brush',
    'Dermaplaning Tool Set'              => 'brush',
    // Sponges
    'Beauty Blender Set'                 => 'sponge',
    'Silicone Face Scrubber'             => 'sponge',
    // Face Rollers / Devices
    'Rose Quartz Face Roller'            => 'roller',
    'Jade Gua Sha Set'                   => 'roller',
    'Ice Roller'                         => 'roller',
    'Micro-Needling Roller'              => 'roller',
    'LED Face Mask'                      => 'roller',
    'Facial Steamer'                     => 'roller',
    'Makeup Mirror LED'                  => 'roller',

    // ── FRAGRANCE ────────────────────────────────────────────────
    // Body Mists
    'Ocean Breeze Body Mist'             => 'mist',
    'Fresh Cotton Body Spray'            => 'mist',
    'White Musk Body Spray'              => 'mist',
    'Cherry Blossom Mist'                => 'mist',
    'Coconut Paradise Mist'              => 'mist',
    // Everything else → parfum
    'Rose Garden Eau de Parfum'          => 'parfum',
    'Vanilla Dreams Perfume Oil'         => 'parfum',
    'Lavender Fields EDT'                => 'parfum',
    'Citrus Burst Cologne'               => 'parfum',
    'Midnight Jasmine EDP'               => 'parfum',
    'Sandalwood Meditation'              => 'parfum',
    'Green Tea Cologne'                  => 'parfum',
    'Peony Blush EDP'                    => 'parfum',
    'Amber Nights Perfume'               => 'parfum',
    'Oud Luxe Parfum'                    => 'parfum',
    'Cosmic Kylie Jenner Eau de Parfum 100ml'        => 'parfum',
    'Cosmic Kylie Jenner Intense Eau de Parfum 100ml'=> 'parfum',
    'DIOR Addict Peachy Glow Eau De Parfum 50ml'     => 'parfum',
    'DIOR Addict Rosy Glow Eau De Parfum 50ml'       => 'parfum',
    "DIOR J'adore Eau De Parfum 50ml"                => 'parfum',
    'DIOR Miss Dior Eau de Parfum 100ml'             => 'parfum',
    'DIOR Miss Dior Eau de Parfum 30ml'              => 'parfum',
    'Emporio Armani Diamonds Rose Eau de Toilette 50ml' => 'parfum',
    'Emporio Armani Power of You Eau de Parfum for Her' => 'parfum',
    "Lancôme La Vie Est Belle Eau de Parfum 30ml"    => 'parfum',
    'Prada Paradoxe Eau de Parfum 30ml'              => 'parfum',
    'Rabanne Olympea Eau De Parfum 80ml'             => 'parfum',
    'TOM FORD Black Orchid Eau de Parfum 30ml'       => 'parfum',
    "TOM FORD Ombré Leather Eau de Parfum 100ml"     => 'parfum',
    'Valentino Born In Roma Uomo Intense Eau de Parfum' => 'parfum',
    'YSL Black Opium Eau de Parfum 30ml'             => 'parfum',
    'YSL Libre Berry Crush Fruity Floral Eau De Parfum 30ml' => 'parfum',
    'YSL Libre Eau de Parfum 30ml'                   => 'parfum',
    'YSL Libre Intense Eau De Parfum 90ml'           => 'parfum',
    'YSL MYSLF Eau de Parfum 60ml'                   => 'parfum',
];

// 3. Apply mappings
$updated = 0;
$notFound = [];
$stmt = $conn->prepare("UPDATE products SET subcategory = ? WHERE name = ?");

foreach ($mappings as $name => $sub) {
    $stmt->bind_param("ss", $sub, $name);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $updated++;
    } else {
        // Try to find by partial name
        $notFound[] = $name;
    }
}
$stmt->close();
$log[] = "✅ Updated subcategory for <strong>{$updated}</strong> products.";

// 4. Show results
$result = $conn->query("
    SELECT category, subcategory, COUNT(*) as cnt
    FROM products
    GROUP BY category, subcategory
    ORDER BY category, subcategory
");
?>
<!DOCTYPE html>
<html>
<head><title>Subcategory Setup</title>
<style>
body { font-family: monospace; padding: 24px; background: #fdf8f5; }
h2 { color: #d27b5a; }
table { border-collapse: collapse; margin: 12px 0; }
td, th { border: 1px solid #ddd; padding: 6px 14px; }
th { background: #f0ebe6; }
.ok { color: green; } .warn { color: orange; }
</style>
</head>
<body>
<h2>Subcategory Setup Results</h2>
<?php foreach ($log as $l): ?>
    <p><?php echo $l; ?></p>
<?php endforeach; ?>

<h3>Products per Category / Subcategory</h3>
<table>
<tr><th>Category</th><th>Subcategory</th><th>Count</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['category']); ?></td>
    <td><?php echo $row['subcategory'] ? htmlspecialchars($row['subcategory']) : '<span style="color:#aaa">NULL (all products still visible in main category)</span>'; ?></td>
    <td><?php echo $row['cnt']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<?php if ($notFound): ?>
<h3 class="warn">Products not matched (subcategory not set for these):</h3>
<ul><?php foreach ($notFound as $n): ?><li class="warn"><?php echo htmlspecialchars($n); ?></li><?php endforeach; ?></ul>
<?php endif; ?>

<p style="color:red;font-weight:bold;margin-top:20px;">DELETE this file immediately after reviewing!</p>
<p><a href="/products.php">→ View Products</a></p>
</body>
</html>
