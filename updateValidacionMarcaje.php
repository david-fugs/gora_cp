
<?php
include 'Conexion.php';

session_start();

include 'autoloader.php';
$dto = new AdminApiImpl();

$idempresa = $_SESSION["idempresa"];
$id = $_SESSION["id"];

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Obtener los datos enviados por AJAX
    $validacion = 1;
    $id = $_GET["id"];
    $mes = $_GET["mes"];
    $any = $_GET["any"];

    
    $sql = "INSERT INTO validaciones_marcajes (id_emp, validacion, mes, any, datareg) VALUES ($id, $validacion, $mes, $any, now())";
    $dto->getDb()->executarSentencia($sql);
    
    $id_validacionmarc = 0;

    $sql = "SELECT * FROM marcatges WHERE MONTH(datahora) = $mes AND id_emp = $id";
    $marcatges = $dto->getDb()->executarConsulta($sql);


    //GUARDO LOS MARCAJES EN MARCAJES VALIDADOS
    foreach ($marcatges as $marcaje) {
        $sql = "INSERT INTO marcajes_validados (
            id_validacionmarc, 
            id_emp, 
            id_marc, 
            id_tipus,
            idactivitat,
            entsort,
            datahora,
            datareg
        ) VALUES (
            '$id_validacionmarc',
            '$id',
            '{$marcaje["idmarcatges"]}',
            '{$marcaje["id_tipus"]}',
            '{$marcaje["idactivitat"]}',
            '{$marcaje["entsort"]}',
            '{$marcaje["datahora"]}',
            NOW()
        )";

        $dto->getDb()->executarSentencia($sql);
    }



    print_r($marcatges);

} else {
    echo json_encode(['status'=>'BAD REQUEST METHOD']);
}
?>
