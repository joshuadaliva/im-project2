<?php
require_once __DIR__ . "/./includes/security.php";
    app_secure_session_start();
    if(!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin"){
        header('Location: /im/actions/addon/hecker.php'); 
        exit;
    }
    
?>


<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard</title>
    <script src="/im/assets/vendor/tailwind/tailwindcss.js" integrity="sha384-bNgnNtW1ThPcFq/uPp2Yt3e0nlaMZssfero1Z6+KZFDwnIYIPgnhZ+ljAlsad5DY" crossorigin="anonymous"></script>
    <script src="/im/assets/vendor/chartjs/Chart.min.js" integrity="sha384-6vvKlkk0JXzi0Mna0VX9qlzK3+sIUVODY01DE2StB0qbuFnes0O2dBGZ+G/p4bBS" crossorigin="anonymous"></script>
    <link href="/im/assets/vendor/fontawesome/css/all.min.css" rel="stylesheet" integrity="sha384-VptpI+/HXUmQ4/00mROBcVLzZ3bfP1gDR5u14cb0GWSfZ8nQXgh4hYVpYFn8l2Hx" crossorigin="anonymous">
<?= app_csrf_meta() ?>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once("./components/sidebar.php"); ?>
        <div class="flex-1 flex flex-col">
            <header class="flex items-center justify-between bg-white p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="relative ml-4 lg:ml-0 hidden lg:block">
                        <input class="bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none" placeholder="Search" type="text"/>
                        <i class="fas fa-search absolute left-3 top-2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php
                        require_once("./database/config.php");
                        $stmt = $conn -> prepare("select name from admins where admin_id = ?");
                        $stmt -> bind_param("i", $_SESSION["id"]);
                        $stmt -> execute();
                        $result = $stmt -> get_result();
                        if($result -> num_rows > 0){
                            $row = $result -> fetch_assoc();
                            echo "<p class= 'font-bold'> <span class='text-red-500'>! hello  </span>"  .  htmlspecialchars($row["name"]) . "</p>";
                        }
                    ?>
                    <img alt="User" class="h-10 w-10 rounded-full ml-4" height="40" src="/im/assets/img/user.svg" width="40"/>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center">
                            <i class="fas fa-user text-blue-500 text-3xl"></i>
                            <div class="ml-4">
                                <h4 class="text-gray-500">Total Made Loans</h4>
                                <?php
                                    include("./database/config.php");
                                    $stmt = $conn -> prepare("SELECT Count(amount) as total_borrowers from Loans WHERE admin_id = ?");
                                    $stmt -> bind_param("i", $_SESSION["id"]);
                                    $stmt -> execute();
                                    $result = $stmt -> get_result();
                                    if($result -> num_rows > 0){
                                        $row = $result -> fetch_assoc();
                                        echo ' <h2 class="text-2xl font-bold">'. htmlspecialchars($row["total_borrowers"])  . '</h2> ';
                                    }
                                    else {
                                        echo '<h2 class="text-2xl font-bold">0</h2>';
                                
                                    }
                                    
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign text-yellow-500 text-3xl"></i>
                            <div class="ml-4">
                                <h4 class="text-gray-500">Total Borrowed Money</h4>
                                <?php
                                    include("./database/config.php");
                                    $stmt = $conn -> prepare("SELECT sum(amount) as total_amount from Loans WHERE admin_id = ?");
                                    $stmt -> bind_param("i", $_SESSION["id"]);
                                    $stmt -> execute();
                                    $result = $stmt -> get_result();
                                    if($result -> num_rows > 0){
                                        $row = $result -> fetch_assoc();
                                        echo $row["total_amount"] !== null ? ' <h2 class="text-2xl font-bold">'. htmlspecialchars($row["total_amount"])  . '</h2> ' : ' <h2 class="text-2xl font-bold">0 </h2> ';
                                    }
                                    else{
                                        echo '<h2 class="text-2xl font-bold">0</h2>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center">
                            <i class="fa fa-check-circle text-green-500 text-3xl"></i>
                            <div class="ml-4">
                                <h4 class="text-gray-500">Total Paid Users</h4>
                                <?php
                                    include("./database/config.php");
                                    $stmt = $conn -> prepare("SELECT count(status) as unpaid from Loans WHERE status = 'paid' && admin_id = ?");
                                    $stmt -> bind_param("i", $_SESSION["id"]);
                                    $stmt -> execute();
                                    $result = $stmt -> get_result();
                                    if($result -> num_rows > 0){
                                        $row = $result -> fetch_assoc();
                                        echo ' <h2 class="text-2xl font-bold">'. htmlspecialchars($row["unpaid"])  . '</h2> ';
                                    }
                                    else {
                                        echo '<h2 class="text-2xl font-bold">0</h2>'; 
                                
                                    }
                                    
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center">
                            <i class="fa fa-times-circle text-red-500 text-3xl"></i>
                            <div class="ml-4">
                                <h4 class="text-gray-500">Total Unpaid Users</h4>
                                <?php
                                    require_once("./database/config.php");
                                    $stmt = $conn -> prepare("SELECT count(status) as unpaid from Loans WHERE status = 'unpaid' && admin_id = ?");
                                    $stmt -> bind_param("i", $_SESSION["id"]);
                                    $stmt -> execute();
                                    $result = $stmt -> get_result();
                                    if($result -> num_rows > 0){
                                        $row = $result -> fetch_assoc();
                                        echo ' <h2 class="text-2xl font-bold">'. htmlspecialchars($row["unpaid"])  . '</h2> ';
                                    }
                                    else {

                                        echo '<h2 class="text-2xl font-bold">0</h2>';
                                
                                    }
                                    
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Analytics</h3>
                        <canvas id="myChart" class="w-full max-w-full"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="/im/js/dashboard_chart.js" integrity="sha384-UbHX11AEg+nUYk5EEezdBd2LwAgibsA2VHXC9WWSkjOTnn8MQyFcIwuVrOHZKh6r" crossorigin="anonymous"></script>

</body>
</html>