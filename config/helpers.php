<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

function h(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function ensure_csrf(): void {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
}

function csrf_valid(string $token): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function flash(string $key, ?string $val=null): ?string {
    if ($val !== null) { $_SESSION["flash_$key"] = $val; return null; }
    if (isset($_SESSION["flash_$key"])) {
        $m = $_SESSION["flash_$key"]; unset($_SESSION["flash_$key"]); return $m;
    }
    return null;
}
