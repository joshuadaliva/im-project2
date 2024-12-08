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
          $stmt = $conn->prepare("SELECT name FROM admins WHERE admin_id = ?");
          $stmt->bind_param("i", $_SESSION["id"]);
          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p class='font-bold'> <span class='text-red-500'>! hello  </span>" . htmlspecialchars($row["name"]) . "</p>";
          }
          ?>
          <img alt="User " class="h-10 w-10 rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/T9QXi4dVAwZFPd3BeMxudVe5pfHROMRtVeyJyCO0uBWDySTPB.jpg" width="40" />
        </div>
      </header>
      <div class="flex-1 p-4 sm:p-8">
        <h1 class="text-3xl font-bold mb-6">Manage Loans</h1>
        <div class="overflow-x-auto shadow-md border-b border-gray-200 mb-8 md:h-80 bg-white overflow-y-auto">
          <table class="min-w-full bg-white ">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="px-4 py-2 text-left">Loan ID</th>
                <th class="px-4 py-2 text-left">Borrower name</th>
                <th class="px-4 py-2 text-left">Admin ID</th>
                <th class="px-4 py-2 text-left">Amount</th>
                <th class="px-4 py-2 text-left">Start Date</th>
                <th class="px-4 py-2 text-left">Due Date</th>
                <th class="px-4 py-2 text-center">Status</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <?php
              require_once("./database/config.php");
              $stmt = $conn->prepare("
                        SELECT Loans.*, borrowers.name AS borrower_name 
                        FROM Loans 
                        LEFT JOIN borrowers ON Loans.borrower_id = borrowers.borrower_id
                        WHERE Loans.admin_id = ?
                    ");
              $stmt->bind_param("i", $_SESSION["id"]);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr class=' bg-white hover:bg-gray-200'>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["loan_id"]) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["borrower_name"]) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["admin_id"]) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["amount"]) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["start_date"]) . "</td>
                                        <td class='border px-4 py-2'>" . htmlspecialchars($row["due_date"]) . "</td>
                                        <td class='border px-4 py-2 text-center'>" . htmlspecialchars($row["status"]) . "</td>
                                        <td class='border px-4 py-2 text-center'>
                                            <button class='updateLoan bg-blue-500 text-white px-4 py-2 rounded' value='" . htmlspecialchars($row["loan_id"]) . "'>Update</button>
                                            <button class='deleteLoan bg-red-500 text-white px-4 py-2 rounded' value='" . htmlspecialchars($row["loan_id"]) . "'>Delete</button>
                                        </td>
                                    </tr>";
                }
              } else {
                echo "<tr><td colspan='8' class='text-center py-4'>No loans found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for updating loan -->
  <div id="clientModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-lg px-9 p-6 rounded shadow-lg">
      <h2 class="text-xl font-bold mb-4">Update Loan</h2>
      <form id="clientForm" class="w-full">
        <input type="hidden" id="loan_id" name="loan_id" />
        <div class="mb-4">
          <label for="amount" class="block text-gray-700">Amount</label>
          <input type="number" id="amount" name="amount" class="border rounded w-full py-2 px-3" required />
        </div>
        <div class="mb-4">
          <label for="start_date" class="block text-gray-700">Start Date</label>
          <input type="date" id="start_date" name="start_date" class="border rounded w-full py-2 px-3" required />
        </div>
        <div class="mb-4">
          <label for="due_date" class="block text-gray-700">Due Date</label>
          <input type="date" id="due_date" name="due_date" class="border rounded w-full py-2 px-3" required />
        </div>
        <div class="mb-4">
          <label for="status" class="block text-gray-700">Status</label>
          <select id="status" name="status" class="border rounded w-full py-2 px-3" required>
            <option value="unpaid">unpaid</option>
            <option value="paid">paid</option>
            <option value="overdue">overdue</option>
          </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Loan</button>
        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded ml-2" onclick="document.getElementById('clientModal').classList.add('hidden')">Cancel</button>
      </form>
    </div>
  </div>

  <script src="./js/manage_loan.js"></script>
</body>

</html>