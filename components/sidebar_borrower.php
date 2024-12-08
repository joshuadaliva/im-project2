<?php
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "borrower") {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sidebar</title>
</head>

<body>

    <div id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out bg-white shadow-lg w-64 z-50">
        <div class="flex items-center justify-between p-4">
            <div class="text-lg font-bold text-blue-600">Utang system</div>
            <button id="close-sidebar" class="text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="mt-4">
            <a href="/im/userPage.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Home</a>
            <a href="/im/actions/userPage/borrowerProfile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
            <a href="/im/actions/userPage/borrower_Loans.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Loans</a>
            <a href="/im/actions/userPage/logoutUser.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</a>
        </nav>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-40"></div>
</body>

</html>