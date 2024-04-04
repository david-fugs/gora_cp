<?php
include 'Conexion.php';
session_start();
include 'autoloader.php';
$dto = new AdminApiImpl();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $idempresa = $_POST["idempresa"];
    $dto->updateMailCompany($correo, $idempresa);
}
?>
