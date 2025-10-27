<?php
header('Content-Type: application/json; charset=utf-8');
require_once('db.php');

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');

$errors = [
    'nombre' => null,
    'email' => null,
    'telefono' => null
];

// valido inputs
if ($nombre === '') {
    $errors['nombre'] = 'El nombre es obligatorio';
}

if ($email === '') {
    $errors['email'] = 'El email es obligatorio';
} else {
    $regex_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (!preg_match($regex_email, $email)) {
        $errors['email'] = 'El email tiene un formato inválido';
    }
}

$regex_telefono = "/^$|^09[0-9]{7}$/";
if (!preg_match($regex_telefono, $telefono)) {
    $errors['telefono'] = 'El telefono tiene un formato inválido';
}

// si algun campo es invalido, detengo insert
if (!empty(array_filter($errors))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => array_filter($errors)]);
    exit;
}

// antes de insertar, valido si ya existe mail y telefono en BD
$checkStmt = $conn->prepare("SELECT email, phone FROM users WHERE email = ? OR phone = ?");
$checkStmt->bind_param("ss", $email, $telefono);
$checkStmt->execute();
$result = $checkStmt->get_result();

while ($row = $result->fetch_assoc()) {
    if ($row['email'] === $email) {
        $errors['email'] = 'El email ya está registrado';
    }
    if ($row['phone'] === $telefono && $telefono !== '') {
        $errors['telefono'] = 'El teléfono ya está registrado';
    }
}

if (!empty(array_filter($errors))) {
    http_response_code(409);
    echo json_encode(['success' => false, 'errors' => array_filter($errors)]);
    $checkStmt->close();
    $conn->close();
    exit;
}

try {
    $stmt = $conn->prepare(
        "INSERT INTO users (full_name, email, phone, input_date)
         VALUES (?, ?, NULLIF(?, ''), NOW())"
    );
    $stmt->bind_param("sss", $nombre, $email, $telefono);
    $stmt->execute();

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
    http_response_code(500); 
    echo json_encode([
        'success' => false,
        'errors' => ['general' => 'Error al guardar los datos'],
        'details' => $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?>