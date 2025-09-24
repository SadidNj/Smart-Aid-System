<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/model/EmergencyModel.php';

class EmergencyController {
    public function handle(): array {
        ensure_csrf();
        $m = new EmergencyModel();
        $division = '';
        $error = '';
        $results = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $division = trim($_POST['division'] ?? '');
            if ($division === '') {
                $error = 'Please select a division.';
            } else {
                $results = $m->findByDivision($division);
            }
        }
        return compact('division','error','results');
    }
}
