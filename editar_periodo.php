<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$color = $_POST['color'];
$horaElectiva = isset($_POST['hora_electiva']) ? 1 : 0;
$documento =  isset($_POST['documento']) ? 1 : 0;

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

// Obtener los valores RGB del color seleccionado
list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");


// Preparar y ejecutar la consulta de actualización
$stmt = $conn->prepare("UPDATE tipusexcep SET nom = ?, r = ?, g = ?, b = ?, HorElectiv = ?, requereixFitxer = ? WHERE idtipusexcep = ?");
$stmt->bind_param("ssssiii", $nombre, $r, $g, $b, $horaElectiva, $documento, $id);



// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    // Redireccionar a la página deseada después de la actualización
    header("Location: adminEmpresa.php");
    exit; // Asegurar que el código se detenga después de la redirección
} else {
    echo "Error al actualizar el período: " . $stmt->error;
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conn->close();
?>
