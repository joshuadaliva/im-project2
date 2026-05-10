document.addEventListener('DOMContentLoaded', () => {
  const changeSidebarColor = (colorClass) => {
    const sidebars = document.querySelectorAll('.sidebar');
    localStorage.setItem('sidebarColor', colorClass);
    sidebars.forEach((sidebar) => {
      sidebar.classList.remove('bg-red-500', 'bg-green-800', 'bg-indigo-500', 'bg-gray-700');
      sidebar.classList.add(colorClass);
    });
  };

  document.getElementById('red')?.addEventListener('click', () => changeSidebarColor('bg-red-500'));
  document.getElementById('green')?.addEventListener('click', () => changeSidebarColor('bg-green-800'));
  document.getElementById('blue')?.addEventListener('click', () => changeSidebarColor('bg-indigo-500'));
  document.getElementById('dark')?.addEventListener('click', () => changeSidebarColor('bg-gray-700'));
});
