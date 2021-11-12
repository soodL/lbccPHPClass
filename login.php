<?php
                    $servername = 'localhost';
                    $dbUserName = 'tetratimeuser';
                    $dbPassword = 'tetra@45930&~+)$!';
                    $dbName = 'tetratimesheet';
                    $port = 3306;

                    try {
                    $dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbName", $dbUserName, $dbPassword);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
                    
                    }
                    catch(PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
?>                    