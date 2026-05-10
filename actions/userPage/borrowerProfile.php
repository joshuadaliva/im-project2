<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "borrower") {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}
require_once("../../database/config.php");
$stmt = $conn->prepare("SELECT * from borrowers WHERE borrower_id = ?");
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="/im/assets/vendor/tailwind/tailwind.min.css" rel="stylesheet" integrity="sha384-KYShmLEIZs+qOi0nCAm6yhRbw60FgzK5kO/yq+OMVgeZypzmbbay/6xVPL1zPAI8" crossorigin="anonymous">
    <link rel="stylesheet" href="/im/assets/vendor/sweetalert2/sweetalert2.min.css" integrity="sha384-cQA7jQW0oV3hKneBnT6kkgyUQwoJqnbcWrT9icUYLRxjk7NtMLQtOPTlg6guduzp" crossorigin="anonymous">
    <script src="/im/assets/vendor/sweetalert2/sweetalert2.all.min.js" integrity="sha384-njiiBwCC1FddZoJQbCnY5uMLD7vLzIROj07SExr1uej6zI48JF6lFZoTRSIg1ckA" crossorigin="anonymous"></script>
    <?= app_csrf_meta() ?>
</head>

<body class="bg-gray-100">
    <?php include("../../components/sidebar_borrower.php"); ?>
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <button id="open-sidebar" class="text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <h1 class="font-bold"> <span class="font-bold text-red-500">  hi! </span><?= htmlspecialchars($row["name"]) ?> </h1>
    </header>
    <div class="max-w-3/4 mx-2 p-6 bg-white rounded-lg shadow-md mt-10 mb-10 ">
        <h1 class="text-2xl font-bold mb-6">User Profile</h1>

        <div class="mb-4">
            <label class="block text-gray-700">Name:</label>
            <p class="text-gray-900"><?= htmlspecialchars($row["name"]) ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Sex:</label>
            <p class="text-gray-900"><?= htmlspecialchars($row["sex"]) ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Mobile Number:</label>
            <p class="text-gray-900"><?= htmlspecialchars($row["mobile_number"]) ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email:</label>
            <p class="text-gray-900"><?= htmlspecialchars($row["email"]) ?></p>
        </div>

        <h2 class="text-xl font-bold mt-8 mb-4">Change Password</h2>
        <form id="changePassForm">
            <?= app_csrf_field() ?>
            <div class="mb-4">
                <label class="block text-gray-700" for="current-password">Current Password:</label>
                <input type="password" id="current-password" name="current_password" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new_password" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="confirm-password">Confirm New Password:</label>
                <input type="password" id="confirm-password" name="confirm_password" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Change Password</button>
        </form>
    </div>
    <script src="/im/js/changePassBorrower.js" integrity="sha384-6s84YM+om49BD33A+NDMmyLSgxK8qmIKkzurhCxi+Co8g1aoz2EkFitOXZCASlcH" crossorigin="anonymous"></script>
</body>

</html>