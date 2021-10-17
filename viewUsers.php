<?php include('header.php') ?>
    <body>  
        <h2>Users table</h2>
        <table>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email address</th>
            </tr>
<?php
            require_once("login.php");
                    // Query database to read results
                    $query = "SELECT * FROM users ORDER BY first_name";
                    $result = $dbh->query($query);

                    foreach ($result as $row)
                    {
                        print "<tr>";
                        print "<td>{$row['first_name']}</td>";                        
                        print "<td>{$row['last_name']}</td>";
                        print "<td>{$row['email_address']}</td>";
                        print "</tr>";
                    }            
?>            
        </table>
    </body>
</html>