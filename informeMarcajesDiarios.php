<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    include './Pantalles/HeadGeneric.html';
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $dto->navResolver();
    include 'Conexion.php';

    $lng = 0;
    $idempresa = $_SESSION["idempresa"];

    if (!isset($_GET["idsubemp"])) {

        if (isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
        else if (isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
        else$_GET["idsubemp"] = "Totes";

    }

    if(isset($_GET["any"])) $any = $_GET["any"];
    if(isset($_GET["mes"])) $mes = $_GET["mes"];
    if(isset($_GET["dpt"])) $dpt = $_GET["dpt"];

    $idsubemp = $_GET["idsubemp"];
    $_SESSION["filtidsubempq"] = $idsubemp;
    $d = strtotime("now");


    //ABSENTISMOS
    if (isset($_POST["tipusexcep"])) $tipusexcep = $_POST["tipusexcep"];
    else $tipusexcep = 'Tots';

    //EMPLEADOS
    $empleats = $dto->getIdEmployees($idsubemp);


    // Establecer la conexión a la base de datos
    if (!$conn) die("Error de conexión: " . mysqli_connect_error());

    // Variables para el filtrado por fechas
    $fechaInicial = "";
    $fechaFinal = "";
    $idSubempresa = "";

    // Verificar si se recibieron los valores de fecha
    if (isset($_POST['fecha_inicial']) && isset($_POST['fecha_final']) && isset($_GET['idsubemp'])) {
        $fechaInicial = $_POST['fecha_inicial'];
        $fechaFinal = $_POST['fecha_final'];
        $idSubempresa = $_GET['idsubemp'];

// Ajustar la fecha final para incluir todo el día
		$fechaFinal_aux = $fechaFinal;
     $fechaFinal=date('Y-m-d', strtotime($fechaFinal . ' +1 day'));
    }

    // CREAR INTERVALO DE FECHAS ENTRE LAS FECHAS INICIALES Y FINALES
    $current_date = strtotime($fechaInicial);
    $end_date_timestamp = strtotime($fechaFinal);
    $interval_date = [];
    if ($fechaInicial !== $fechaFinal) {
        while ($current_date <= $end_date_timestamp) {
            $interval_date[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }
    } else {
        $interval_date[] = $fechaInicial;
    }

    $empleats_date = [];

    foreach ($empleats as $empleat) {
        foreach ($interval_date as $date) {

            if($date != $fechaFinal) $empleats_date[] = [
                'idempleat' => $empleat['idempleat'],
                'numafiliacio' => $empleat['numafiliacio'],
                'nom' => $empleat['nom'] . ' ' . $empleat['cognom1'],
                'date' => $date,
                'entrada1' => "",
                'salida1' => "",
                'entrada2' => "",
                'salida2' => "",
                'entrada3' => "",
                'salida3' => "",
                'horasTrabajadas' => "",
                'horasTeoricas'  => "",
                'ausencia' => "",
                'observaciones' => ""
            ];
        }
    }

    function calcularTotalHoras($entrada1, $salida1, $entrada2, $salida2, $entrada3, $salida3)
    {
// Inicializar el total de segundos en 0
        $totalSegundos = 0;

// Calcular la diferencia en segundos para cada entrada con salida correspondiente
        if ($entrada1 && $salida1) {
            $entrada1_segundos = strtotime($entrada1);
            $salida1_segundos = strtotime($salida1);
            $totalSegundos += $salida1_segundos - $entrada1_segundos;
        }

        if ($entrada2 && $salida2) {
            $entrada2_segundos = strtotime($entrada2);
            $salida2_segundos = strtotime($salida2);
            $totalSegundos += $salida2_segundos - $entrada2_segundos;
        }

        if ($entrada3 && $salida3) {
            $entrada3_segundos = strtotime($entrada3);
            $salida3_segundos = strtotime($salida3);
            $totalSegundos += $salida3_segundos - $entrada3_segundos;
        }

// Calcular el total de horas y minutos
        $totalHoras = floor($totalSegundos / 3600);
        $totalMinutos = floor(($totalSegundos % 3600) / 60);

// Formatear el total de horas y minutos
        $totalFormato = sprintf("%02d:%02d", $totalHoras, $totalMinutos);

// Devolver el total de horas y minutos trabajados
        return $totalFormato;
    }

    function restaHoras($hora1, $hora2) {

        $hora1 = $hora1 ? $hora1 : '00:00';
        $hora2 = $hora2 ? $hora2 : '00:00';

        $hora1 = new DateTime($hora1);
        $hora2 = new DateTime($hora2);

        $interval = $hora1->diff($hora2);

        $difference = $interval->format('%H:%I');

        //PASAR A NEGATIVO DIFFERENCE CUANDO HORA1 SEA MENOR A HORA2
        if($hora1 < $hora2) $difference = '-' . $difference;

        return $difference;
    }



    $sql = "SELECT e.numafiliacio, e.idempleat, e.nom, e.cognom1, e.cognom2,
    DATE(t1.datahora) AS fecha,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 1 THEN t1.datahora END)) AS entrada1,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 1 THEN t1.datahora END)) AS salida1,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 2 THEN t1.datahora END)) AS entrada2,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 2 THEN t1.datahora END)) AS salida2,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 3 THEN t1.datahora END)) AS entrada3,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 3 THEN t1.datahora END)) AS salida3,
    GROUP_CONCAT(DISTINCT t1.observacions SEPARATOR ' / ') AS observacions,
    ttt.horestreball AS horas_teoricas
