<?php
// Activar error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la DB
include '../../controller/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number_id = (int)$_POST['number_id'];
    $original_number_id = (int)$_POST['original_number_id'];
    $name = strtoupper(trim($_POST['name']));
    $company_name = trim($_POST['company_name']);
    $cell_phone = trim($_POST['cell_phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $registration_date = $_POST['registration_date'];
    $gender = trim($_POST['gender']);
    $data_update = strtoupper(trim($_POST['data_update']));
    $updated_by = trim($_POST['updated_by']);

    if (empty($original_number_id) || empty($name) || empty($gender)) {
        echo json_encode(['success' => false, 'message' => 'Campos obligatorios faltantes.']);
        exit;
    }

    // Actualizar en DB usando original_number_id para WHERE
    $stmt = $conn->prepare("UPDATE gf_users SET number_id=?, name=?, company_name=?, cell_phone=?, email=?, address=?, city=?, registration_date=?, gender=?, data_update=?, updated_by=? WHERE number_id=?");
    $stmt->bind_param("issssssssssi", $number_id, $name, $company_name, $cell_phone, $email, $address, $city, $registration_date, $gender, $data_update, $updated_by, $original_number_id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el registro para actualizar o no hubo cambios.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
}
?>