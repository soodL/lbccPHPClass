<?php include('header.php')?>
    <body>
        <form action="submituser.php" method="post">
            <div>
                <label for="fname" class="title">First Name:</label>
                <input type="text" name="fname" />
            </div>
            <div>
                <label for="lname" class="title">Last Name:</label>
                <input type="text" name="lname" /> 
            </div>                
            <div>               
                <label for="email" class="title">Email Address:</label>
                <input type="text" name="email" />
            </div>                
            <div>               
                <label for="pass1" class="title">Password:</label>
                <input type="text" name="pass1" />
            </div>                
            <div>               
                <label for="pass2" class="title">Confirm Password:</label>
                <input type="text" name="pass2" />                
            </div>
            <div class="submit">
                <input type="submit" value="Register">
            </div>
        </form>
    </body>
</html>