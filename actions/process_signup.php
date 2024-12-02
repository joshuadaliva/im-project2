<?php
session_start(); 
require_once("../database/config.php");

if (!isset($_POST['submit'])) {
    header('Location: addon/hecker.php'); 
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $userType = trim($_POST['userType']);

    if (!empty($name) && !empty($email) && !empty($password) && !empty($userType)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $userType);

        if ($stmt->execute()) {
            $res = [
                'success' => true,
                'message' => "Signup successful! You can now log in."
            ];
            echo json_encode($res);
        } else {
            if ($stmt->errno === 1062) { 
                $res = [
                    'success' => false,
                    'message' => "This email address is already registered. Please use a different email."
                    ];
                }
                else{
                    $res = [
                    'success' => false,
                    'message' => "An error occured."
                    ];
                }
                echo json_encode($res);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => "Please fill all fields."]);
    }
}
?>