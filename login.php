<?php
require_once __DIR__ . "/./includes/security.php"; 

app_secure_session_start();
if(isset($_SESSION["userType"])){
    if($_SESSION['userType'] == "admin"){
        header("location: /im/dashboard.php");
        exit;
    }
    if($_SESSION['userType'] == "borrower"){
        header("location: /im/userPage.php");
        exit;
}}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="/im/assets/vendor/tailwind/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/im/assets/vendor/sweetalert2/sweetalert2.min.css">
    <script src="/im/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <?= app_csrf_meta() ?>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Log In</h2>
        <form id="loginForm" method="post" action="actions/process_login.php">
            <?= app_csrf_field() ?>
            <div class="mb-4">
                <select id="userType" name="userType" required class="mt-1 block  border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2">
                    <option value="" disabled selected>Login as</option>
                    <option value="borrower">Borrower</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="example@example.com">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="********">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition duration-200">Log In</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">Sign up</a>
        </p>
    </div>

    <script src="js/login.js"></script>
</body>
</html>