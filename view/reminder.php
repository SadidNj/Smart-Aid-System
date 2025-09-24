<?php
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/controller/ReminderController.php';
$ctrl = new ReminderController();
extract($ctrl->handle());
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Medicine Reminder</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../assets/css/Reminder.css">
  <script src="../assets/js/Reminder.js" defer></script>
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="request.php">Go to Request Board</a>
    <a href="emergency.php">Go to Emergency Help</a>
  </div>

  <div class="panel">
    <h2>💊 Set Medicine Reminder</h2>

    <?php if (!empty($success)) echo "<div class='message success'>".h($success)."</div>"; ?>
    <?php if (!empty($error)) echo "<div class='message error'>".h($error)."</div>"; ?>

    <form method="POST" action="reminder.php" onsubmit="return validateMedicineReminder()">
      <label for="medicine">Medicine Name:</label>
      <input type="text" id="medicine" name="medicine" placeholder="Name" required>

      <label for="time">Reminder Time:</label>
      <input type="time" id="time" name="time" required>

      <label for="notes">Notes:</label>
      <textarea id="notes" name="notes" placeholder="Optional notes..."></textarea>

      <input type="submit" value="💾 Set Reminder">
    </form>

    <?php if (!empty($reminders)) : ?>
      <h3 style="margin-top:30px;">📋 Your Reminders</h3>
      <table>
        <tr>
          <th>ID</th>
          <th>Medicine</th>
          <th>Time</th>
          <th>Notes</th>
        </tr>
        <?php foreach ($reminders as $rem): ?>
          <tr>
            <td><?= (int)$rem['id'] ?></td>
            <td><?= h($rem['medicine']) ?></td>
            <td><?= date("h:i A", strtotime($rem['time'])) ?></td>
            <td><?= h($rem['notes']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

      <form method="POST" action="reminder.php" style="margin-top:10px;">
        <input type="hidden" name="delete_all" value="1">
        <button type="submit" class="delete-btn">🗑 Delete All Reminders</button>
      </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
