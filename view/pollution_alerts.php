<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real-time Pollution Alerts</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="assets/img/pollution.jpg"">
</head>
<body style="background: #3e8495ff; font-family: Arial, sans-serif; text-align: center; padding: 20px;">
    <header style="background: #93acc4ff;
            padding: 15px 20px;
            color: #fff;">
    <nav style="display: flex;
            justify-content: space-between;
            align-items: center;">
       
        <div class="links">
            <a href="../index.php">Home</a>
            <a href="../index.php?action=list">Guides</a>
            <a href="pollution_alerts.php">Pollution Alerts</a>
            <a href="../index.php?action=logout">Logout</a>
        </div>
    </nav>
</header>
    
    <h1>Real-time Air Quality & Pollution Notifications</h1>
    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <div style="display:flex; justify-content:center; gap:30px;">
        <form action="../controller/alertController.php" method="POST" style="background:#fff; padding:20px; border-radius:8px; width:350px;">
            <h3>Subscribe for notifications</h3>
            <input type="text" name="name" placeholder="Your name" required><br><br>
            <input type="email" name="email" placeholder="Your email" required><br><br>
            <input type="text" name="location" placeholder="Location name (e.g. Dhaka)" required><br><br>
            <input type="text" name="lat" placeholder="Latitude (e.g. 23.8103)"><br><br>
            <input type="text" name="lon" placeholder="Longitude (e.g. 90.4125)"><br><br>
            <button type="submit">Subscribe</button>
        </form>

        <div style="background:#fff; padding:20px; border-radius:8px; width:500px; text-align:left;">
            <h3>Check Air Quality (Live)</h3>
            <label>Latitude: <input id="lat" type="text" value="23.8103"></label><br><br>
            <label>Longitude: <input id="lon" type="text" value="90.4125"></label><br><br>
            <button id="checkBtn">Check Now</button>
            <p id="aqText"></p>
            <h4>Recent Subscribers</h4>
            <div id="subs">
                <?php
                require_once __DIR__ . '/../model/PollutionModel.php';
                $m = new PollutionModel();
                $subs = $m->getAllSubscribers();
                if ($subs) {
                    echo '<ul>';
                    foreach ($subs as $s) {
                        echo '<li>' . htmlspecialchars($s['name']) . ' - ' . htmlspecialchars($s['location']) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No subscribers yet.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>