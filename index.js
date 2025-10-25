const dataForm = document.getElementById("data-form")
const dataName = document.getElementById("name")
const nameError = document.getElementById("name-error")
const dataEmail = document.getElementById("email")
const emailError = document.getElementById("email-error")
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const dataPhone = document.getElementById("number")
const phoneError = document.getElementById("phone-error")
const phoneRegex = /^$|^09[0-9]{7}$/


dataForm.addEventListener("submit", function (event) {
    event.preventDefault()

    if (dataName.value.trim() === "") {
        nameError.textContent = "El nombre es obligatorio"
        dataName.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        nameError.textContent = ""
        dataName.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

    if (dataEmail.value.trim() === "") {
        emailError.textContent = "El email es obligatorio"
        dataEmail.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else if (!emailRegex.test(dataEmail.value.trim())) {
        emailError.textContent = "El email es inválido"
        dataEmail.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        emailError.textContent = ""
        dataEmail.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

    if (!phoneRegex.test(dataPhone.value.trim())) {
        phoneError.textContent = "El teléfono es inválido"
        dataPhone.style.borderColor = 'rgba(190, 0, 0, 1)'
    } else {
        phoneError.textContent = ""
        dataPhone.style.borderColor = 'rgba(128, 128, 128, 0.73)'
    }

     if (nameError === "" && emailError === "" && phoneError === "") {
        dataForm.reset()
        dataForm.submit()
    }
})