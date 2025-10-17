<?php
// Activar error reporting para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../vendor/autoload.php'; // Incluir PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

// Incluir la conexión a la DB desde conexion.php
include '../../controller/conexion.php'; // Ajusta la ruta si es necesario

// Procesar el archivo si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];
    if (!empty($file)) {
        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Saltar la primera fila si es encabezado
            array_shift($rows);

            $successCount = 0;
            $errors = [];

            foreach ($rows as $row) {
                // Mapear columnas con validación para evitar errores si no existen
                $number_id = (int)$row[0]; // A
                $name = strtoupper(trim($row[1])); // B - Convertir a UPPER
                $company_name = trim($row[2]); // C
                $cell_phone = trim($row[3]); // D
                $email = trim($row[4]); // E
                $address = trim($row[5]); // F
                $city = trim($row[6]); // G
                $registration_date = date('Y-m-d', strtotime($row[7])); // H
                $gender_raw = trim($row[8]); // I
                $gender = ($gender_raw === 'F') ? 'Mujer' : (($gender_raw === 'M') ? 'Hombre' : 'Otro');
                $data_update = isset($row[9]) ? strtoupper(trim($row[9])) : ''; // J - Convertir a UPPER (SI/NO), con validación
                $updated_by = isset($row[10]) ? trim($row[10]) : ''; // K - Si vacío o no existe, ''

                // Validar campos obligatorios
                if (empty($number_id) || empty($name) || empty($gender)) {
                    $errors[] = "Fila inválida: number_id, name o gender faltante.";
                    continue;
                }

                // Insertar o actualizar en DB
                $stmt = $conn->prepare("INSERT INTO gf_users (number_id, name, company_name, cell_phone, email, address, city, registration_date, gender, data_update, updated_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name=VALUES(name), company_name=VALUES(company_name), cell_phone=VALUES(cell_phone), email=VALUES(email), address=VALUES(address), city=VALUES(city), registration_date=VALUES(registration_date), gender=VALUES(gender), data_update=VALUES(data_update), updated_by=VALUES(updated_by)");
                $stmt->bind_param("issssssssss", $number_id, $name, $company_name, $cell_phone, $email, $address, $city, $registration_date, $gender, $data_update, $updated_by);
                if ($stmt->execute()) {
                    $successCount++;
                } else {
                    $errors[] = "Error al insertar/actualizar: " . $stmt->error;
                }
                $stmt->close();
            }

            // Respuesta JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => "Importación completada. Registros insertados/actualizados: $successCount. Errores: " . count($errors),
                'errors' => $errors
            ]);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al procesar el archivo: ' . $e->getMessage()]);
            exit;
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'No se seleccionó un archivo.']);
        exit;
    }
}
// No cerrar $conn aquí, ya que es manejado en conexion.php si es necesario
?>