<?php
session_start();
include "header.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{
    //echo "<p>We are inside the server Request</p>";
    // make all the input textboxes be full
    $errors = [];

    if (empty($_POST['email_address']))
    {
        $errors[] = "Forgot email address";
    }
    else
    {
        $email_address      = htmlspecialchars(trim($_POST['email_address']));
    }

    if (empty($_POST['age']) || !is_numeric($_POST['age']))
    {
        $errors[] = "Messup with age";
    }
    else
    {
        $users_age      = htmlspecialchars(trim($_POST['age']));
    }

    if (empty($_POST['gender']))
    {
        $errors[] = "Forgot gender";
    }
    else
    {
        $gender      = htmlspecialchars(trim($_POST['gender']));
    }

    if (empty($_POST['address']))
    {
        $errors[] = "Forgot address";
    }
    else
    {
        $user_address      = htmlspecialchars(trim($_POST['address']));
    }

    if (empty($_POST['city']))
    {
        $errors[] = "Forgot city";
    }
    else
    {
        $city      = htmlspecialchars(trim($_POST['city']));
    }

    if (empty($_POST['state']))
    {
        $errors[] = "Forgot the state";
    }
    else
    {
        $state      = htmlspecialchars(trim($_POST['state']));
    }

    if (empty($_POST['password']))
    {
        $errors[] = "Forgot address";
    }
    else
    {
        $password      = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);
    }

    $activity_state = 'a';
    

    // if there were no issues, then push to database
    if(empty($errors))
    {
//        echo "<p>Did not have any errors found in textboxes</p>";
        require_once 'login.php';
//        require_once 'loginLocalHost.php';

        // check if email already exists
        try {
            $stmt = $dbh->prepare("SELECT * FROM users_table where email_address=?");
            $stmt->bindParam(1, $email_address);
            $stmt->execute();
        } catch(Exception $e){
            echo $e->getMessage();
            die();
        }
        // echo "<p>Email search row count: {$stmt->rowCount()}</p>"; 
 
        if($stmt->rowCount())
        {
            // rowcount returns a positive number.
            echo "<p>Sorry! That email already exists.</p>";
        }
        else
        {
            //echo "<p>No such email address found, prepare statements.</p>";
            // We can enter the file upload code here


            // Check for an uploaded file:
            if (isset($_FILES['upload'])) {

                // Validate the type. Should be JPEG or PNG.
                $allowed = ['image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png'];
                if (in_array($_FILES['upload']['type'], $allowed)) {
                    // rename filename
                    $file_name = $email_address . $_FILES['upload']['name'];
                    // Move the file over.
                    if (move_uploaded_file ($_FILES['upload']['tmp_name'], "uploads/$file_name")) {    
                        echo '<p><em>The file has been uploaded!</em></p>';                        
                    } // End of move... IF.
        
                } else { // Invalid type.
                    echo '<p class="error">Please upload a JPEG or PNG image.</p>';
                }
    
            } // End of isset($_FILES['upload']) IF.
	    
        // Check for an error:
        if ($_FILES['upload']['error'] > 0) {
            echo '<p class="error">The file could not be uploaded because: <strong>';
    
            // Print a message based upon the error.
            switch ($_FILES['upload']['error']) {
                case 1:
                    print 'The file exceeds the upload_max_filesize setting in php.ini.';
                    break;
                case 2:
                    print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                    break;
                case 3:
                    print 'The file was only partially uploaded.';
                    break;
                case 4:
                    print 'No file was uploaded.';
                    break;
                case 6:
                    print 'No temporary folder was available.';
                    break;
                case 7:
                    print 'Unable to write to the disk.';
                    break;
                case 8:
                    print 'File upload stopped.';
                    break;
                default:
                    print 'A system error occurred.';
                    break;
            } // End of switch.
    
            print '</strong></p>';
    
        } // End of error IF.        

	    // Delete the file if it still exists:
        if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
            unlink ($_FILES['upload']['tmp_name']);
        }


        try {    
            // did not find an email match, safe to enter data
            $stmt = $dbh->prepare('INSERT INTO users_table VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
    
            $stmt->bindParam(2, $user_name, PDO::PARAM_STR, 32);
            $stmt->bindParam(3, $email_address, PDO::PARAM_STR, 32);
            $stmt->bindParam(4, $users_age, PDO::PARAM_INT, 32);
            $stmt->bindParam(5, $gender, PDO::PARAM_STR, 32);
            $stmt->bindParam(6, $user_address, PDO::PARAM_STR, 32);
            $stmt->bindParam(7, $city, PDO::PARAM_STR, 32);
            $stmt->bindParam(8, $state, PDO::PARAM_STR, 32);
            $stmt->bindParam(9, $password, PDO::PARAM_STR, 255);
            $stmt->bindParam(10, $activity_state, PDO::PARAM_STR, 32);     
            $stmt->bindParam(11, $file_name, PDO::PARAM_STR, 32);   
            echo "<p>Finished binding parameters</p>";
            $stmt->execute(
                [
                    null, 
                    'my_name', 
                    $email_address,
                    $users_age,
                    $gender,
                    $user_address,
                    $city,
                    $state,
                    $password,
                    $activity_state,
                    $file_name,
                    null
                ]); 
        } catch(exception $e)
        {
            echo $e->getMessage();
            die();
        }
    
            printf("%d Row inserted.\n", $stmt->rowCount());

            // clear the posted values
            $_POST = [];

            // send the email
            echo "<p>We will send email</p>";

            sendmail($email_address, $user_name);             
            
        }
        
    }
    
}// end of server post check

