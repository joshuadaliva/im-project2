<?php

    $localhost = "localhost";
    $username = "root";
    $password = "";
    $database = "utang_system";

    $conn = new mysqli($localhost, $username, $password, $database);

    if($conn -> connect_error){
        die("connection failed: " . $conn -> connect_error);
    }
?>