<?php

class PageController
{
    
    public function landing()
    {
        require '../views/home.php';
    }

    
    public function home()
    {
       
        if (!isset($_SESSION["user_id"])) {
            header("Location: index.php?action=login");
            exit();
        }
   
        require '../views/homepage.php';
    }

     public function showAboutUsPage()
    {
        require '../views/about_us.php';
    }
}