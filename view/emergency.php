<?php
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/controller/EmergencyController.php';
$ctrl = new EmergencyController();
extract($ctrl->handle());
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nearby Emergency Help</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="../assets/css/Emergency.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="request.php">Go to Request Board</a>
    <a href="reminder.php">Go to Medicine Reminder</a>
  </div>

  <div class="panel">
    <h2>🚨 Nearby Emergency Help</h2>
    <?php if(!empty($error)) echo "<div class='message'>".h($error)."</div>"; ?>
    <form method="POST" action="emergency.php">
      <label for="division">Select Division:</label>
      <select id="division" name="division" required>
        <option value="">-- Select Division --</option>
        <?php foreach(['Dhaka','Chattogram','Khulna','Rajshahi','Sylhet','Barishal','Rangpur','Mymensingh'] as $opt): ?>
          <option value="<?= h($opt) ?>" <?= (!empty($division) && $division===$opt?'selected':'') ?>><?= h($opt) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="submit">🔍 Find Help</button>
    </form>

    <div id="results">
      <?php if (!empty($results)): ?>
        <ul>
          <?php foreach ($results as $row): ?>
            <li>
              <strong><?= h($row['name']) ?></strong>
              — <?= number_format((float)$row['distance_km'], 1) ?> km,
              <?= h($row['address']) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php elseif ($_SERVER['REQUEST_METHOD']==='POST' && empty($error)): ?>
        <p>No hospitals found in <b><?= h($division) ?></b>.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
