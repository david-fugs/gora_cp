<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$color = $_POST['color'];
$horaElectiva = isset($_POST['hora_electiva']) ? 1 : 0;
$documento= isset($_POST['documento']) ? 1 : 0;

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

$global = 1;

// Obtener los valores RGB del color seleccionado
list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");


// Preparar y ejecutar la consulta de inserción
 $stmt = $conn->prepare("INSERT INTO tipusexcep (nom, r, g, b, HorElectiv, global, requereixFitxer) VALUES (?, ?, ?, ?, ?, ?, ?)");
 $stmt->bind_param("ssssiii", $nombre, $r, $g, $b, $horaElectiva, $global, $documento);


// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    header("Location: AdminEmpresa.php");
    exit;
} else {
    echo "Error al crear el período: " . $stmt->error;
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conn->close();
?>
