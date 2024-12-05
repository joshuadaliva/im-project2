<?php
session_start(); 
require_once("../database/config.php");

if (!isset($_POST['submit'])) {
    header('Location: addon/hecker.php'); 
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $gender = trim($_POST['gender']);
    $mobile_number = trim($_POST['mobile_number']);
    $userType = trim($_POST['userType']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if($userType == "borrower"){
        require("./process_signup_borrower.php");
    }
    else if($userType == "admin"){
        require("./process_signup_admin.php");
    }
}
?>