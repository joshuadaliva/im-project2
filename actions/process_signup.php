<?php
session_start();
require_once("../database/config.php");

if (!isset($_POST['submit'])) {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function sanitizerString($data) {
        $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }

    $name = sanitizerString($_POST['name']);
    $gender = sanitizerString($_POST['gender']);
    $mobile_number = sanitizerString($_POST['mobile_number']);
    $userType = sanitizerString($_POST['userType']);
    $email = sanitizerString($_POST['email']);
    $password = sanitizerString($_POST['password']);

    function isValidPassword($password) {
        if (strlen($password) < 8) {
            return false;
        }
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }
        return true;
    }

    if (!isValidPassword($password)) {
        header('Content-Type: application/json');
        $res = [
            "success" => false,
            "message" => "Password must be at least 8 characters long, contain at least one lowercase letter, one uppercase letter, and one symbol"
        ];
        echo json_encode($res);
        exit; 
    }

    if ($userType == "borrower") {
        require("./process_signup_borrower.php");
    } else if ($userType == "admin") {
        require("./process_signup_admin.php");
    } else {
        header('Content-Type: application/json');
        $res = [
            "success" => false,
            "message" => "Invalid user type"
        ];
        echo json_encode($res);
        exit;
    }
}