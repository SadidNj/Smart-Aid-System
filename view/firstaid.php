<?php
// firstaid.php expects $guides variable to be available
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>First Aid Guides</title>
  <link rel="stylesheet" href="assets/css/firstaid.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="assets/img/firstaid.jpg">
</head>
<body>
  <header>
    <nav>
      <img src="assets/img/firstaid.jpg" alt="firstaid logo" width="32" height="32">
      <a href="index.php">Home</a> |
      <a href="index.php?action=list">Guides</a> |
      <a href="index.php?&action=logout">Logout</a>

    </nav>
    <h1>🩺 First Aid Guides</h1>
    <p>Logged in as: <?= htmlspecialchars($_SESSION['user']) ?></p>
    <input type="text" id="searchInput" placeholder="Search guides by title or steps...">
  </header>

  <main>
    <div id="guideList">
      
    </div>
    <div id="guideDetail" style="display:none;"></div>
  </main>

  <script src="assets/js/firstaid.js"></script>
</body>
</html>
