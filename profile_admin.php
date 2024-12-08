<?php

session_start();
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin") {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen">
        <?php include_once("./components/sidebar.php"); ?>
        <div class="flex-1 flex flex-col max-w-full overflow-y-auto">
            <header class="flex items-center justify-between bg-white p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="relative ml-4 lg:ml-0 hidden lg:block">
                        <input class="bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none" placeholder="Search" type="text" />
                        <i class="fas fa-search absolute left-3 top-2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php
                    require_once("./database/config.php");
                    $stmt = $conn->prepare("select name from admins where admin_id = ?");
                    $stmt->bind_param("i", $_SESSION["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<p class= 'font-bold'> <span class='text-red-500'>! hello  </span>"  .  htmlspecialchars($row["name"]) . "</p>";
                    }
                    ?>
                    <img alt="User" class="h-10 w-10 rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/T9QXi4dVAwZFPd3BeMxudVe5pfHROMRtVeyJyCO0uBWDySTPB.jpg" width="40" />
                </div>
            </header>
            <h1 class="text-2xl font-bold mb-4 mx-5">User Profile</h1>
            <div class="bg-white shadow-md rounded-lg p-6 mb-6  mx-5">
                <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                <?php
                require_once("./database/config.php");
                $stmt = $conn->prepare("SELECT * FROM admins where admin_id = ?");
                $stmt->bind_param("i", $_SESSION["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                }
                ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-gray-900"><?= htmlspecialchars($row["name"]) ?></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Sex</label>
                    <p class="mt-1 text-gray-900"><?= htmlspecialchars($row["sex"]) ?></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <p class="mt-1 text-gray-900"><?= htmlspecialchars($row["mobile_number"]) ?></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-gray-900"><?= htmlspecialchars($row["email"]) ?></p>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 border-t-5 border-indigo-500  mx-5">
                <h2 class="text-xl font-semibold mb-10">Change Password</h2>
                <form id="changePassForm">
                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Enter your current password" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Enter your new password" required>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Confirm your new password" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Change Password</button>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/changePass.js"></script>
</body>

</html>