 // Sign In Dropdown
 document.addEventListener('DOMContentLoaded', function() {
  // Desktop dropdown functionality
  document
      .getElementById("signInMenuBtn")
      .addEventListener("click", function() {
          const dropdown = document.getElementById("signInDropdown");
          dropdown.classList.toggle("hidden");

          // Animation for showing dropdown
          if (!dropdown.classList.contains("hidden")) {
              dropdown.classList.add("animate-fadeIn");
              setTimeout(() => {
                  dropdown.classList.remove("animate-fadeIn");
              }, 300);
          }
      });

  document.addEventListener("click", function(event) {
      const signInDropdown = document.getElementById("signInDropdown");
      const signInMenuBtn = document.getElementById("signInMenuBtn");

      if (
          !signInMenuBtn.contains(event.target) &&
          !signInDropdown.contains(event.target)
      ) {
          signInDropdown.classList.add("hidden");
      }
  });

  // Mobile menu toggle
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");

  mobileMenuButton.addEventListener("click", function() {
      const isOpen = !mobileMenu.classList.contains("hidden");

      if (isOpen) {
          // Close the menu with animation
          mobileMenu.style.maxHeight = "0";
          setTimeout(() => {
              mobileMenu.classList.add("hidden");
          }, 300);
      } else {
          // Open the menu with animation
          mobileMenu.classList.remove("hidden");
          setTimeout(() => {
              mobileMenu.style.maxHeight = "500px"; // Adjust as needed
          }, 10);
      }
  });

  // Toggle accordion functionality for mobile menu
  window.toggleAccordion = function(id) {
      const accordion = document.getElementById(id);
      const icon = document.getElementById(id + "Icon");

      if (accordion.classList.contains("hidden")) {
          // Open accordion
          accordion.classList.remove("hidden");
          accordion.style.maxHeight = "0";

          setTimeout(() => {
              accordion.style.maxHeight = accordion.scrollHeight + "px";
              if (icon) icon.classList.add("rotate-180");
          }, 10);
      } else {
          // Close accordion
          accordion.style.maxHeight = "0";
          if (icon) icon.classList.remove("rotate-180");

          setTimeout(() => {
              accordion.classList.add("hidden");
          }, 300);
      }
  };

  // Theme toggle functionality
  const themeToggle = document.getElementById("theme-toggle");
  const mobileThemeToggle = document.getElementById("mobile-theme-toggle");

  // Function to toggle theme
  function toggleTheme() {
      document.documentElement.classList.toggle("dark");

      // Save theme preference to localStorage
      if (document.documentElement.classList.contains("dark")) {
          localStorage.theme = "dark";
      } else {
          localStorage.theme = "light";
      }
  }

  themeToggle.addEventListener("click", toggleTheme);
  mobileThemeToggle.addEventListener("click", toggleTheme);

  // Apply saved theme on page load
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
          '(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark');
  } else {
      document.documentElement.classList.remove('dark');
  }

  // Newsletter form validation
  const newsletterForm = document.getElementById("newsletter-form");
  const newsletterEmail = document.getElementById("newsletter-email");
  const newsletterSubmit = document.getElementById("newsletter-submit");
  const newsletterMessage = document.getElementById("newsletter-message");

  newsletterEmail.addEventListener("input", function() {
      const isValid = newsletterEmail.checkValidity();
      newsletterSubmit.disabled = !isValid;
  });

  newsletterForm.addEventListener("submit", function(e) {
      e.preventDefault();
      newsletterSubmit.disabled = true;
      newsletterMessage.textContent = "Processing...";

      // Simulate API call
      setTimeout(() => {
          newsletterMessage.textContent = "Thank you for subscribing!";
          newsletterMessage.classList.add("text-green-400");
          newsletterEmail.value = "";
      }, 1000);
  });
});