(function () {
  if (!document.querySelector('link[data-local-tailwind]')) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = '/im/assets/vendor/tailwind/tailwind.min.css';
    link.integrity = 'sha384-KYShmLEIZs+qOi0nCAm6yhRbw60FgzK5kO/yq+OMVgeZypzmbbay/6xVPL1zPAI8';
    link.crossOrigin = 'anonymous';
    link.setAttribute('data-local-tailwind', 'true');
    document.head.appendChild(link);
  }
}());
