<?php
// Activar error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Incluir la conexión a la DB
include '../../controller/conexion.php';

// Configurar zona horaria Bogotá
date_default_timezone_set('America/Bogota');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_number_id = (int)$_POST['user_number_id'];
    $recipient_number_id = (int)$_POST['recipient_number_id'];
    $recipient_name = trim($_POST['recipient_name']);
    $signature = $_POST['signature']; // Base64 PNG
    $authorization_letter = isset($_POST['authorization_letter']) ? $_POST['authorization_letter'] : null;
    $sede = $_SESSION['sede'] ?? ''; // Usar sede de la sesión
    $delivered_by = $_SESSION['username']; // Username de la sesión

    // Validar campos obligatorios
    if (empty($user_number_id) || empty($recipient_number_id) || empty($recipient_name) || empty($signature) || empty($delivered_by)) {
        echo json_encode(['success' => false, 'message' => 'Campos obligatorios faltantes.']);
        exit;
    }

    // Validar que recipient_name no sea 'undefined'
    if ($recipient_name === 'undefined') {
        echo json_encode(['success' => false, 'message' => 'Nombre del receptor inválido.']);
        exit;
    }

    // Manejar firma: guardar como PNG con fondo blanco
    $signaturePath = '';
    if (!empty($signature)) {
        $signatureData = str_replace('data:image/png;base64,', '', $signature);
        $signatureData = base64_decode($signatureData);
        $date = date('YmdHis');
        $signatureFileName = "firma_{$user_number_id}_{$date}.png";
        file_put_contents("../../img/firmasRegalos/{$signatureFileName}", $signatureData);
        $signaturePath = $signatureFileName; // Solo el nombre del archivo
    }

    // Manejar carta de autorización
    $letterPath = $authorization_letter;
    if ($authorization_letter !== 'N/A' && isset($_FILES['authorization_letter'])) {
        $file = $_FILES['authorization_letter'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/cartasAutorizacion/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $date = date('YmdHis');
            $letterFileName = "carta_{$user_number_id}_{$date}.pdf";
            move_uploaded_file($file['tmp_name'], "../../uploads/cartasAutorizacion/{$letterFileName}");
            $letterPath = $letterFileName; // Solo el nombre del archivo
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo PDF.']);
            exit;
        }
    }

    // Insertar en DB
    $stmt = $conn->prepare("INSERT INTO gf_gift_deliveries (user_number_id, recipient_number_id, recipient_name, signature, authorization_letter, sede, delivered_by, reception_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisssss", $user_number_id, $recipient_number_id, $recipient_name, $signaturePath, $letterPath, $sede, $delivered_by);
    if ($stmt->execute()) {
        error_log("Insert successful for user $user_number_id"); // Agrega log para verificar
        echo json_encode(['success' => true]);
    } else {
        error_log("Insert failed: " . $stmt->error); // Agrega log para verificar
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
}
?>