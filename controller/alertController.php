<?php
require_once __DIR__ . '/../model/PollutionModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $location = $_POST['location'] ?? '';
    $lat = isset($_POST['lat']) ? floatval($_POST['lat']) : 0;
    $lon = isset($_POST['lon']) ? floatval($_POST['lon']) : 0;

    $model = new PollutionModel();
    if (!empty($name) && !empty($email) && !empty($location)) {
        if ($model->insertSubscriber($name, $email, $location, $lat, $lon)) {
            $msg = '✅ Subscribed successfully!';
        } else {
            $msg = '❌ Failed to subscribe.';
        }
    } else {
        $msg = '⚠️ Please fill all fields.';
    }
    header('Location: ../view/pollution_alerts.php?msg=' . urlencode($msg));
    exit();
}
?>