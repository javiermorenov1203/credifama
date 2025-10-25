<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Preparar la consulta segura (sentencia preparada)
$stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, input_date) VALUES (?, ?, ?, NOW())");

// Verificar que la preparación fue exitosa
if (!$stmt) {
    die("❌ Error al preparar la consulta: " . $conn->error);
}

// Vincular parámetros: s = string
$stmt->bind_param("sss", $nombre, $email, $telefono);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "✅ Datos guardados correctamente";
} else {
    echo "❌ Error al guardar: " . $stmt->error;
}

// Cerrar la sentencia y la conexión
$stmt->close();
$conn->close();
?>
