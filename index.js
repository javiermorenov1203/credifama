const form = document.getElementById("data-form")
const nameInput = document.getElementById("name")
const nameError = document.getElementById("name-error")
const emailInput = document.getElementById("email")
const emailError = document.getElementById("email-error")
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phoneInput = document.getElementById("number")
const phoneError = document.getElementById("phone-error")
const phoneRegex = /^$|^09[0-9]{7}$/


form.addEventListener("submit", function (event) {
    event.preventDefault()

    if (nameInput.value.trim() === "") {
        nameError.textContent = "El nombre es obligatorio"
        nameInput.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        nameError.textContent = ""
        nameInput.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

    if (emailInput.value.trim() === "") {
        emailError.textContent = "El email es obligatorio"
        emailInput.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else if (!emailRegex.test(emailInput.value.trim())) {
        emailError.textContent = "El email es inválido"
        emailInput.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        emailError.textContent = ""
        emailInput.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

    if (!phoneRegex.test(phoneInput.value.trim())) {
        phoneError.textContent = "El teléfono es inválido"
        phoneInput.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        phoneError.textContent = ""
        phoneInput.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

    if (nameError.textContent !== ""
        || emailError.textContent !== ""
        || phoneError.textContent !== "") {
        return
    }

    const formData = new FormData(form);

    fetch('add-user.php', { method: 'POST', body: formData })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(({ status, body }) => {
            if (status === 201) {
                alert(body.message); // o mostrar en un div de éxito
                form.reset();
            } else if (status === 409) {
                if (body.errors.email) {
                    emailError.textContent = body.errors.email;
                    emailInput.style.borderColor = 'rgba(190, 0, 0, 1)'
                } else {
                    emailError.textContent = '';
                    emailInput.style.borderColor = 'rgba(128, 128, 128, 0.73)'
                }

                if (body.errors.telefono) {
                    phoneError.textContent = body.errors.telefono;
                    phoneInput.style.borderColor = 'rgba(190, 0, 0, 1)'
                } else {
                    phoneError.textContent = '';
                    phoneInput.style.borderColor = 'rgba(128, 128, 128, 0.73)'
                }
            }
        })
        .catch(err => console.error('Fetch error:', err));
});