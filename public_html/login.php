<?php
/**
 * Login Page
 */
require_once __DIR__ . '/session.php';

$u = SITE_URL;

if (isLoggedIn()) {
    redirect('homepage.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $conn = getDB();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            loginUser($user);
            setFlash('success', 'Welcome back, ' . $user['username'] . '!');
            redirect('homepage.php');
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

$success = getFlash('success');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Serenique | Login</title>
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
                <h1>Welcome Back</h1>
                <p class="text-muted">Sign in to your Serenique account</p>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo e($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           value="<?php echo e($_POST['email'] ?? ''); ?>" placeholder="your@email.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-auth">Sign In</button>
            </form>

            <div class="auth-footer">
                <p class="mb-0">Don't have an account? <a href="<?php echo $u; ?>/register.php" style="color: #d27b5a; font-weight: 600;">Create one</a></p>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
