<?php
    session_start();

    // if session is not active then redirect to register page
    if(!isset($_SESSION['user_id']))
    {
        header("Location: http://localhost/lessons/hw7sessions/addusers.php");
        exit();        
    }
    else
    {
        // session is active. Destroy the session
        $_SESSION = [];         // resets the session variable as a new array
        session_destroy();      // removes the data from the server
        setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
        
        // Redirect to the login page
        header("Location: http://esseldemo.com/hw7sessions/userlogin.php");
        exit();           
    }

    echo "<h1>Logged out!</h1>";
   

    // provide a logged out message
?>