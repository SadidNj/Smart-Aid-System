<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - SmartAid</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="profile-container">
    <h2>Edit Your Profile</h2>

    <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <?php if (!empty($success)): ?><p class="success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

    <form action="index.php?action=update_profile" method="POST" class="profile-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="e.g., +8801234567890">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($user['location'] ?? '') ?>" placeholder="e.g., Dhaka, Bangladesh">
        </div>

        <button type="submit">Save Changes</button>
        <a href="index.php?action=home" class="back-button-profile">Back to Homepage</a>
    </form>
</div>
</body>
</html>