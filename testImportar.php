<?php
require 'vendor/autoload.php';  // Asegúrate de que la ruta sea correcta
include 'Conexion.php';  // Incluye la conexión a la base de datos
include 'autoloader.php';

// Cargar el archivo Excel
$reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load('public/test_vacaciones.xlsx');

// Obtener las hojas del archivo Excel
$hojas = $spreadsheet->getAllSheets();

$hoja3 = [];

// Iterar sobre cada hoja
foreach ($hojas as $key => $hoja) {

    if($key == 2)
    {
        $filas = $hoja->toArray();

        foreach ($filas as $key => $fila) 
        {  
            $count = count($fila);
            break;
        }

        //TOMO LAS COLUMNAS
       
        for ($i = 0; $i < $count; $i++)
        {
            $columnas = [];
            foreach ($filas as $key_fila => $fila) $columnas[] = $fila[$i];
            $hoja3[] = $columnas;
        }
    
    }
}

foreach($hoja3 as $key => $value)
{ 
    if($key > 26 || $key == 0) unset($hoja3[$key]);  
}


foreach($hoja3 as $key => $value)
{
    foreach($value as $key2 => $value2)
    {
        if($key2 != 'nom' && $value2 != null) $hoja3[$key][$key2] = date('Y-m-d', strtotime($value2));
    }    
}


foreach($hoja3 as $key => $value)
{
    foreach($value as $key2 => $value2)
    {
        if($key2 == 0) {
            $hoja3[$key]['nom'] = $value2;
            unset($hoja3[$key][$key2]);
        }
        if($value2 == null) unset($hoja3[$key][$key2]);
    }
}


// Función para buscar el id_empleat
function buscarIdEmpleat($nombre)
{
    // Separar el nombre completo en partes
    $partes_nombre = explode(" ", $nombre);

    // Construir la consulta SQL
    $sql = "SELECT idempleat, nom, cognom1
            FROM empleat 
            WHERE nom LIKE '%" .$partes_nombre[0] ."%'";    

    // Ejecutar la consulta
    $dto = new AdminApiImpl();
    $result = $dto->getDb()->executarConsulta($sql);

    $result_finish = [];
    foreach($result as $value) $result_finish[] = ['id_empleat' => $value['idempleat'], 'nom' => $value['nom'] .' ' .$value['cognom1']];
    
    return $result_finish;
}

foreach($hoja3 as $key => $value)
{    
    $array_opciones = buscarIdEmpleat($value['nom']);

    if(!empty($array_opciones)) $hoja3[$key]['id_empleat'] = $array_opciones[0]['id_empleat'];
   
    if($key == 4) $hoja3[$key]['id_empleat'] = $array_opciones[1]['id_empleat'];

    if($key == 10) $hoja3[$key]['id_empleat'] = $array_opciones[1]['id_empleat'];

    if($key == 12) $hoja3[$key]['id_empleat'] = $array_opciones[1]['id_empleat'];

    if($key == 20) $hoja3[$key]['id_empleat'] = $array_opciones[4]['id_empleat'];

    // key 15 J. SANTIAGO TERCEROS CHUMACERO 
    //key 18 Mª MAR MILLET VILANOVA 
   // key 21 MARIZA PEDRAZA FUENTES
    // key 23 MAYTE GUIRAO ZAERA
    // key 24 MONTSERRAT LIEBANES CHICA
}

// Recorrer el array de empleados y sus vacaciones
foreach ($hoja3 as $key => $empleado) {
    
    if($key != 15 && $key != 18 && $key != 21 && $key != 23 && $key != 24)
    {
        $nom = $empleado['nom'];
        $id_empleat = $empleado['id_empleat'];
        
        // Recorrer las fechas de vacaciones del empleado en grupos de 2
        for ($i = 1; $i < count($empleado) - 2; $i += 2) {
            $inicio_vac = $empleado[$i];
            $fin_vac = $empleado[$i + 1];
          
            $insert = "INSERT INTO excepcio(idempleat, idtipusexcep, datainici, datafinal)
                        VALUES($id_empleat, 2, '$inicio_vac', '$fin_vac')";

            $dto = new AdminApiImpl();
            $dto->getDb()->executarSentencia($insert);
			
        }

    }
        
}

?>