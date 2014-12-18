<?php
    $server= 'localhost';
    $dbname= 'achieved_wor0741';
    $dsn = 'mysql:host='.$server.';dbname='.$dbname;
    
      
    
    //$username = 'mgs_user';
    //$password = 'pa55word';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
    
?>
