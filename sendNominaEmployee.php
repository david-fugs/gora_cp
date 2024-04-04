<?php
include 'Conexion.php';

session_start(); 

include 'autoloader.php';
$dto = new AdminApiImpl();

$idempresa = $_SESSION["idempresa"];

$id = $_SESSION["id"];

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if(isset($_POST["objetos"]))
  {
    $archivos = $_POST["objetos"];
    foreach($archivos as $archivo)
    {
      $send = isset($_POST["sendMail"]) ? 1 : 0;
      $dto->cargarNomina($archivo['idempleat'],$archivo['mes'],$archivo['any'],$archivo['nombre_archivo'],$archivo['ruta'],$send);
      $mes = $archivo['mes'];
      $any = $archivo['any'];
    }
  }

  $idsubempresa = $_POST["idsubempresa"];
  if($idsubempresa === "") $idsubempresa = 'Totes';

  //ENVIO DE MAIL
  $checkboxMarcado = isset($_POST["sendMail"]) ? true : false;
  if ($checkboxMarcado)  $dto->sendMailNomina($idsubempresa, $mes, $any);

  //RESPONSE PARA ADMIN PERSONES PARA MONSTRAR MENSAJE EXITO CARGA O ERROR CARGA
  $_SESSION['asignacionNominas'] = ['mensaje' => 'Asiganacion Completa de las Nominas'];

  // Redireccionar a la página anterior
  $pagina_anterior = $_SERVER['HTTP_REFERER'];
  header("Location: $pagina_anterior");
  exit;
} else {
  echo "Acceso denegado";
}
?>
