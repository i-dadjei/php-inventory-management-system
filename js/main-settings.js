// Get the button, icon, and body elements
const toggleButton = document.getElementById('toggle-button');
const modeIcon = document.getElementById('mode-icon');
const body = document.body;

// Check if the user has previously selected dark mode from localStorage
if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
    modeIcon.classList.remove('fa-sun');
    modeIcon.classList.add('fa-moon');
}

// Add event listener to the button for toggling the modes
toggleButton.addEventListener('click', () => {
    // Toggle the dark mode class on the body
    body.classList.toggle('dark-mode');

    // Change icon based on the current mode
    if (body.classList.contains('dark-mode')) {
        modeIcon.classList.remove('fa-sun');
        modeIcon.classList.add('fa-moon');
        localStorage.setItem('darkMode', 'enabled'); // Save dark mode preference
    } else {
        modeIcon.classList.remove('fa-moon');
        modeIcon.classList.add('fa-sun');
        localStorage.setItem('darkMode', 'disabled'); // Save light mode preference
    }
});
