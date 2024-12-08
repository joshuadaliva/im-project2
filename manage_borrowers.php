<?php

session_start();
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin") {
  header('Location: /im/actions/addon/hecker.php');
  exit;
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
      <div class="flex-1 p-4 sm:p-8">
        <h1 class="text-3xl font-bold mb-6">Manage Borrowers</h1>
        <div class="overflow-x-auto shadow-md  border-b border-gray-200 mb-8 md:h-80  bg-white overflow-y-auto">
          <table class="min-w-full ">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Sex</th>
                <th class="px-4 py-2 text-left">mobile number</th>
                <th class="px-4 py-2 text-left">email</th>
                <th class="px-4 py-2 text-center">Action</th>
              </tr>
            </thead>
            <tbody class="md:h-80 bg-white">
              <?php

              require_once("./database/config.php");
              $stmt = $conn->prepare("SELECT * FROM borrowers");
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr class='bg-white  hover:bg-gray-200'>";
                  echo "<td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>" . htmlspecialchars($row["borrower_id"]) . "</td>";
                  echo "<td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>" . htmlspecialchars($row["name"]) . "</td>";
                  echo "<td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>" . htmlspecialchars($row["sex"]) . "</td>";
                  echo "<td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>" . htmlspecialchars($row["mobile_number"]) . "</td>";
                  echo "<td class='border px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>" . htmlspecialchars($row["email"]) . "</td>";
                  echo "<td class='border px-4 py-2 text-center'>
                            <button class='bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700 addLoan' value='" . htmlspecialchars($row["borrower_id"]) . "'>Add Loan</button>
                          </td>";
                  echo "</tr>";
                }
              } else {
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
  <script src="./js/addLoan.js"></script>
</body>

</html>