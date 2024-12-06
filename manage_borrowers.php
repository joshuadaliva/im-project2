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
        <h1 class="text-3xl font-bold mb-6">Manage Clients</h1>
        <div class="overflow-x-auto shadow-md  border-b border-gray-200 mb-8 md:h-80  overflow-y-auto">
          <table class="min-w-full bg-white">
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
            <tbody>
              <?php

                require_once("./database/config.php");
                $stmt = $conn -> prepare("SELECT * FROM borrowers");
                $stmt -> execute();
                $result = $stmt -> get_result();
                if($result -> num_rows > 0){
                  while($row = $result -> fetch_assoc()){
                    echo "<tr class='border-b-2 border-gray-400/20'>";
                    echo "<td class='px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>". htmlspecialchars($row["borrower_id"]) . "</td>";
                    echo "<td class='px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>". htmlspecialchars($row["name"]) . "</td>";
                    echo "<td class='px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>". htmlspecialchars($row["sex"]) . "</td>";
                    echo "<td class='px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>". htmlspecialchars($row["mobile_number"]) . "</td>";
                    echo "<td class='px-4 py-2 max-w-xs overflow-hidden text-ellipsis'>". htmlspecialchars($row["email"]) . "</td>";
                    echo "<td class='px-4 py-2 text-center'>
                            <button class='bg-blue-500 text-white px-2 py-1 rounded addLoan'>Add Loan</button>
                          </td>";
                    echo "</tr>";
                  }
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
                <input type="text" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded" required>
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
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('sidebar-hidden');
    });
    document.getElementById('sidebarClose').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('sidebar-hidden');
    });

    const clientModal = document.getElementById('clientModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    closeModalBtn.addEventListener('click', () => {
      clientModal.classList.add('hidden');
    });

    const clientForm = document.getElementById('clientForm');
    clientForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Client saved!');
      clientModal.classList.add('hidden');
    });

    
    const addLoan = document.querySelectorAll(".addLoan")
    addLoan.forEach(btn => {
      btn.addEventListener("click", () => {
        clientModal.classList.remove("hidden")
        document.getElementById("modalTitle").textContent = "Add new Loan";
        document.getElementById("clientForm").reset();
      })
    })

    
  </script>
</body>

</html>