(function () {
  if (!document.querySelector('link[data-local-tailwind]')) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = '/im/assets/vendor/tailwind/tailwind.min.css';
    link.setAttribute('data-local-tailwind', 'true');
    document.head.appendChild(link);
  }
}());
