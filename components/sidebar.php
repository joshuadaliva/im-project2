<div id="sidebar" class="bg-indigo-600 text-white w-64 flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static absolute sidebar-hidden min-h-screen">
    <div class="flex items-center justify-center h-20 border-b border-indigo-500 relative">
        <span class="ml-2 mt-5 text-2xl font-bold">Pautang System</span>
        <button id="sidebarClose" class="text-gray-500 focus:outline-none lg:hidden absolute top-2 right-2">
            <i class="fas fa-bars text-white text-base m-2"></i>
        </button>
    </div>
    <div class="relative p-4 lg:hidden">
        <input class="bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none w-full" placeholder="Search" type="text" />
    </div>
    <nav class="flex-1 px-4 py-6">
        <ul>
            <li class="mb-4">
                <a class="flex items-center text-indigo-200 hover:text-white font-bold" href="/website/im-project2/dashboard.php">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li class="mb-4">
                <a class="flex items-center text-gray-400 hover:text-white font-bold" href="/website/im-project2/manage_borrowers.php">
                    <i class="fa fa-user mr-3"></i>
                    Manage Borrowers
                </a>
            </li>
            <li class="mb-4">
                <a class="flex items-center text-gray-400 hover:text-white font-bold" href="">
                    <i class="fa fa-credit-card mr-3"></i>
                    Manage Loans
                </a>
            </li>
            <li class="mb-4">
                <a class="flex items-center text-gray-400 hover:text-white font-bold" href="#">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
            </li>
            <li class="mb-4">
                <a class="flex items-center text-gray-400 hover:text-white font-bold" href="#">
                    <i class="fa fa-user-circle mr-3"></i>
                    Profile
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="actions/logout.php" class="flex items-center text-gray-400 hover:text-white font-bold">Logout</a>
            </li>
        </ul>
    </nav>
</div>
