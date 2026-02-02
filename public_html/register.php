<?php
/**
 * Registration Page
 */
require_once __DIR__ . '/session.php';

$u = SITE_URL;

if (isLoggedIn()) {
    redirect('homepage.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $conn = getDB();
        
        // Check if email exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        if ($checkStmt->get_result()->num_rows > 0) {
            $error = 'An account with this email already exists.';
        }
        $checkStmt->close();
        
        // Check if username exists
        if (!$error) {
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $checkStmt->bind_param("s", $username);
            $checkStmt->execute();
            if ($checkStmt->get_result()->num_rows > 0) {
                $error = 'This username is already taken.';
            }
            $checkStmt->close();
        }
        
        if (!$error) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);
            
            if ($stmt->execute()) {
                setFlash('success', 'Account created successfully! Please login.');
                redirect('login.php');
            } else {
                $error = 'Registration failed. Please try again.';
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
    <title>Serenique | Create Account</title>
    <link rel="stylesheet" href="<?php echo $u; ?>/frontend/auth.css">
    <style>
        .auth-container { max-width: 450px; margin: 3rem auto; padding: 2.5rem; background: var(--card-bg, #fff); border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-header h1 { font-family: 'Playfair Display', serif; color: #d27b5a; margin-bottom: 0.5rem; }
        .btn-auth { background: #d27b5a; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600; width: 100%; cursor: pointer; transition: all 0.3s; }
        .btn-auth:hover { background: #b8654a; }
        .auth-footer { text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <main class="container py-4">
        <div class="auth-container">
            <div class="auth-header">
                <h1>Create Account</h1>
                <p class="text-muted">Join Serenique today</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           value="<?php echo e($_POST['username'] ?? ''); ?>" placeholder="Your username">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           value="<?php echo e($_POST['email'] ?? ''); ?>" placeholder="your@email.com">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required 
                           placeholder="At least 6 characters">
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                           placeholder="Repeat your password">
                </div>

                <button type="submit" class="btn-auth">Create Account</button>
            </form>

            <div class="auth-footer">
                <p class="mb-0">Already have an account? <a href="<?php echo $u; ?>/login.php" style="color: #d27b5a; font-weight: 600;">Sign in</a></p>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
