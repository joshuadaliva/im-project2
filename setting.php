<?php
require_once __DIR__ . "/./includes/security.php";

app_secure_session_start();
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
    <script src="/im/assets/vendor/tailwind/tailwindcss.js" integrity="sha384-bNgnNtW1ThPcFq/uPp2Yt3e0nlaMZssfero1Z6+KZFDwnIYIPgnhZ+ljAlsad5DY" crossorigin="anonymous"></script>
    <link href="/im/assets/vendor/fontawesome/css/all.min.css" rel="stylesheet" integrity="sha384-VptpI+/HXUmQ4/00mROBcVLzZ3bfP1gDR5u14cb0GWSfZ8nQXgh4hYVpYFn8l2Hx" crossorigin="anonymous">
<?= app_csrf_meta() ?>
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
                    <img alt="User" class="h-10 w-10 rounded-full ml-4" height="40" src="/im/assets/img/user.svg" width="40" />
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

        <script src="/im/js/settings.js" integrity="sha384-WosMjCK9IC2Uw4kZ8iXfKEy8pGQPnwgsZpLjT9RHPcZJ18zeQhu/K7IRs9oBZG2E" crossorigin="anonymous"></script>

</body>

</html>