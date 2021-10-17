<?php
                    $servername = 'localhost';
                    $dbUserName = 'root';
                    $dbPassword = '';
                    $dbName = 'publications';

                    try {
                    $dbh = new PDO("mysql:host=$servername;dbname=$dbName", $dbUserName, $dbPassword);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
                    
                    }
                    catch(PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
?>                    