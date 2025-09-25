<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }


    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $user = $this->userModel->findById($_SESSION['user_id']);
        require '../views/profile/edit.php';
    }

 
    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        
        $error = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_SESSION['user_id'];
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $location = trim($_POST['location']);

            if ($this->userModel->updateProfile($id, $username, $email, $phone, $location)) {
                
                $_SESSION['username'] = $username;
                $success = "Profile updated successfully!";
            } else {
                $error = "Something went wrong. Could not update profile.";
            }
        }
        
        $user = $this->userModel->findById($_SESSION['user_id']);
        require '../views/profile/edit.php';
    }
}