FROM (
    SELECT e.idempleat,
        m.datahora,
        m.entsort,
        m.observacions,
        ROW_NUMBER() OVER (PARTITION BY e.idempleat, DATE(m.datahora), m.entsort ORDER BY m.datahora) AS row_number
    FROM empleat AS e
    LEFT JOIN marcatges AS m ON e.idempleat = m.id_emp
    WHERE m.datahora >= '$fechaInicial' AND m.datahora <= '$fechaFinal'";

    // Si se selecciona "Totes", no filtramos por subempresa
    if ($idSubempresa != "Totes") $sql .= " AND e.idsubempresa = '$idSubempresa'";

    $sql .= ") AS t1
LEFT JOIN empleat AS e ON t1.idempleat = e.idempleat
LEFT JOIN quadrant AS q ON e.idempleat = q.idempleat
         LEFT JOIN horaris AS h ON q.idhorari = h.idhoraris
         LEFT JOIN torn AS ttt ON ttt.idhorari = h.idhoraris
GROUP BY t1.idempleat, DATE(t1.datahora) ORDER BY e.numafiliacio";

    $result = mysqli_query($conn, $sql);

    if (!$result) die("Error en la consulta: " . mysqli_error($conn));

    if ($tipusexcep != 'id_solomarcajes')
    {
        //ASIGNACION DE LOS MARCAJES DE TODOS LOS EMPLEADOS DEPENDIENDO DE LA FECHAS INDICADAS
        while ($row = mysqli_fetch_assoc($result)) {

            foreach ($empleats_date as $key => $empleat_date) {
                if ($empleat_date['idempleat'] == $row['idempleat'] && $empleat_date['date'] == $row['fecha'] && $row['fecha'] != $fechaFinal) {

                    $empleats_date[$key]['numafiliacio'] = $row['numafiliacio'];
                    $empleats_date[$key]['nom'] = $row['nom'] . ' ' . $row['cognom1'];
                    $empleats_date[$key]['date'] = $row['fecha'];
                    $empleats_date[$key]['entrada1'] = $row['entrada1'];
                    $empleats_date[$key]['salida1'] = $row['salida1'];
                    $empleats_date[$key]['entrada2'] = $row['entrada2'];
                    $empleats_date[$key]['salida2'] = $row['salida2'];
                    $empleats_date[$key]['entrada3'] = $row['entrada3'];
                    $empleats_date[$key]['salida3'] = $row['salida3'];
                    $empleats_date[$key]['horasTrabajadas'] = calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'], $row['entrada3'], $row['salida3']);
                    $empleats_date[$key]['horasTeoricas'] = $row['horas_teoricas'];
                    $empleats_date[$key]['ausencia'] = "";
                    $empleats_date[$key]['observaciones'] = $row['observacions'];
					
					
                }
            }
        }
    }


    $ausencias = [];
    //SI EL EMPLEAT NO TIENE  MARCAJES EN LA FECHA INDICADA, SE LE ASIGNA AUSENTE
    foreach ($empleats_date as $key => $empleat_date) {
        if ($empleat_date['entrada1'] == null &&  $empleat_date['salida1'] == null && $empleat_date['entrada2'] == null && $empleat_date['salida2'] == null && $empleat_date['entrada3'] == null && $empleat_date['salida3'] == null) {
           
            $empleats_date[$key]['ausencia'] = "Ausente";
          

            //PERSONAS AUSENTES POR DIA
            $key_ausencia = $empleat_date['date'];
           
            if (isset( $ausencias[$key_ausencia]   ) &&   $empleats_date[$key]['entrada1'] == "") $ausencias[ $key_ausencia ] =   $ausencias[ $key_ausencia ] + 1;
            if (!isset( $ausencias[$key_ausencia] )) $ausencias[ $key_ausencia ] = 1;
   
        }
    }


    ?>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 150%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 3px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
            margin-left: 30px;
        }

        input[type="date"] {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 8px 12px;
            margin-left: 10px;
            border: none;
            background-color: #4caf50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        a.button {
            display: inline-block;
            padding: 8px 12px;
            border: none;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #2980b9;
        }



        .btn-green {
            position: relative; /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color:rgb(0,205,0,0.7) ; /* Fondo transparente */
            color: white; /* Texto transparente */
            border:2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease; /* Animación suave en todos los cambios */
        }

        .btn-green .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px; /* Tamaño de la flecha */
            color: #007bff; /* Color de la flecha antes del hover */
            transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
        }

        .btn-green .btn-text {
            position: relative;
            z-index: 1; /* Coloca el texto del botón sobre la flecha */
        }

        .btn-green:hover {
            background-color: #00cd00; /* Cambia el color de fondo durante el hover */
            color: #fff; /* Cambia el color del texto durante el hover */
            transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12 well">

            <div class="col-lg-3 m-0 p-0"><h3><?php echo $dto->__($lng, "Informe marcajes diarios"); ?></h3></div>

            <div class="col-lg-2">
                <form method="GET" action="">
                    <div class="form-group">
                        <label><?php echo $dto->__($lng, "Subempresa"); ?>:</label>
                        <select name="idsubemp" onchange="this.form.submit();" style="width: 150px; height: 35px;">
                            <?php
                            echo '<option hidden selected value="' . $idsubemp . '">';

                            if ($idsubemp == "Totes") echo $dto->__($lng, $idsubemp);
                            else echo $dto->mostraNomSubempresa($idsubemp);

                            echo '</option><option value="Totes">' . $dto->__($lng, "Totes") . '</option>';
                            $resemp = $dto->mostraSubempreses($idempresa);
                            foreach ($resemp as $emp) echo '<option value="' . $emp["idsubempresa"] . '">' . $emp["nom"] . '</option>';
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                </form>

            </div>

            <div class="col-lg-7">
                <!-- Formulario para el filtrado de fechas -->
                <form method="POST" action="">
                    <div class="form-group" style="margin-right: 30px;">
                        <label for="absentismo">Tipo:</label>
                        <select id="absentismo" name="tipusexcep" style="width: 150px; height: 35px;">
                            <?php
                            $options = [
                                ['id' => 'Tots', 'nom' => 'Todos'],
                                ['id' => 'id_solomarcajes', 'nom' => 'Solo marcajes'],
                                ['id' => 'id_ausencia', 'nom' => 'Ausencia'],
                            ];
                            foreach ($options as $option) echo '<option value="' . $option['id'] . '" ' . (($tipusexcep == $option['id']) ? "selected" : "") . '>' . $option['nom'] . '</option>';
                            ?>
                        </select>
                    </div>

                    <div class="form-group" style="margin-right: 30px;">
                        <label for="fecha_inicial">Fecha inicial:</label>
                        <input type="date" id="fecha_inicial" name="fecha_inicial" value="<?php echo $fechaInicial; ?>" required>
                    </div>

                    <div class="form-group" style="margin-right: 30px;">
                        <label for="fecha_final">Fecha final:</label>
                        <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $fechaFinal_aux; ?>" required>
                    </div>

                    <button type="submit" style="height: 40px; margin-top: 23px;">Filtrar</button>

                </form>

            </div>

            <!-- Botón de exportar Informe-->
            <a class="btn-green" href="exportar.php?fecha_inicial=<?php echo $fechaInicial; ?>&fecha_final=<?php echo $fechaFinal; ?>&idsubemp=<?php echo $idsubemp; ?>">Exportar a Excel</a>
        </div>


        <center>
            <?php
			
				 if($fechaFinal!= ""){
                                $fechaObj = new DateTime($fechaFinal);

                                // Restar 1 día para que no me entregue los resultados de 2 dias
                                    $fechaObj->modify('-1 day');
                        
                                    // Obtener la nueva fecha
                                        $fechaFinal = $fechaObj->format('Y-m-d');
                            }
			
            $exception_days = $dto->summarySpecialPeriods($fechaFinal, $fechaInicial, $idsubemp);
            if ($tipusexcep != 'id_ausencia')
            {
                foreach ($exception_days as $exception_day)
                {
                    echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Personas de ' .$exception_day['type_excepcio']).' ' .' Total: '.$exception_day['count_days'].'</label>';
                }
            } else {

                 //LOS DE EXCEPCION QUE LLEGAN A LAS OBSERVACIONES TIENEN QUE SER LOS MISMOS DE SUMA DE PERIODOS ESPECIALES.
                //ASI QUE CREAMOS NUEVO ARRAY Y TOMAMOS DE SUMA PERIODOS ESPECIALES LAS EXCEPCIONES QUE APARECEN EN OBSERVACIONES

                $exception_days_ausencias = [];

                foreach ($exception_days as $key => $exception_day)
                {

                    foreach ($empleats_date as $empleat) {

                        //VERIFICO SI EL DIA ES SABADO O DOMINGO
                        $date_is_weekend = new DateTime($empleat['date']);
                        $date_is_weekend->format('w');
    
                        if ($empleat['ausencia'] != null && $date_is_weekend->format('w') != 0 && $date_is_weekend->format('w') != 6)
                        {
    
                            //BUSCAMOS EXCEPCION POR ID Y POR FECHA
                            $observation_array = $dto->exceptionByIdByDate($empleat['idempleat'], $tipusexcep, $empleat['date']);
                            $id_observation = $observation_array['idtipusexcep'];
                

                           
                                if($id_observation != null && ($exception_day['idtipusexcep'] == $id_observation) && (!array_key_exists($key, $exception_days_ausencias)) ) $exception_days_ausencias[$key] = $exception_day;
                            
                        }
    
                    }

                }
             
                foreach ($exception_days_ausencias as $exception_day)
                {
                    echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Personas de ' .$exception_day['type_excepcio']).' ' .' Total: '.$exception_day['count_days'].'</label>';
                }

            }

            if ($tipusexcep != 'id_solomarcajes') foreach ($ausencias as $key => $ausencia)
            { ;
                echo '<label><span class="glyphicon glyphicon-stop" style="color: black;"></span> '.$dto->__($lng,'Persones Ausentes ' .$key).' ' .' Total: '.$ausencia.'</label>';
            }


            ?>
            <br>
            <br>
        </center>


        <table>
            <tr>
                <th>Num. Afiliación</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Entrada 1</th>
                <th>Salida 1</th>
                <th>Entrada 2</th>
                <th>Salida 2</th>
                <th>Entrada 3</th>
                <th>Salida 3</th>
                <th>Horas trabajadas</th>
                <th>Horas teóricas</th>
                <?php if ($tipusexcep != 'id_ausencia') echo '<th>Horas extras</th>'; ?>
                <th>Ausencia</th>
                <th>Observaciones</th>
            </tr>

            <tbody>

            <?php
            // Imprimir los datos de cada empleado
            if ($fechaInicial != null || $fechaFinal != null) {
                //SOLO MARCAJES
                if ($tipusexcep == 'id_solomarcajes')
                {
                    while ($row = mysqli_fetch_assoc($result)) {

                       
                            // Calcular el total de horas trabajadas
                            $totalHoras = calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'], $row['entrada3'], $row['salida3']);

                            //PASAR A FORMATO HORAS LAS HORAS TEORICAS DEBIDO A QUE VIENE COMO UN INT O FLOAT
                            $horasTeoricas = $row['horas_teoricas'] ? $row['horas_teoricas'] : 0;
                            $horasTeoricasFormateadas = sprintf("%02d:%02d", floor($horasTeoricas), ($horasTeoricas - floor($horasTeoricas)) * 60);
                            $horasTeoricasFormateadas = $horasTeoricasFormateadas == "00:00" ? "" : $horasTeoricasFormateadas;

                            //CALCULAR HORAS EXTRAS SACANDO LA DIFERENCIA ENTRE HORAS TEORICAS Y HORAS TRABAJADAS
                            $diferenciaHoras = restaHoras($totalHoras, $horasTeoricasFormateadas);

                            // Verificar las salidas sin llenar y aplicar el estilo en rojo
                            $salida1 = !$row['salida1'] && $row['entrada1'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida1'];
                            $salida2 = !$row['salida2'] && $row['entrada2'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida2'];
                            $salida3 = !$row['salida3'] && $row['entrada3'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida3'];

                            $entrada1 = !$row['entrada1'] && $row['salida1'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada1'];
                            $entrada2 = !$row['entrada2'] && $row['salida2'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada2'];
                            $entrada3 = !$row['entrada3'] && $row['salida3'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada3'];


$salida1Aux = $salida1;
                      $salida2Aux =  $salida2;
                      $salida3Aux = $salida3;
 
                      $horasTrabajadas1=0;
                      $horasTrabajadas2=0;
                      $horasTrabajadas3 = 0;
                      //cambio de posicion las lsaidas si la primera fue antes de las 3 de la mañana
                      if($salida1 < "03:00" && $entrada1 != ""){
                        $salida3 = $salida1Aux;
                        $salida2 = $salida3Aux;
                          $salida1 = $salida2Aux;
                              if( $salida3Aux == ""){
                                  $salida2 = $salida1Aux;
                                  $salida3 = "";
                               }
 
                               //resto los intervalos de entradas y salidas siempre y cuando existan
 
                               if($entrada1 != "" &&  $salida1 != "") $horasTrabajadas1 = calcularHorasTrasnochos($entrada1 , $salida1); 
                         
                               if($entrada2 != "" &&  $salida2 != "") {  
                                  $horasTrabajadas2 = calcularHorasTrasnochos($entrada2 , $salida2); 
                                  //le sumo un dia si la hora es a la madrugada
                                  if( $horasTrabajadas2 <0 ) $horasTrabajadas2  += strtotime('tomorrow') - strtotime('today');
                                  
                                  }
 
                               if($entrada3 != "" &&  $salida3 != "") $horasTrabajadas3 = calcularHorasTrasnochos($entrada3, $salida3); 
 
 
 
                              //sumo las horas y minutos trabajados
                               $totalSumaHoras = $horasTrabajadas1 +$horasTrabajadas2 + $horasTrabajadas3;
                               $horasTotales = floor(  $totalSumaHoras / 3600);
                              $minutosTotales = floor(( $totalSumaHoras % 3600) / 60);
                              $totalHoras  =sprintf("%02d:%02d", $horasTotales, $minutosTotales);
 
 
                               //horas extras
                               $segundos_trabajados = strtotime($totalHoras) - strtotime('TODAY');
                               $segundos_teoricos = strtotime($horasTeoricasFormateadas) - strtotime('TODAY');
                               
                               $diferencia_segundos = $segundos_trabajados - $segundos_teoricos;
                               
                               $horas = floor($diferencia_segundos / 3600);
                               $minutos = floor(($diferencia_segundos % 3600) / 60);
                              
                               
                               $horasExtras = sprintf('%02d:%02d', $horas, $minutos);
                               if( $horasExtras <0 )  $horasExtras ="00:00";
                          
                          
                  }
                     
                      
                                  if($entrada1 > "15:00" && $salida1 =="" && $entrada2 == ""){
                                      $salida1= $salida2;
                                      $salida2 = "";
                                      
                                      
                                      
                                      //trabajadas
                              $horasTrabajadas4 = calcularHorasTrasnochos($entrada1 , $salida1); 
                                   if( $horasTrabajadas4 <0 ) $horasTrabajadas4  += strtotime('tomorrow') - strtotime('today');
                               $horasTotales = floor(  $horasTrabajadas4 / 3600);
                              $minutosTotales = floor(( $horasTrabajadas4 % 3600) / 60);
                                      
                                      
                              $totalHoras  =sprintf("%02d:%02d", $horasTotales, $minutosTotales);
                                      
                                      
                                      
                                      
                                      
                                       //horas extras
                               $segundos_trabajados = strtotime($totalHoras) - strtotime('TODAY');
                               $segundos_teoricos = strtotime($horasTeoricasFormateadas) - strtotime('TODAY');
                               
                               $diferencia_segundos = $segundos_trabajados - $segundos_teoricos;
                               
                               $horas = floor($diferencia_segundos / 3600);
                               $minutos = floor(($diferencia_segundos % 3600) / 60);
                              
                               
                               $horasExtras = sprintf('%02d:%02d', $horas, $minutos);
                               if( $horasExtras <0 )  $horasExtras ="00:00";
                                  
                                      
                                  }



                            echo "<tr>";

                            echo "<td>" . $row['numafiliacio'] . "</td>";
                            echo "<td>" . $row['nom'] . ' ' . $row['cognom1'] . ' ' . "</td>";
                            echo "<td>" . $row['fecha'] . "</td>";

                            echo "<td>" . $entrada1 . "</td>";
                            echo "<td>" . $salida1 . "</td>";
                            echo "<td>" . $entrada2 . "</td>";
                            echo "<td>" . $salida2 . "</td>";
                            echo "<td>" . $entrada3 . "</td>";
                            echo "<td>" . $salida3 . "</td>";

                            echo "<td>" . $totalHoras . "</td>";
                            echo "<td>" . $horasTeoricasFormateadas . "</td>";
                            echo "<td>" . $diferenciaHoras . "</td>";
                            echo "<td>" . $row['observacions'] . "</td>";
                            echo "</tr>";
                        


                    }
                }
                //TODOS NO ABSENTISMO
                if ($tipusexcep == 'Tots')
                {
                    foreach ($empleats_date as $empleat) {


                        //VERIFICO SI EL DIA ES SABADO O DOMINGO
                        $date_is_weekend = new DateTime($empleat['date']);
                        $date_is_weekend->format('w');

                        if ($date_is_weekend->format('w') != 0 && $date_is_weekend->format('w') != 6)
                        {


                            $observation_array = $dto->exceptionByIdByDate($empleat['idempleat'], $tipusexcep, $empleat['date']);
                            $observation = $observation_array['nom'];


                            $horasTeoricas = $empleat['horasTeoricas'] ? $empleat['horasTeoricas'] : 0;
                            $horasTeoricasFormateadas = sprintf("%02d:%02d", floor($horasTeoricas), ($horasTeoricas - floor($horasTeoricas)) * 60);
                            $horasTeoricasFormateadas = $horasTeoricasFormateadas == "00:00" ? "" : $horasTeoricasFormateadas;
                            $diferenciaHoras = restaHoras($empleat['horasTrabajadas'], $horasTeoricasFormateadas);
                            $horasExtras = ($diferenciaHoras == "00:00") ? "" : $diferenciaHoras;


                            $observation_finish = ($empleat['observaciones']) ? $empleat['observaciones'] : $observation;

                            echo "<tr>";
                            echo "<td>" . $empleat['numafiliacio'] . "</td>";
                            echo "<td>" . $empleat['nom'] . "</td>";
                            echo "<td>" . $empleat['date'] . "</td>";
                            echo "<td>" . $empleat['entrada1'] . "</td>";
                            echo "<td>" . $empleat['salida1'] . "</td>";
                            echo "<td>" . $empleat['entrada2'] . "</td>";
                            echo "<td>" . $empleat['salida2'] . "</td>";
                            echo "<td>" . $empleat['entrada3'] . "</td>";
                            echo "<td>" . $empleat['salida3'] . "</td>";
                            echo "<td>" . $empleat['horasTrabajadas'] . "</td>";
                            echo "<td>" . $horasTeoricasFormateadas . "</td>";
                            echo "<td>" . $horasExtras . "</td>";
                             if($empleat['entrada1'] == "" &&  $empleat['salida1'] == "") echo "<td style='color: red'>" . $empleat['ausencia'] . "</td>";
                            else  echo "<td>" . "". "</td>";
							
							 $tipusexcep1 = "";
                            $rse = $dto->esExcepcioPerIdDia($empleat['idempleat'],$empleat['date'] );
							  if(!empty($rse)) {
                                foreach($rse as $e){$tipusexcep1 = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusexcep",$e["idtipusexcep"],"nom"));}
                               
                                echo '<td>'.$tipusexcep1.'</td>';
                                
                            }  else {
                                echo "<td>" . $observation_finish . "</td>";
                            }

							
                            echo "</tr>";
                        }

                    }
                }

                //PARA AUSENCIA
                if ($tipusexcep == 'id_ausencia')
                {
                    foreach ($empleats_date as $empleat) {

                        //VERIFICO SI EL DIA ES SABADO O DOMINGO
                        $date_is_weekend = new DateTime($empleat['date']);
                        $date_is_weekend->format('w');

                        if ($empleat['ausencia'] != null && $date_is_weekend->format('w') != 0 && $date_is_weekend->format('w') != 6)
                        {
                           //BUSCAMOS EXCEPCION POR ID Y POR FECHA
                           $observation_array = $dto->exceptionByIdByDate($empleat['idempleat'], $tipusexcep, $empleat['date']);
                           $observation = $observation_array['nom'];

							$observation_finish = ($empleat['observaciones']) ? $empleat['observaciones'] : $observation;



                            if ($observation != null)
                            {
                                echo "<tr>";
                                echo "<td>" . $empleat['numafiliacio'] . "</td>";
                                echo "<td>" . $empleat['nom'] . "</td>";
                                echo "<td>" . $empleat['date'] . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>" . $empleat['horasTeoricas'] . "</td>";
                                echo "<td style='color: red;'>Ausente</td>";
                                echo "<td>" . $observation_finish  . "</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr>";
                                echo "<td>" . $empleat['numafiliacio'] . "</td>";
                                echo "<td>" . $empleat['nom'] . "</td>";
                                echo "<td>" . $empleat['date'] . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>" . $empleat['horasTeoricas'] . "</td>";
                                echo "<td style='color: red;'>Ausente</td>";
                                echo "<td>" . $observation_finish  . "</td>";
                                echo "</tr>";
                            }

                        }

                    }
                }

            }
            // Cerrar la conexión a la base de datos
            mysqli_close($conn);
            ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>
