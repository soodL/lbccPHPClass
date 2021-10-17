<?php include('header.php')?>
    <body>
        <?php
            if(!empty($_POST['fname'])&& !empty($_POST['lname'])&& !empty($_POST['email']) && !empty($_POST['pass1'])&& !empty($_POST['pass2']))
            {
                // setting up and connecting the database
                // database called: dbh
                require_once('login.php');

                $fname = htmlspecialchars($_POST['fname']);
                $lname = htmlspecialchars($_POST['lname']);
                $email = htmlspecialchars($_POST['email']);
                $pass1 = trim(htmlspecialchars($_POST['pass1']));
                $pass2 = trim(htmlspecialchars($_POST['pass2']));

                if($pass1 === $pass2)
                {
                    echo "Successful Login!<br>";
                    
                    // Insert values into a database
                    // Attempting the way the book has it. Longer but more secure!

                    $stmt = $dbh->prepare('INSERT INTO users VALUES (?,?,?,?)');
                    $stmt->bindParam(1, $fname, PDO::PARAM_STR, 128);
                    $stmt->bindParam(2, $lname, PDO::PARAM_STR, 128);
                    $stmt->bindParam(3, $email, PDO::PARAM_STR, 128);
                    $stmt->bindParam(4, $pass1, PDO::PARAM_STR, 128);

                    $stmt->execute([$fname, $lname, $email, $pass1]);
                    printf("%d Row inserted.\n", $stmt->rowCount());
                }
                else
                {
                    echo "you filled out all the boxes<br>";
                    echo "but your passwords did not match!";
                }

            }
            else
            {
                echo "did you leave something blank?";
            }
        ?>
    </body>
</html>