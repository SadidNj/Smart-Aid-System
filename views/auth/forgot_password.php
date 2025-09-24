<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="auth-container">
    <h2>Forgot Password</h2>
    <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    
    <form action="index.php?action=forgot_password" method="POST">
        <input type="email" name="email" placeholder="Enter registered email" required>
        <button type="submit">Reset Password</button>
    </form>
    <p><a href="index.php?action=login">Back to Login</a></p>
</div>
</body>
</html>