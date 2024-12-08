<?php
session_start();
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
    <title>Current Utang Display with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-500 flex items-center">
    <?php include_once("./components/sidebar_borrower.php"); ?>
    <div class="flex-grow flex flex-col min-h-screen">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <button id="open-sidebar" class="text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <?php
                    require_once("./database/config.php");
                    $stmt = $conn->prepare("SELECT name from borrowers WHERE borrower_id = ?");
                    $stmt->bind_param("i", $_SESSION["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<h1 class="font-bold"> <span class="font-bold text-red-500">  hi! </span> ' . htmlspecialchars($row["name"]) . '</h1>';
                        }
                    } else {
                        echo 0;
                    }
                    ?>
        </header>
        <div class="flex-grow flex items-center justify-center">
            <div class="bg-white shadow-2xl rounded-lg p-8 max-w-sm text-center transform transition-all hover:scale-105">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Current Utang</h1>
                <div class="text-3xl font-extrabold text-red-600">
                    <?php
                    require_once("./database/config.php");
                    $stmt = $conn->prepare("SELECT sum(amount) as amount from Loans WHERE borrower_id = ? AND status IN ('unpaid', 'overdue')");
                    $stmt->bind_param("i", $_SESSION["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                           echo $row["amount"] !== null ? $row["amount"] : 0;
                        }
                    } else {
                        echo 0;
                    }
                    ?>
                </div>
                <p class="text-gray-600 mt-4">This is your current outstanding balance.</p>
            </div>
        </div>
    </div>

    <script>
        const openSidebar = document.getElementById('open-sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>

</html>