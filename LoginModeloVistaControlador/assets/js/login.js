/* =========================================================
   Validación del inicio de sesión.
   Valida en el navegador antes de enviar al controlador.
   ========================================================= */

(function () {
    "use strict";

    const form = document.getElementById("loginForm");

    if (!form) {
        return;
    }

    const correo = document.getElementById("correo");
    const clave = document.getElementById("clave");
    const togglePassword = document.getElementById("togglePassword");
    const btnSubmit = document.getElementById("btnSubmit");
    const alertBox = document.getElementById("formAlert");
    const alertText = document.getElementById("formAlertText");

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    /* ---------------------- Mostrar / ocultar clave ---------------------- */

    const eyeIcon = togglePassword.querySelector(".eye-icon");
    const eyeOffIcon = togglePassword.querySelector(".eye-off-icon");

    togglePassword.addEventListener("click", function () {
        const isPassword = clave.type === "password";

        clave.type = isPassword ? "text" : "password";
        togglePassword.setAttribute("aria-pressed", String(isPassword));
        togglePassword.setAttribute(
            "aria-label",
            isPassword ? "Ocultar contraseña" : "Mostrar contraseña"
        );

        eyeIcon.classList.toggle("is-hidden", isPassword);
        eyeOffIcon.classList.toggle("is-hidden", !isPassword);

        clave.focus();
    });

    /* ----------------------------- Alertas ----------------------------- */

    function showAlert(type, message) {
        alertBox.hidden = false;
        alertBox.className = "form-alert form-alert--" + type;
        alertText.textContent = message;
    }

    function hideAlert() {
        alertBox.hidden = true;
        alertText.textContent = "";
    }

    /* ------------------------ Errores de campos ------------------------ */

    function showError(input, message) {
        const field = input.closest(".field");
        const error = field.querySelector(".field-error");

        input.setAttribute("aria-invalid", "true");
        error.textContent = message;
    }

    function clearError(input) {
        const field = input.closest(".field");
        const error = field.querySelector(".field-error");

        input.removeAttribute("aria-invalid");
        error.textContent = "";
    }

    /* ---------------------------- Validación ---------------------------- */

    function validate() {
        let firstInvalid = null;

        clearError(correo);
        clearError(clave);

        const emailValue = correo.value.trim();
        const passwordValue = clave.value;

        if (emailValue === "") {
            showError(correo, "Ingresa tu correo electrónico.");
            firstInvalid = firstInvalid || correo;
        } else if (!emailPattern.test(emailValue)) {
            showError(correo, "Escribe un correo válido, por ejemplo: nombre@dominio.com");
            firstInvalid = firstInvalid || correo;
        }

        if (passwordValue === "") {
            showError(clave, "Ingresa tu contraseña.");
            firstInvalid = firstInvalid || clave;
        }

        if (firstInvalid) {
            firstInvalid.focus();
            return false;
        }

        return true;
    }

    /* --------------------------- Interacción --------------------------- */

    [correo, clave].forEach(function (input) {
        input.addEventListener("input", function () {
            clearError(input);
            hideAlert();
        });
    });

    /* ---------------------------- Envío ---------------------------- */

    form.addEventListener("submit", function (event) {
        const isValid = validate();

        if (!isValid) {
            event.preventDefault();
            showAlert("error", "Revisa los campos marcados antes de continuar.");
            return;
        }

        // Datos válidos: se envía al controlador y se muestra el estado de carga.
        btnSubmit.disabled = true;
        btnSubmit.classList.add("is-loading");
    });
})();
