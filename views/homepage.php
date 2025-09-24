<?php
$userRole = $_SESSION['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage - SmartAid</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="homepage-container">
    <header class="homepage-header">
        <h1>Welcome to SmartAid, <?= htmlspecialchars($_SESSION["username"]) ?>!</h1>
        <p>Your role: <span class="role-badge <?= htmlspecialchars($userRole) ?>"><?= htmlspecialchars(ucfirst($userRole)) ?></span></p>

        <?php if ($userRole === 'guest'): ?>
            <a href="index.php?action=login" class="login-prompt-button">Login or Signup</a>
        <?php else: ?>
            <a href="index.php?action=logout" class="logout-button">Logout</a>
        <?php endif; ?>
    </header>

    <main class="dashboard-grid">
        <?php if ($userRole === 'admin'): ?>
        <section class="dashboard-card admin-panel">
            <h3><i class="fas fa-user-shield"></i> Admin Panel</h3>
            <p>Manage application settings and users.</p>
            <div class="card-actions">
                <a href="#">Manage Users</a>
                <a href="#">View Analytics</a>
                <a href="#">System Settings</a>
            </div>
        </section>
        <?php endif; ?>

        <section class="dashboard-card user-dashboard">
            <h3><i class="fas fa-user"></i> Your Dashboard</h3>
            <?php if ($userRole === 'guest'): ?>
                <p class="guest-notice">Your actions are not saved in guest mode. <a href="index.php?action=signup">Create an account</a> to save your progress.</p>
            <?php endif; ?>
            <p>Access your personal tools and information.</p>
            <div class="card-actions">
                <a href="#">View Your Profile</a>
                <a href="#">Check Appointments</a>
                <a href="#">Settings</a>
            </div>
        </section>
        
       <section class="dashboard-card">
    <h3><i class="fas fa-briefcase-medical"></i> ABOUT US</h3>
    <p>Learn more about us.</p>
    <div class="card-actions">
        <a href="index.php?action=about_us">Click Here</a>
    </div>
</section>
    </main>
</div>
</body>
</html>