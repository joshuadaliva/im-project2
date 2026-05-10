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
    <title>Signup Page</title>
    <link href="/im/assets/vendor/tailwind/tailwind.min.css" rel="stylesheet" integrity="sha384-KYShmLEIZs+qOi0nCAm6yhRbw60FgzK5kO/yq+OMVgeZypzmbbay/6xVPL1zPAI8" crossorigin="anonymous">
    <script src="/im/assets/vendor/sweetalert2/sweetalert2.all.min.js" integrity="sha384-njiiBwCC1FddZoJQbCnY5uMLD7vLzIROj07SExr1uej6zI48JF6lFZoTRSIg1ckA" crossorigin="anonymous"></script>
    <?= app_csrf_meta() ?>
</head>
<body class="bg-gray-800 w-full flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>
        <form id="signupForm" method="post" action="actions/process_signup.php">
            <?= app_csrf_field() ?>
            <div class="mb-4 flex space-x-4">
                <div class="flex-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="John Doe">
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2">
                        <option value="" disabled selected>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="mb-4 flex space-between space-x-4">
                <div>
                    <label for="mobile_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <input type="text" id="mobile_number" name="mobile_number" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="123-456-7890">
                </div>
                <div>
                    <label for="userType" class="block text-sm font-medium text-gray-700">User  Type</label>
                    <select id="userType" name="userType" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2">
                        <option value="" disabled selected>Select user type</option>
                        <option value="borrower">Borrower</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="example@example.com">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 p-2" placeholder="********">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition duration-200">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Log in</a>
        </p>
        <div id="message" class="mt-4 text-center"></div>
    </div>

    <script src="./js/signup.js"></script>
 </body>
</html>