document.addEventListener('DOMContentLoaded', () => {
    // Funzione di validazione
    function validateForm() {
        const usernameInput = document.getElementById('username');
        const username = usernameInput.value.trim();
        const pswdInput = document.getElementById('password');
        const pswd = pswdInput.value.trim();
        const errorDiv = document.getElementById('client-errors');
        errorDiv.textContent = ''; // Pulisce eventuali messaggi precedenti

        if (!username) {
            errorDiv.textContent = "Inserire username.";
            return false; // nessuna POST
        } else if (!pswd) {
            errorDiv.textContent = "Inserire la password.";
            return false; // nessuna POST
        }
        return "VAdamo/index.php"; // POST verso il server alla stessa pagina PHP
    }

    // Associa la funzione di validazione al form
    const form = document.querySelector('form');
    form.onsubmit = validateForm;
});