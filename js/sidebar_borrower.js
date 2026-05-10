document.addEventListener('DOMContentLoaded', () => {
  const openSidebar = document.getElementById('open-sidebar');
  const closeSidebar = document.getElementById('close-sidebar');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  if (!openSidebar || !closeSidebar || !sidebar || !overlay) {
    return;
  }

  const open = () => {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
  };

  const close = () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  };

  openSidebar.addEventListener('click', open);
  closeSidebar.addEventListener('click', close);
  overlay.addEventListener('click', close);
});
