// Function to toggle the password visibility
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.querySelector('input[name="password"]');
    const eyeIcon = document.getElementById('eyeIcon');
    
    // Toggle the type of the input between password and text
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('visible');  // Change color to indicate visibility
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('visible');  // Revert color back to gray
    }
});
