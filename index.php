<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="main-container">
        <div class="upper-container">
            <img src="credifama_logo.svg" alt="credifama logo" class="credigama-logo">
        </div>

        <div class="bottom-container">
            <div class="left-panel">
                <h2 class="panel-title">Ingreso de datos</h2>
                <form id="data-form" action="index.php" method="post" class="data-form">
                    <div class="input-container">
                        <label class="input-label">Nombre*</label>
                        <div class="field-container">
                            <input id="name" type="text" name="nombre" class="data-input">
                            <p id="name-error" class="error-message"></p>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Email*</label>
                        <div class="field-container">
                            <input id="email" type="text" class="data-input">
                            <p id="email-error" class="error-message"></p>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Teléfono</label>
                        <div class="field-container">
                            <input id="number" type="text" maxlength="9" class="data-input">
                            <p id="phone-error" class="error-message"></p>
                        </div>
                    </div>
                    <div class="input-container">
                        <input type="submit" name="enviar" value="Enviar" class="send-btn">
                    </div>
                </form>
            </div>
            <span class="panel-separator"></span>
            <div class="right-panel">
                <h2 class="panel-title">Listado de datos</h2>
                <div class="data-card">
                    <span>Nombre: Javier Moreno</span>
                    <span>Email: javier@gmail.com</span>
                    <span>Teléfono: 096 715 450</span>
                    <span>Ingresado: 10/24/2025</span>
                </div>
            </div>
        </div>
    </div>

    <script src="index.js"></script>
</body>

</html>