<?php
session_start();

require_once '../config.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/PageController.php';

$action = $_GET['action'] ?? 'landing'; 

$authController = new AuthController($pdo);
$pageController = new PageController();

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'signup':
        $authController->signup();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'forgot_password':
        $authController->forgotPassword();
        break;
    case 'reset_password':
        $authController->resetPassword();
        break;
     case 'guest_login':
        $authController->guestLogin();
        break;
    case 'home': 
        $pageController->home();
        break;
    case 'landing': 
    default:
        $pageController->landing();
        break;
    case 'about_us':
        $pageController->showAboutUsPage();
        break;

}