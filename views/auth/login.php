<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="auth-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>

    <form action="index.php?action=login" method="POST">
        <input type="text" name="username" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Remember Me</label>
        <button type="submit">Login</button>
    </form>
    
    <a href="index.php?action=guest_login" class="guest-button">Continue as Guest</a>
    
    <p>Don’t have an account? <a href="index.php?action=signup">Signup</a></p>
    <p><a href="index.php?action=forgot_password">Forgot Password?</a></p>
</div>
</body>
</html>