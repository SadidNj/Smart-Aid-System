<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }
    public function guestLogin()
{
    
    $_SESSION["user_id"] = 0; 
    $_SESSION["username"] = "Guest";
    $_SESSION["role"] = "guest";

    
    header("Location: index.php?action=home");
    exit();
}
    public function login()
    {
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
            $remember = isset($_POST["remember"]);

            $user = $this->userModel->findByUsernameOrEmail($username);

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION['role'] = $user['role']; // Role added to session

                if ($remember) {
                    setcookie("user_id", $user["id"], time() + (86400 * 30), "/");
                    setcookie("username", $user["username"], time() + (86400 * 30), "/");
                }
                header("Location: index.php?action=home"); // Redirect to new homepage
                exit();
            } else {
                $error = "Invalid credentials!";
            }
        }
        require '../views/auth/login.php';
    }

    public function signup()
    {
        $error = "";
        $success = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            
            if ($this->userModel->findByUsernameOrEmail($username)) {
                $error = "Username or Email already exists!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                if ($this->userModel->create($username, $email, $hashedPassword)) {
                    $success = "Registration successful! <a href='index.php?action=login'>Login now</a>";
                } else {
                    $error = "Something went wrong!";
                }
            }
        }
        require '../views/auth/signup.php';
    }
    
    public function logout()
    {
        session_destroy();
        setcookie("user_id", "", time() - 3600, "/");
        setcookie("username", "", time() - 3600, "/");
        header("Location: index.php?action=login");
        exit();
    }
    
    public function forgotPassword()
    {
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["email"]);
            if ($this->userModel->findByEmail($email)) {
                $_SESSION["reset_email"] = $email;
                header("Location: index.php?action=reset_password");
                exit();
            } else {
                $error = "No account found with this email.";
            }
        }
        require '../views/auth/forgot_password.php';
    }

    public function resetPassword()
    {
        if (!isset($_SESSION["reset_email"])) {
            header("Location: index.php?action=forgot_password");
            exit();
        }
        $error = "";
        $success = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = trim($_POST["password"]);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->userModel->updatePassword($_SESSION["reset_email"], $hashedPassword)) {
                $success = "Password reset successful! <a href='index.php?action=login'>Login now</a>";
                unset($_SESSION["reset_email"]);
            } else {
                $error = "Failed to reset password.";
            }
        }
        require '../views/auth/reset_password.php';
    }
}