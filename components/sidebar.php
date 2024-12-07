<?php
session_start();
if (isset($_SESSION["userType"])) {
    if ($_SESSION["userType"] != "admin") {
        header("Location: /im/actions/addon/hecker.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="sidebar" class="sidebar text-white w-64 flex flex-col  transition-transform duration-300 lg:translate-x-0 lg:static absolute sidebar-hidden min-h-screen">
        <div class="flex items-center justify-center h-20 relative">
            <span class="ml-2 mt-5 text-2xl font-bold">Pautang System</span>
            <button id="sidebarClose" class="text-gray-500 focus:outline-none lg:hidden absolute top-2 right-2">
                <i class="fas fa-bars text-white text-base m-2"></i>
            </button>
        </div>
        <div class="relative p-4 lg:hidden">
            <input class="bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none w-full" placeholder="Search" type="text" />
        </div>
        <nav class="flex-1 px-4 py-6">
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-gray-200 hover:text-white font-bold" href="/im/dashboard.php">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-gray-200 hover:text-white font-bold" href="/im/manage_borrowers.php">
                        <i class="fa fa-user mr-3"></i>
                        Manage Borrowers
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-gray-200 hover:text-white font-bold" href="/im/manage-loans.php">
                        <i class="fa fa-credit-card mr-3"></i>
                        Manage Loans
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-gray-200 hover:text-white font-bold" href="setting.php">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-gray-200 hover:text-white font-bold" href="#">
                        <i class="fa fa-user-circle mr-3"></i>
                        Profile
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="actions/logout.php" class="flex items-center text-gray-200 hover:text-white font-bold">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('sidebar-hidden');
            });
            document.getElementById('sidebarClose').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('sidebar-hidden');
            });

            const sidebar = document.getElementById("sidebar")
            const sidebarColor = localStorage.getItem("sidebarColor") || "bg-indigo-500"
            sidebar.classList.add(sidebarColor)
        });
    </script>
</body>

</html>