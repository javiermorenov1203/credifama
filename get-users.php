<?php
header('Content-Type: application/json; charset=utf-8');
require_once('db.php');

try {
    $sql = "SELECT * FROM users ORDER BY input_date DESC";
    $result = $conn->query($sql);

    $users = [];
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            "id" => $row["id"],
            "nombre" => $row["full_name"],
            "email" => $row["email"],
            "telefono" => $row["phone"],
            "fecha_ingreso" => $row["input_date"],
        ];
    }
    http_response_code(200);
    echo json_encode(['message' => 'Datos obtenidos correctamente', 'users' => $users]);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ha ocurrido un erorr al obtener los datos', 'details' => $e->getMessage()]);
}






$conn->close();
?>