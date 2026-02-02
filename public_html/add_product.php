<?php
require_once __DIR__ . '/session.php';
requireLogin();
$error = '';
$uploadDir = __DIR__ . '/uploads/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if (empty($name)) {
        $error = 'Product name is required.';
    } elseif ($price <= 0) {
        $error = 'Please enter a valid price.';
    } elseif (empty($category)) {
        $error = 'Please select a category.';
    } else {
        $conn = getDB();
        $userId = getCurrentUserId();
        $image = 'assets/images/products/default.svg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024;
            $fileType = $_FILES['image']['type'];
            $fileSize = $_FILES['image']['size'];
            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Invalid image type. Please upload JPG, PNG, GIF, or WebP.';
            } elseif ($fileSize > $maxSize) {
                $error = 'Image size must be less than 5MB.';
            } else {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
                $uploadPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $image = 'uploads/products/' . $filename;
                } else {
                    $error = 'Failed to upload image. Please try again.';
                }
            }
        }
        if (empty($error)) {
            $sql = "INSERT INTO products (name, price, description, category, image, posted_by) VALUES (?, ?, ?, ?, ?, ?)";
            echo "<pre>";
            echo "SQL: $sql\n";
            echo "Name: $name\n";
            echo "Price: $price\n";
            echo "Category: $category\n";
            echo "Image path: $image\n";
            echo "User ID: $userId\n";
            echo "</pre>";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("<h3 style='color: red;'>SQL PREPARE FAILED</h3>
                     <p>Error: " . htmlspecialchars($conn->error) . "</p>");
            }
            $stmt->bind_param("sdsssi", $name, $price, $description, $category, $image, $userId);
            if ($stmt->execute()) {
                setFlash('success', 'Product added!');
                header('Location: /public_html/products.php?mine=1');
                exit;
            } else {
                die("<h3 style='color: red;'>EXECUTE FAILED</h3>
                     <p>Error: " . htmlspecialchars($stmt->error) . "</p>");
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | Add Product</title>
    <style>
        .add-form { max-width: 700px; margin: 2rem auto; padding: 2rem; background: var(--card-bg, #fff); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .add-form h2 { font-family: 'Playfair Display', serif; margin-bottom: 1.5rem; }
        .image-preview { max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px; display: none; }
        .upload-area { border: 2px dashed #ddd; border-radius: 12px; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.3s; }
        .upload-area:hover { border-color: #d27b5a; background: #fdf5f2; }
        .upload-area.dragover { border-color: #d27b5a; background: #fdf5f2; }
        .upload-icon { font-size: 3rem; color: #d27b5a; }
    </style>
</head>
<body>
    <?php include 'includes/nav.php'; ?>
    <main class="container py-4">
        <div class="add-form">
            <h2>Add New Product</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required
                           placeholder="e.g., Rose Hydrating Serum"
                           value="<?php echo e($_POST['name'] ?? ''); ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price (£) *</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" required
                               placeholder="29.99"
                               value="<?php echo e($_POST['price'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Skincare" <?php echo ($_POST['category'] ?? '') === 'Skincare' ? 'selected' : ''; ?>>Skincare</option>
                            <option value="Makeup" <?php echo ($_POST['category'] ?? '') === 'Makeup' ? 'selected' : ''; ?>>Makeup</option>
                            <option value="Tools" <?php echo ($_POST['category'] ?? '') === 'Tools' ? 'selected' : ''; ?>>Tools</option>
                            <option value="Haircare" <?php echo ($_POST['category'] ?? '') === 'Haircare' ? 'selected' : ''; ?>>Haircare</option>
                            <option value="Fragrance" <?php echo ($_POST['category'] ?? '') === 'Fragrance' ? 'selected' : ''; ?>>Fragrance</option>
                            <option value="Bath & Body" <?php echo ($_POST['category'] ?? '') === 'Bath & Body' ? 'selected' : ''; ?>>Bath & Body</option>
                            <option value="Wellness" <?php echo ($_POST['category'] ?? '') === 'Wellness' ? 'selected' : ''; ?>>Wellness</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" 
                              placeholder="Describe your product..."><?php echo e($_POST['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Product Image</label>
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('image').click()">
                        <div class="upload-icon">📷</div>
                        <p class="mb-1"><strong>Click to upload</strong> or drag and drop</p>
                        <p class="text-muted small mb-0">PNG, JPG, GIF, or WebP (max 5MB)</p>
                    </div>
                    <input type="file" class="d-none" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                    <img id="imagePreview" class="image-preview" alt="Preview">
                    <p id="fileName" class="text-muted small mt-2"></p>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary px-4">
                        ➕ Add Product
                    </button>
                    <a href="/public_html/products.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script>
        const uploadArea = document.getElementById('uploadArea');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const fileName = document.getElementById('fileName');
        imageInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                }
                reader.readAsDataURL(file);
            }
        });
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                imageInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>