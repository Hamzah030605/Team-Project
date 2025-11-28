document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('mode-toggle');
    const body = document.body;

    // Optional: Get system preference or saved preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Check saved preference or system preference on load
    if (savedTheme === 'dark' || (savedTheme === null && prefersDark)) {
        body.classList.add('dark-mode');
        updateIcons(true);
    } else {
        updateIcons(false);
    }

    if (toggleButton) {
        toggleButton.addEventListener('click', () => {
            // Toggle the dark-mode class on the body
            const isDarkMode = body.classList.toggle('dark-mode');

            // Save preference to local storage
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');

            // Update the sun/moon icons
            updateIcons(isDarkMode);
        });
    }

    function updateIcons(isDarkMode) {
        const moonIcon = document.getElementById('moon-icon');
        const sunIcon = document.getElementById('sun-icon');

        if (moonIcon && sunIcon) {
            if (isDarkMode) {
                // Show sun (light mode icon) when in dark mode
                moonIcon.classList.add('d-none');
                sunIcon.classList.remove('d-none');
                // Ensure button color uses theme variable
                toggleButton.style.color = 'var(--text-color)'; 
            } else {
                // Show moon (dark mode icon) when in light mode
                moonIcon.classList.remove('d-none');
                sunIcon.classList.add('d-none');
                // Ensure button color uses theme variable
                toggleButton.style.color = 'var(--text-color)';
            }
        }
    }
});