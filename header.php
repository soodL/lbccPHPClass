<!doctype html>
<html>
    <head>
        <style type="text/css">
        body {
             font-family: Arial, Verdana, sans-serif;
             color: #111111;
        }        
        div {
            border-bottom: 1px solid #efefef;
            margin: 10px;
            padding-bottom: 10px;
            width: 600px;
        }
        .title {
            float: left;
            width: 200px;
            text-align: right;
            padding-right: 10px;
        }
        .submit {
            text-align:center;
        }
        #nav {
            background-color: #efefef;
            padding: 10px;
            margin: 10px;
        }
        li {
            display: inline;
            padding: 5px;
        }
        table {
                width: 600px;
            }
        th, td {
            padding: 7px 10px 10px 10px;
        }
        th {
                text-transform: uppercase;
                letter-spacing: 0.1em;
                font-size: 90%;
                border-bottom: 2px solid #111111;
                border-top: 1px solid #999;
                text-align: left;
        } 
        img.small {
            float: left;
            height: 50px;
        }
        </style>
        <div id="nav">
            <ul>
                <li><a href="addusers.php">Register</a></li>
 
                <?php // Will select login or logout
                    if(isset($_SESSION['user_id']))     
                    {
                        // session value is valid that means we are logged in
                        echo '<li><a href="viewusers.php">View users</a></li>';
                        echo '<li><a href="user_logout.php">Log out</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="userlogin.php">Login</a></li>';
                    }
                ?>       
                

            </ul>
        </div>
    </head>