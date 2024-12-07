<?php

    $localhost = "localhost";
    $username = "root";
    $password = "";
    $database = "utang_system";

    $conn = new mysqli($localhost, $username, $password, $database);

    if($conn -> connect_error){
        $res = [
            "success" => false,
            "message" => "could not connect to the server"
        ];
        echo json_encode($res);
        die("connection failed: " . $conn -> connect_error);
    }
?>