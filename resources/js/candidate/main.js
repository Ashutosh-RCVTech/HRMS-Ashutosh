document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");

    // Check for saved theme preference or prefer-color-scheme
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!localStorage.getItem("color-theme") &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    // Toggle theme when button is clicked
    themeToggle.addEventListener("click", function () {
        // Toggle class on document element
        document.documentElement.classList.toggle("dark");

        // Update localStorage value
        if (document.documentElement.classList.contains("dark")) {
            localStorage.setItem("color-theme", "dark");
        } else {
            localStorage.setItem("color-theme", "light");
        }
    });

    document
        .getElementById("profileMenuBtn")
        .addEventListener("click", function () {
            document
                .getElementById("profileDropdown")
                .classList.toggle("hidden");
        });

    document.addEventListener("click", function (event) {
        const profileDropdown = document.getElementById("profileDropdown");
        const profileMenuBtn = document.getElementById("profileMenuBtn");

        if (
            !profileMenuBtn.contains(event.target) &&
            !profileDropdown.contains(event.target)
        ) {
            profileDropdown.classList.add("hidden");
        }
    });
});
