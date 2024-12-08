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
    <title>Loan Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include("../../components/sidebar_borrower.php"); ?>
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <button id="open-sidebar" class="text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </header>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6 text-center">All Loans Made</h1>
        <div class="overflow-x-auto max-h-screen max-w-full">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-blue-500 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Debtor</th>
                        <th class="py-3 px-6 text-left">Amount</th>
                        <th class="py-3 px-6 text-left">Start Date</th>
                        <th class="py-3 px-6 text-left">Due Date</th>
                        <th class="py-3 px-6 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php
                    require_once("../../database/config.php");
                    $stmt = $conn->prepare("
                        SELECT Loans.*, admins.name AS admin_name 
                        FROM Loans 
                        LEFT JOIN admins ON Loans.admin_id = admins.admin_id
                        WHERE Loans.borrower_id = ? 
                    ");
                    $stmt->bind_param("i", $_SESSION["id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr class="border-b border-gray-200 hover:bg-gray-100">';
                            echo '<td class="py-3 px-6">' . htmlspecialchars($row["admin_name"] ?? 'Unknown Admin') . '</td>';
                            echo '<td class="py-3 px-6">' . htmlspecialchars($row["amount"]) . '</td>';
                            echo '<td class="py-3 px-6">' . htmlspecialchars($row["start_date"]) . '</td>';
                            echo '<td class="py-3 px-6">' . htmlspecialchars($row["due_date"]) . '</td>';
                            echo '<td class="py-3 px-6">' . htmlspecialchars($row["status"]) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" class="py-3 px-6 text-center">No loans found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const openSidebar = document.getElementById("open-sidebar");
        const closeSidebar = document.getElementById("close-sidebar");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        openSidebar.addEventListener("click", () => {
            sidebar.classList.remove("-translate-x-full");
            overlay.classList.remove("hidden");
        });

        closeSidebar.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });
    </script>
</body>

</html>