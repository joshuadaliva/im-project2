<?php

    session_start();
    if($_SESSION["userType"] != "borrower"){
        header("Location: ./actions/addon/hecker.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Utang Display with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-lg p-8 max-w-sm text-center transform transition-all hover:scale-105">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Current Utang</h1>
        <div class="text-3xl font-extrabold text-red-600">
            <?php
                require_once("./database/config.php");
                $stmt = $conn -> prepare("SELECT amount from Loans WHERE borrower_id = ?");
                $stmt -> bind_param("i", $_SESSION["id"]);
                $stmt -> execute();
                $result = $stmt -> get_result();

                if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                        echo  $row["amount"];
                    }
                }
                else{
                    echo 0;
                }

            ?>
        </div>
        <p class="text-gray-600 mt-4">This is your current outstanding balance.</p>
    </div>
    <a href="./actions//logout.php" class="bg-blue-900 p-4 text-white rounded-md">logout</a>

</body>
</html>