document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarClose = document.getElementById('sidebarClose');

  if (!sidebar) {
    return;
  }

  const toggleSidebar = () => sidebar.classList.toggle('sidebar-hidden');

  sidebarToggle?.addEventListener('click', toggleSidebar);
  sidebarClose?.addEventListener('click', toggleSidebar);

  const sidebarColor = localStorage.getItem('sidebarColor') || 'bg-indigo-500';
  sidebar.classList.add(sidebarColor);
});
