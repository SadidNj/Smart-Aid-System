<?php
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/controller/RequestController.php';
$ctrl = new RequestController();
extract($ctrl->handle());
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Board</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../assets/css/Request.css">
  <script src="../assets/js/Request.js" defer></script>
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="emergency.php">Go to Emergency Help</a>
    <a href="reminder.php">Go to Medicine Reminder</a>
  </div>

  <div class="panel">
    <h1>Request Board</h1>
    <p class="lead">Choose <strong>Blood</strong> or <strong>Organ</strong>. </p>

    <?php if ($m=flash('success')): ?><div class="flash flash--ok"><?= h($m) ?></div><?php endif; ?>
    <?php if ($m=flash('error')): ?><div class="flash flash--err"><?= h($m) ?></div><?php endif; ?>

    <form method="post" action="request.php" onsubmit="return validateRequestForm()">
      <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
      <label for="type">Type</label>
      <select id="type" name="type" required onchange="onTypeChange()">
        <option value="">Select type</option>
        <option value="blood" <?= ($old['type']??'')==='blood'?'selected':''; ?>>Blood</option>
        <option value="organ" <?= ($old['type']??'')==='organ'?'selected':''; ?>>Organ</option>
      </select>

      <label for="name">Patient Name</label>
      <input id="name" name="name" maxlength="100" placeholder="Enter your name" value="<?= h($old['name']??'') ?>" required />

      <div id="bg-wrap" style="display:none;">
        <label for="blood_group">Blood Group</label>
        <select id="blood_group" name="blood_group">
          <option value="">Select blood group</option>
          <?php foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?>
            <option value="<?= h($bg) ?>" <?= (($old['blood_group']??'')===$bg?'selected':'') ?>><?= h($bg) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <label for="details">Details</label>
      <textarea id="details" name="details" maxlength="1000" placeholder="Hospital, location, contact, urgency..." required><?= h($old['details']??'') ?></textarea>

      <button type="submit">Post Request</button>
    </form>

    <div class="grid">
      <div class="card">
        <h3>My Requests</h3>
        <?php if ($my && $my->num_rows>0): while ($r=$my->fetch_assoc()): ?>
          <?php $title=h($r['type']); if ($r['type']==='blood' && !empty($r['blood_group'])) $title.=' '.h($r['blood_group']); ?>
          <div class="item">
            <strong><?= h($r['name']) ?></strong>
            <span class="badge"><?= $title ?></span><br>
            <?= nl2br(h($r['details'])) ?>
            <small><?= date("h:i A, d-m-Y", strtotime($r['created_at'])) ?></small>
          </div>
        <?php endwhile; $my->free(); else: ?>
          <p>No posts from this session.</p>
        <?php endif; ?>
      </div>

      <div class="card">
        <h3>Others’ Requests</h3>
        <?php if ($others && $others->num_rows>0): while ($r=$others->fetch_assoc()): ?>
          <?php $title=h($r['type']); if ($r['type']==='blood' && !empty($r['blood_group'])) $title.=' '.h($r['blood_group']); ?>
          <div class="item">
            <strong><?= h($r['name']) ?></strong>
            <span class="badge"><?= $title ?></span><br>
            <?= nl2br(h($r['details'])) ?>
            <small><?= date("h:i A, d-m-Y", strtotime($r['created_at'])) ?></small>
          </div>
        <?php endwhile; $others->free(); else: ?>
          <p>No requests found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
