const form = document.getElementById("data-form")
const nameInput = document.getElementById("name")
const nameError = document.getElementById("name-error")
const emailInput = document.getElementById("email")
const emailError = document.getElementById("email-error")
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phoneInput = document.getElementById("number")
const phoneError = document.getElementById("phone-error")
const phoneRegex = /^$|^09[0-9]{7}$/
const cardContainer = document.getElementById("card-container")

function loadUsers() {
    fetch("get-users.php")
        .then(res => res.json())
        .then(data => {
            if (data.users && data.users.length > 0) {
                cardContainer.innerHTML = ""
                data.users.forEach(user => {
                    cardContainer.innerHTML += `<div class="data-card">
                        <span>Nombre: ${user.nombre}</span>
                        <span>Email: ${user.email}</span>
                        <span>Teléfono: ${user.telefono ?? 'N/A'}</span>
                        <span>Ingresado: ${formatDate(user.fecha_ingreso)}</span>
                    </div>`
                })
            } else {
                cardContainer.innerHTML = `<p>No hay datos para mostrar</p>`
            }
        })
        .catch(err => console.log('Error:', err))
}

function validateInput(input, condition, errorElement, message) {
    if (condition) {
        errorElement.textContent = message
        input.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        errorElement.textContent = ""
        input.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }
}

function formatDate(dateStr) {

    if (!dateStr || typeof dateStr !== "string") return "N/A";

    const [fecha, hora] = dateStr.split(" ");
    if (!fecha || !hora) return "N/A";

    const [anio, mes, dia] = fecha.split("-");
    const [horas, minutos, segundos] = hora.split(":");

    return `${dia}-${mes}-${anio} ${horas}:${minutos}:${segundos}`;
}


async function handleSubmit(event) {
    event.preventDefault()

    validateInput(nameInput, nameInput.value.trim() === "", nameError, "El nombre es obligatorio")
    if (emailInput.value.trim() === "") {
        validateInput(emailInput, true, emailError, "El email es obligatorio")
    } else {
        validateInput(emailInput, !emailRegex.test(emailInput.value.trim()), emailError, "El email tiene formato inválido")
    }
    validateInput(phoneInput, !phoneRegex.test(phoneInput.value.trim()), phoneError, "El teléfono es inválido")

    if (nameError.textContent !== ""
        || emailError.textContent !== ""
        || phoneError.textContent !== "") {
        return
    }

    const formData = new FormData(form);
    try {
        const res = await fetch('add-user.php', { method: 'POST', body: formData });
        const data = await res.json(); 
        if (res.status === 201) {
            form.reset();
            loadUsers();
        } else if (res.status === 409) {
            validateInput(emailInput, data.errors.email, emailError, data.errors.email);
            validateInput(phoneInput, data.errors.telefono, phoneError, data.errors.telefono);
        }
    }
    catch (err) {
        console.error("Error al enviar formulario:", err);
    }
};

document.addEventListener("DOMContentLoaded", loadUsers);
form.addEventListener("submit", handleSubmit)


