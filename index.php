<?php
session_start();

// Demo session + cookie (remember-me style)
if (!isset($_SESSION['user'])) {
    if (!empty($_COOKIE['user'])) {
        $_SESSION['user'] = $_COOKIE['user'];
    } else {
        $_SESSION['user'] = 'demoUser';
        setcookie('user', 'demoUser', time() + 86400 * 7, '/');
    }
}

// কোন module দেখাবো সেটা নেব
$module = $_GET['module'] ?? 'firstaid';

// ---------------- FIRST AID ----------------
if ($module === 'firstaid') {
    require_once __DIR__ . '/controller/GuideController.php';
    $controller = new GuideController();

    $action = $_GET['action'] ?? 'list';

    switch ($action) {
        case 'search':
            $q = $_GET['q'] ?? '';
            $controller->searchGuides($q);
            break;
        case 'detail':
            $id = (int)($_GET['id'] ?? 0);
            $ajax = isset($_GET['ajax']) ? (int)$_GET['ajax'] : 0;
            $controller->showGuide($id, $ajax);
            break;
        case 'logout':
            session_unset();
            session_destroy();
            setcookie('user','', time()-3600, '/');
            header('Location: index.php');
            exit;
        case 'list':
        default:
            $controller->listGuides();
            break;
    }
}

// ---------------- POLLUTION ALERT ----------------
elseif ($module === 'pollution') {
    require_once __DIR__ . '/view/pollution_alerts.php';
}

// ---------------- DEFAULT ----------------
else {
    echo "<h2>Invalid module selected!</h2>";
    echo '<a href="index.php?module=firstaid">Go to First Aid</a> | ';
    echo '<a href="index.php?module=pollution">Go to Pollution Alerts</a>';
}
?>
