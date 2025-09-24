<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="auth-container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?> 👋</h2>
    <p>You are logged in to SmartAid!</p>
    <a href="index.php?action=logout">Logout</a>
</div>
</body>
</html>