?>

<h1>Register</h1>
<form action="addusers.php" method="post" enctype="multipart/form-data">
    

    <p>Email address: <input type="email" name="email_address" size="30" maxlength="40" required value="<?php if(isset($_POST['email_address'])) echo htmlspecialchars($_POST['email_address']); ?>"></p>

    <p>Age: <input type="number" name="age" min="1" max="120" required value="<?php if(isset($_POST['age'])) echo htmlspecialchars($_POST['age']); ?>">

    Gender: <input type="text" name="gender" size="15" maxlength="20" value="<?php if(isset($_POST['gender'])) echo htmlspecialchars($_POST['gender']); ?>"></p>

    <p>Address: <input type="text" name="address" size="40" maxlength="50" required value="<?php if(isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?>"></p>

    <p>City: <input type="text" name="city" size="15" maxlength="20" required value="<?php if(isset($_POST['city'])) echo htmlspecialchars($_POST['city']); ?>">

    State: <input type="text" name="state" size="15" maxlength="20" required value="<?php if(isset($_POST['state'])) echo htmlspecialchars($_POST['state']); ?>"></p>

    <p>Password: <input type="password" name="password" size="15" maxlength="20" required value="<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>"></p>

    <input type="hidden" name="MAX_FILE_SIZE" value="750000">
    <p><strong>Image:</strong> <input type="file" name="upload"></p>

    <p><input type="submit" value="Register"></p>

</form>

<?php
function sendmail($email_address, $user_name)
{
    /*
        Function purpose:
            Send email to
                registered email address
                Send their user name

    */ 
    echo "<p>Inside function for send mail</p>";



    
            // Create the body:
            $body = "Thank you for signing up for our daily newsletter covering all the latest news about music, dentistry and dance. Please sign in at your convenience.";
    
            // Make it no longer than 70 characters long:
            $body = wordwrap($body, 70);
    
            // Send the email:
 // so we dont keep sending emails all night           
 mail($email_address, 'Sign up congratulations', $body, "From: soodtest@esseldemo.com");
    
            // Print a message:
            echo '<p><em>Ok, we have sent the message.</em></p>';
    

}
?>