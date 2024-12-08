<?php
    session_start();
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
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
                    <img alt="User" class="h-10 w-10 rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/T9QXi4dVAwZFPd3BeMxudVe5pfHROMRtVeyJyCO0uBWDySTPB.jpg" width="40"/>
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
                                        echo ' <h2 class="text-2xl font-bold">'. htmlspecialchars($row["total_amount"])  . '</h2> ';
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
                            <i class="fa fa-check-circle text-red-500 text-3xl"></i>
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
                            <i class="fa fa-times-circle text-purple-500 text-3xl"></i>

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
                        <canvas id="myChart" style="width:100%;max-width:100%"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>

        const xValues = [100,200,300,400,500,600,700,800,900,1000];

        new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{ 
            data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
            borderColor: "red",
            fill: false
            }, { 
            data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
            borderColor: "green",
            fill: false
            }, ]
        },
        options: {
            legend: {display: false}
        }
        });
    </script>
</body>
</html>