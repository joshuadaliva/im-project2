<?php

if(isset($_SESSION)){
  session_start();
  if ($_SESSION["userType"] != "admin") {
    header("Location: /im/actions/addon/hecker.php");
  }
}

?>

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
        <h1 class="text-3xl font-bold mb-6">Manage Loans</h1>
        <div class="overflow-x-auto shadow-md relative  border-b border-gray-200 mb-8 md:h-80 bg-white overflow-y-auto">
          <table class="min-w-full bg-white ">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="px-4 py-2 text-left">loan id</th>
                <th class="px-4 py-2 text-left">borrower id</th>
                <th class="px-4 py-2 text-left">admin id</th>
                <th class="px-4 py-2 text-left">amount</th>
                <th class="px-4 py-2 text-left">start date</th>
                <th class="px-4 py-2 text-left">due date</th>
                <th class="px-4 py-2 text-center">status</th>
                <th class="px-4 py-2 text-center">actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              require_once("./database/config.php");
              $stmt = $conn->prepare("SELECT * FROM Loans WHERE admin_id =  ? ");
              $stmt-> bind_param("i", $_SESSION["id"]);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr class='border-b-2 border-gray-400/20'>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["loan_id"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["borrower_id"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["admin_id"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["amount"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["start_date"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["due_date"]) . "</td>";
                  echo "<td class='px-4 py-2 max-w-xm overflow-hidden text-ellipsis'>" . htmlspecialchars($row["status"]) . "</td>";
                  echo "<td class='px-4 py-2 text-center flex'>
                            <button class='bg-yellow-500 text-white m-1  px2 py-1 rounded addLoan' value='" . htmlspecialchars($row["borrower_id"]) . "'>Update Loan</button>
                            <button class='bg-red-500 text-white m-1 px-2 py-1 rounded addLoan' value='" . htmlspecialchars($row["borrower_id"]) . "'>Delete Loan</button>
                          </td>";
                  echo "</tr>";
                }
              }
              else{
                echo "<tr>
                        <td colspan='8' class='text-center py-4'>
                        <span class='text-red-500 font-bold'>No Loan Found</span>
                        </td>
                    </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>

        <div id="clientModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
          <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add New Client</h2>
            <form id="clientForm">
              <div class="mb-4">
                <label for="amount" class="block text-sm font-semibold mb-2">amount</label>
                <input type="number" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded" required>
              </div>
              <div class="mb-4">
                <label for="start_date" class="block text-sm font-semibold mb-2">start date</label>
                <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded" required>
              </div>
              <div class="mb-4">
                <label for="due_date" class="block text-sm font-semibold mb-2">due date</label>
                <input type="date" id="due_date" name="due_date" class="w-full px-4 py-2 border border-gray-300 rounded" required>
              </div>
              <div class="mb-4">
                <label for="status" class="block text-sm font-semibold mb-2">status</label>
                <select name="status" id="status" class="p-2 rounded-md cursor-pointer">
                  <option value="unpaid">unpaid</option>
                </select>
              </div>
              <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" id="closeModalBtn">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
 <script>
    
 </script>
</body>
</html>