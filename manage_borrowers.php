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
    <div class="flex-1 flex flex-col">
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

        <button class="bg-blue-600 text-white px-4 py-2 rounded mb-6" id="addClientBtn">
          Add New Client
        </button>

        <div class="overflow-x-auto shadow-md border-b border-gray-200 mb-8">
          <table class="min-w-full bg-white">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Contact Info</th>
                <th class="px-4 py-2 text-left">Address</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="px-4 py-2">1</td>
                <td class="px-4 py-2">John Doe</td>
                <td class="px-4 py-2">john.doe@example.com</td>
                <td class="px-4 py-2">1234 Main St, City, Country</td>
                <td class="px-4 py-2 text-center">
                  <button class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                  <button class="bg-red-500 text-white px-2 py-1 rounded ml-2">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div id="clientModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
          <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add New Client</h2>
            <form id="clientForm">
              <div class="mb-4">
                <label for="name" class="block text-sm font-semibold mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded" required>
              </div>
              <div class="mb-4">
                <label for="contact_info" class="block text-sm font-semibold mb-2">Contact Info</label>
                <input type="email" id="contact_info" name="contact_info" class="w-full px-4 py-2 border border-gray-300 rounded" required>
              </div>
              <div class="mb-4">
                <label for="address" class="block text-sm font-semibold mb-2">Address</label>
                <input type="text" id="address" name="address" class="w-full px-4 py-2 border border-gray-300 rounded" required>
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


    const addClientBtn = document.getElementById('addClientBtn');
    const clientModal = document.getElementById('clientModal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    addClientBtn.addEventListener('click', () => {
      clientModal.classList.remove('hidden');
      document.getElementById('modalTitle').textContent = 'Add New Client';
      document.getElementById('clientForm').reset();
    });

    closeModalBtn.addEventListener('click', () => {
      clientModal.classList.add('hidden');
    });

    const clientForm = document.getElementById('clientForm');
    clientForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Client saved!');
      clientModal.classList.add('hidden');
    });
  </script>
</body>

</html>