<?php

if (isset($_SESSION)) {
    session_start();
    if ($_SESSION["userType"] != "admin") {
        header("Location: /im/actions/addon/hecker.php");
    }
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
    <style>
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <?php include_once("./components/sidebar.php"); ?>
        <div class="flex-1 flex flex-col max-w-full">
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
            </header>
            <div class="flex-1 p-4 sm:p-8">
                <h1 class="text-2xl font-bold mb-4">Sidebar background</h1>
                <div class="flex space-x-4">
                    <button id="red" class="bg-red-500 text-white p-2 rounded">Red</button>
                    <button id="green" class="bg-green-500 text-white p-2 rounded">Green</button>
                    <button id="blue" class="bg-blue-500 text-white p-2 rounded">Blue</button>
                    <button id="dark" class="bg-gray-500 text-white p-2 rounded">dark</button>
                </div>
            </div>
        </div>

        <script>
            const changeSidebarColor = (colorClass) => {
                const sidebars = document.querySelectorAll(".sidebar");
                localStorage.setItem("sidebarColor", colorClass)
                sidebars.forEach(sidebar => {
                    sidebar.classList.remove("bg-red-500", "bg-green-800", "bg-indigo-500", "bg-gray-700");
                    sidebar.classList.add(colorClass);
                });
            }
            document.getElementById('red').addEventListener('click', () => {
                changeSidebarColor("bg-red-500");
            });

            document.getElementById('green').addEventListener('click', () => {
                changeSidebarColor("bg-green-800");
            });

            document.getElementById('blue').addEventListener('click', () => {
                changeSidebarColor("bg-indigo-500");
            });

            document.getElementById('dark').addEventListener('click', () => {
                changeSidebarColor("bg-gray-700");
            });
        </script>
</body>

</html>