<?php
include "header.php";

// check if password is matching
// run sql query for known person
// try to compare password to find a match
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // store the errors in this array
//    echo "<br>1 inside server request method";
    $errors = [];

    if (empty($_POST['email_address']))
    {
        $errors[] = "Forgot email address";
    }
    else
    {
        $email_address      = htmlspecialchars(trim($_POST['email_address']));
//        echo "<br>2 got the email";
    }

    if (empty($_POST['loginPass']))
    {
        $errors[] = "Missing password!";
    }
    else
    {
        $login_password      = htmlspecialchars(trim($_POST['loginPass']));
//        echo "<br>3 got the password";
    }

    if (empty($errors))
    {
        require_once 'login.php';
        $stmt = $dbh->prepare("SELECT user_id, password 
        FROM users_table 
        WHERE email_address = ?");
        
        $stmt->bindParam(1, $email_address, PDO::PARAM_STR, 32);

//        echo "<br>4 created prepare statement";
        
        $stmt->execute();
        
        if($stmt->rowCount() == 1)
        {
            // rowcount returns a positive number.
            
            $row = $stmt->fetch();
            
            if(password_verify($login_password, $row['password']))
            {
                // we have a confirmed match
                echo "<p>We found a match!";
                echo "<br> User id: " . $row['user_id'] . "<br>";
                unset($row['password']);
                $_POST = [];

                // ***********************************
                //          Start a session
                // *********************************** 
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                // Redirect to a logged in page with header
                header("Location: http://esseldemo.com/hw7sessions/viewusers.php");
                exit();                 
            }
            else
            {
                echo "Password did not match";
            }
    
        }
        else
        {
            echo "No match found!";
        }
    }

}
echo '<form action="userlogin.php" method="post">
Email address: <input type="email" name="email_address" placeholder="Email address" size="30" required><br>
Password: <input type="password" name="loginPass" placeholder="Password"size="30" required><br>
<br><input type="submit" value="Submit">
</form>
';
?>
