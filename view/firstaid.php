<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>First Aid Guides</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body {
      background: url("assets/img/firstaid-bg.jpg") no-repeat center center fixed;
      background-size: cover;
    }
  </style>
</head>
<body>
<header class="site-header">
  <h1>⛑ First Aid Guides</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="index.php?page=pollution">Pollution</a>
    <a href="index.php?page=firstaid">First Aid</a>
  </nav>
</header>

<main class="section">
  <h2>Step-by-Step Emergency Instructions</h2>
  <div class="grid guides-grid" id="firstAidGuides">
    <?php foreach ($guides as $g): ?>
      <div class="card">
        <h3><?= $g['title']; ?></h3>
        <p><?= $g['desc']; ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<footer class="site-footer">
  <p>© <?= date('Y'); ?> SmartAid Project</p>
</footer>

<script src="assets/js/firstaid.js"></script>
</body>
</html>
