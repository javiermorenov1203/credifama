<?php
header('Content-Type: application/json; charset=utf-8');
require_once('db.php');

// ------------------------
// 1️⃣ Recibir y sanear datos
// ------------------------
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');

// ------------------------
// 2️⃣ Validar campos obligatorios
// ------------------------
$errors = [
    'nombre' => null,
    'email' => null,
    'telefono' => null
];

if ($nombre === '') {
    $errors['nombre'] = 'El nombre es obligatorio';
}

if ($email === '') {
    $errors['email'] = 'El email es obligatorio';
} else {
    // Validar formato con regex
    $regex_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (!preg_match($regex_email, $email)) {
        $errors['email'] = 'El email tiene un formato inválido';
    }
}

$regex_telefono = "/^$|^09[0-9]{7}$/";
if (!preg_match($regex_telefono, $telefono)) {
    $errors['telefono'] = 'El telefono tiene un formato inválido';
}

// Si hay errores de validación, devolvemos 400 con todos los errores
if (!empty(array_filter($errors))) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'errors' => array_filter($errors)]);
    exit;
}

// ------------------------
// 3️⃣ Intentar insertar en DB
// ------------------------
try {
    $stmt = $conn->prepare(
        "INSERT INTO users (full_name, email, phone, input_date)
         VALUES (?, ?, NULLIF(?, ''), NOW())"
    );
    $stmt->bind_param("sss", $nombre, $email, $telefono);
    $stmt->execute();

    // ------------------------
    // 4️⃣ Éxito
    // ------------------------
    http_response_code(201); // Created
    echo json_encode([
        'success' => true,
        'message' => 'Usuario creado correctamente',
        'user' => [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono
        ]
    ]);

} catch (mysqli_sql_exception $e) {

    // ------------------------
    // 5️⃣ Manejo de duplicados
    // ------------------------
    if ($e->getCode() === 1062) { // Duplicate entry
        if (str_contains($e->getMessage(), "unique_email")) {
            $errors['email'] = 'El email ya esta registrado';
        }
        if (str_contains($e->getMessage(), "unique_phone")) {
            $errors['telefono'] = 'El teléfono ya está registrado';
        }

        http_response_code(409); // Conflict
        echo json_encode(['success' => false, 'errors' => array_filter($errors)]);

    } else {
        // ------------------------
        // 6️⃣ Otros errores del servidor
        // ------------------------
        http_response_code(500); // Server error
        echo json_encode([
            'success' => false,
            'errors' => ['general' => 'Error al guardar los datos'],
            'details' => $e->getMessage()
        ]);
    }
}

// ------------------------
// 7️⃣ Cerrar conexión
// ------------------------
$stmt->close();
$conn->close();
?>