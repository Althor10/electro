<?php
require_once "config.php";

try {
    $conn = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DBNAME."", MYSQL_USERNAME, MYSQL_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    
   // echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

function executeQuery($upit){
    global $conn;

    $rezultat = $conn->query($upit)->fetchAll();

    return $rezultat;
}
?>