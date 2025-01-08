document.addEventListener('DOMContentLoaded', function () {

  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function (e) {
      const email = document.querySelector('input[type="email"]');
      const linkedin = document.querySelector('input[name="linkedin_profile"]');

      if (email && !validateEmail(email.value)) {
        e.preventDefault();
        alert('Please enter a valid email address');
      }

      if (linkedin && !validateLinkedIn(linkedin.value)) {
        e.preventDefault();
        alert('Please enter a valid LinkedIn URL');
      }
    });
  }


  const darkModeToggle = document.querySelector('.dark-mode-toggle');
  if (darkModeToggle) {
    var theme = window.localStorage.getItem('data-theme');
    if (theme) {
      setTheme(theme);
    }

    darkModeToggle.addEventListener('click', () => {
      var theme = window.localStorage.getItem('data-theme');
      setTheme(theme == 'dark' ? 'light' : 'dark');
    });
  }

  function setTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('data-theme', theme);
  }
});

function validateEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validateLinkedIn(url) {
  return url.includes('linkedin.com/');
}
