<?php
session_start();
require_once("../database/config.php");


if (!isset($_POST['submit'])) {
    header('Location: /im/actions/addon/hecker.php'); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    function sanitizerString($data){
        $data = filter_var($data , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }
    
    $userType = sanitizerString($_POST["userType"]);
    $email = sanitizerString($_POST['email']);
    $password = sanitizerString($_POST['password']);

    if (empty($email) || empty($password) || empty($userType)) {
        echo json_encode(['success' => false, 'message' => 'Usertype, Email and password are required.']);
        exit;
    }
    if($userType == "borrower"){
        $stmt = $conn->prepare("SELECT * FROM borrowers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION["userType"] = "borrower";
                $_SESSION["id"] = $user["borrower_id"];
                echo json_encode(['success' => true, 'message' => 'Login successful!', 'location' => "userPage.php"]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
    }
    else if($userType == "admin"){
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION["userType"] = "admin";
                $_SESSION["id"] = $user["admin_id"];
                echo json_encode(['success' => true, 'message' => 'Login successful!', 'location' => "dashboard.php"]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>