document.addEventListener("DOMContentLoaded", function () {
    let togglePassword = document.getElementById("togglePassword");
    let passwordInput = document.getElementById("password");

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            passwordInput.classList.toggle("show-password");

            if (passwordInput.classList.contains("show-password")) {
                passwordInput.setAttribute("type", "text");
                this.setAttribute("name", "eye-off-outline"); // Change icon
            } else {
                passwordInput.setAttribute("type", "password");
                this.setAttribute("name", "lock-closed-outline"); // Revert icon
            }
        });
    }
});
