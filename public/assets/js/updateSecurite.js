// Ouvrir le modal
function openModal() {
    let modal = document.getElementById("securityModal");
    let overlay = document.getElementById("overlay");

    if (modal && overlay) {
        modal.style.display = "block";
        overlay.style.display = "block";
    }

    // Récupérer la valeur du data-email pour les deux champs et assigner
    let emailField = document.getElementById("newEmail");
    let emailDisplayField = document.getElementById("displayEmail");

    let emailValue = emailField.getAttribute("data-email");
    emailField.value = emailValue;  // Réinitialiser le champ email
    emailDisplayField.value = emailValue;  // Réinitialiser l'affichage de l'email
}

// Fermer le modal sans sauvegarder les changements
function cancelSecurityChanges() {
    // Check if there are any errors
    let errorMessages = document.getElementsByClassName("error-message");  // Add the class "error-message" to the error elements in the blade view

    if (errorMessages.length > 0) {
        // If errors exist, do not close the modal
        return;
    }

    let modal = document.getElementById("securityModal");
    let overlay = document.getElementById("overlay");

    if (modal && overlay) {
        modal.style.display = "none";
        overlay.style.display = "none";
    }

    // Réinitialiser les champs du modal pour ne pas garder les valeurs modifiées
    let emailField = document.getElementById("newEmail");
    let emailDisplayField = document.getElementById("displayEmail");

    let emailValue = emailField.getAttribute("data-email");

    // Réinitialiser les champs email
    emailField.value = emailValue;
    emailDisplayField.value = emailValue;

    // Réinitialiser les autres champs
    document.getElementById("oldPassword").value = "";
    document.getElementById("newPassword").value = "";
    document.getElementById("confirmPassword").value = "";
}

// Validation avant la soumission du formulaire
document.getElementById('saveButton').addEventListener('click', function (e) {
    // Get input values
    var email = document.getElementById('newEmail').value.trim();
    var oldPassword = document.getElementById('oldPassword').value.trim();
    var newPassword = document.getElementById('newPassword').value.trim();
    var confirmPassword = document.getElementById('confirmPassword').value.trim();

});
