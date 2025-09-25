<?php if (!isset($guide) || !$guide): ?>
<div class="guide-detail"><p>Guide not found.</p></div>
<?php else: ?>
<div class="guide-detail">
  <a href="../index.php?action=list" class="back-to-list">⬅ Back to Guides</a>



  <h2><?= htmlspecialchars($guide['title']) ?></h2>

  <h3>Steps</h3>
  <ol>
    <?php foreach ($guide['steps'] as $s): ?>
      <li><?= htmlspecialchars($s) ?></li>
    <?php endforeach; ?>
  </ol>

  <h3>Training</h3>
  <p><?= htmlspecialchars($guide['training'] ?? 'No training info available') ?></p>

  <?php if (!empty($guide['image_url'])): ?>
    <img src="<?= htmlspecialchars($guide['image_url']) ?>" style="max-width:400px;">
  <?php endif; ?>
</div>
<?php endif; ?>
