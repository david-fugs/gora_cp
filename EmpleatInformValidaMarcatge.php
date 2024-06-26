

<!DOCTYPE html>
<html>

<head>
    <?php include './Pantalles/HeadGeneric.html'; ?>

    <script type="text/javascript">
        function GeneraPDF() {
            var doc = new jsPDF('p', 'pt', 'letter');
            doc.fromHTML($('#contingut').html());
            doc.save('Informe.pdf');
        }
    </script>

</head>

<body>

<?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    session_start();
    include 'Conexion.php';
    $idemp = $_SESSION["idempresa"];
    $idempresa = $idemp;
    $lng = 2;
    //if (isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $any = intval($_GET['any']);
    $mes = intval($_GET['mes']);
    $taulaemp = 'empresa';
    $id = intval($_GET['id']);
    $idsubemp = $dto->getCampPerIdCampTaula("empleat", $id, "idsubempresa");
    if (!empty($idsubemp)) {
        $idemp = $idsubemp;
        $taulaemp = 'subempresa';
    }
    $nomemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "nom");
    $cifemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "cif");
    $ctremp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "centre_treball");
    $cccemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "ccc");
    $pobemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "poblacio");
    $id = intval($_GET['id']); 
    $idtreballadorsemp = array(array('id_emp' => $id));

    $zmes = $mes;
    if($mes<10) $zmes = "0".$mes;
    $datafi = date('Y-m-d',strtotime($any."-".$zmes."-01"));
    while(date('m',strtotime($datafi))==$zmes) {$datafi = date('Y-m-d',strtotime($datafi." + 1 days"));}
    $diafi = date('d', strtotime($datafi . " - 1 days"));

    $teorique_hours = $dto->seeHourTeorique($id, $any, $mes);
?>



<center>
      
    
        
        <div style="display: flex; align-items: center; justify-content: center; margin: 0;">
            <?php
            if (isset($_GET['any']) && isset($_GET['mes'])) {
                $any = mysqli_real_escape_string($conn, $_GET['any']);
                $mes = mysqli_real_escape_string($conn, $_GET['mes']);


                // Construye la consulta SQL con los valores del formulario
                $sql = "
                    SELECT e.idempleat, e.nom, e.cognom1, e.cognom2,
                        DATE(t1.datahora) AS fecha,
                        TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 1 THEN t1.datahora END)) AS entrada1,
                        TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 1 THEN t1.datahora END)) AS salida1,
                        TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 2 THEN t1.datahora END)) AS entrada2,
                        TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 2 THEN t1.datahora END)) AS salida2,
                        GROUP_CONCAT(DISTINCT t1.observacions SEPARATOR ' / ') AS observacions
                    FROM (
                        SELECT m.id_emp, m.datahora, m.entsort, m.observacions,
                        ROW_NUMBER() OVER (
                            PARTITION BY m.id_emp, 
                            DATE(m.datahora), 
                            m.entsort 
                            ORDER BY m.datahora
                            ) AS row_number
                        FROM marcajes_validados AS m
                        WHERE YEAR(m.datahora) = '$any' AND MONTH(m.datahora) = '$mes' 
                        ) AS t1
                    LEFT JOIN empleat AS e ON t1.id_emp = e.idempleat
                    GROUP BY t1.id_emp, DATE(t1.datahora)";

                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conn));
                }
                mysqli_close($conn);

            }

            function calcularTotalHoras($entrada1, $salida1, $entrada2, $salida2,$id,$fecha) {
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



                // Calcular el total de horas y minutos
                $totalHoras = floor($totalSegundos / 3600);
                $totalMinutos = floor(($totalSegundos % 3600) / 60);

                // Formatear el total de horas y minutos
                $totalFormato = sprintf("%02d:%02d", $totalHoras, $totalMinutos);
                //print_r($totalFormato);


                /* The above code is checking if the variable  is empty and if it is, it will print " */


                if (isset($totalHoras, $totalMinutos)) {
                    $data = [
                        'horas' => $totalHoras,
                        'minutos' => $totalMinutos,
                        'totalFormato' => $totalFormato
                    ];
					
					
                    return $data;
                }



            }

            function restaHoras($hora1, $hora2) {
                $hora1 = strtotime($hora1);
                $hora2 = strtotime($hora2);

                $diferencia = $hora1 - $hora2;

                // Convierte la diferencia en formato HH:mm
                $diferenciaHoras = gmdate("H:i", abs($diferencia));

                if ($diferencia < 0) {
                    // Si la diferencia es negativa, coloca un signo negativo en el resultado
                    $diferenciaHoras = '-' . $diferenciaHoras;
                }

                if (isset($diferenciaHoras)) {
                    $data = [
                        'horasDiferencia' => floor(abs($diferencia) / 3600),
                        'minutosDiferencia' => floor((abs($diferencia) % 3600) / 60),
                        'totalFormatoDiferencia' => $diferenciaHoras
                    ];
                    return $data;
                }
            }

            ?>



            <?php
            foreach ($idtreballadorsemp as $key => $idtreballador) {
                $id_emp = $idtreballador['id_emp'];
                $idtreballadorsemp[$key]['rows'] = [];
                foreach ($result as $row) {
                    if ($id_emp == $row['idempleat']) {
                        array_push($idtreballadorsemp[$key]['rows'], $row);
                    }
                }
            }

            
        switch($mes)
        {
            case 1:
                $mes_texto = "Enero";
                break;
            case 2:
                $mes_texto = "Febrerp";
                break;
            case 3:
                $mes_texto = "Marzo";
                break;
            case 4:
                $mes_texto = "Abril";
                break;
            case 5:
                $mes_texto = "Mayo";
                break;
            case 6:
                $mes_texto = "Junio";
                break;
            case 7:
                $mes_texto = "Julio";
                break;
            case 8:
                $mes_texto = "Agosto";
                break;
            case 9:
                $mes_texto = "Septiembre";
                break;
            case 10:
                $mes_texto = "Octubre";
                break;
            case 11:
                $mes_texto = "Noviembre";
                break;
            case 12:
                $mes_texto = "Diciembre";
                break;
            default:
                $mes_texto = "Todos";
                break;
        }
            ?>

            <?php foreach ($idtreballadorsemp as $key => $idtreballador) : $id = $idtreballador['id_emp']; ?>
            
                <div>
                    <div style="margin-top:30px" id="contingut">
                        <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng, "Lista Resumen Mensual de Marcajes"); ?></h3>
                        <div>
                            <section style="width:50%; float:left;">
                                <table border="1" class="table table-bordered" style="text-align: left; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <th><?php echo $dto->__($lng, "Empresa"); ?>:</th>
                                        <td><?php echo $nomemp; ?></td>
                                    </tr>
                                    <tr>
                                        <th>C.I.F./N.I.F.:</th>
                                        <td><?php echo $cifemp; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $dto->__($lng, "Centro de Trabajo"); ?>:</th>
                                        <td><?php echo $ctremp; ?></td>
                                    </tr>
                                    <tr>
                                        <th>C.C.C.:</th>
                                        <td><?php echo $cccemp; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Población:</th>
                                        <td><?php echo $pobemp; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </section>
                            <section style="width:50%; float:right;">
                                <table border="1" class="table table-bordered" style="text-align: left; width: 100%;">
                                    <tbody>
                                    <tr>
                                        <th><?php echo $dto->__($lng, "Trabajador"); ?>:</th>
                                        <td><?php echo $dto->mostraNomEmpPerId($id); ?></td>
                                    </tr>
                                    <tr>
                                        <th>N.I.F.:</th>
                                        <td><?php echo $dto->getEmpDni($id); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $dto->__($lng, "Nº Afiliación"); ?>:</th>
                                        <td><?php echo $dto->getEmpAfil($id); ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo $dto->__($lng, "Departamento"); ?>:</th>
                                        <td><?php echo $dto->mostraNomDptPerIdEmp($id); ?></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo $dto->__($lng, "Mes y año"); ?>:</th>
                                        <td><?php echo $mes_texto . " " . $any; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                        <br>
                        <table border="1" class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                        <thead>
                            <tr style="background-color: white; color: black">
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;">DIA</th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "ENTRADA 1"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "SALIDA 1"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "ENTRADA 2"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "SALIDA 2"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORAS ORDINARIAS"); ?></th>
                                <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORAS COMPLEMENTARIAS"); ?></th>
                                
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "OBSERVACIONES"); ?></th>
                            </tr>


                            <tr style="background-color: white; color: black">

                                <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "PACTADAS"); ?></th>
                                <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "VOLUNTARIAS"); ?></th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            // Obtener el primer día del mes y el último día del mes
                            $primerDia = date("Y-m-01", strtotime("$any-$mes-01"));
                            $ultimoDia = date("Y-m-t", strtotime("$any-$mes-01"));

                            // Convertir los valores a objetos DateTime
                            $fechaInicio = new DateTime($primerDia);
                            $fechaFin = new DateTime($ultimoDia);

                            $totalHoras_final = [];
                            $totalMinutos_final = [];

                            $totalHoras_diferencia =[];
                            $totalMinutos_diferencia =[];

                            $diferenciaHoras_format = [];

                            // Bucle para crear filas para cada día del mes
                            while ($fechaInicio <= $fechaFin) {
                                $diaActual = $fechaInicio->format("d");

                                // Inicializa variables para los registros de entrada y salida
                                $entrada1 = "";
                                $salida1 = "";
                                $entrada2 = "";
                                $salida2 = "";
                                $entrada3 = "";
                                $salida3 = "";
                                $totalHoras = "";
                                $horesteoriques = "";
                                $diferenciaHoras = "";
                                $observacions = "";

                                $horasRegistradas = false;
                                $horasDiferencia = false;



                                //HORAS TEORICAS

                                $fechaActual = $fechaInicio->format('Y-m-d');
                                foreach ($teorique_hours as $teorique_hour)
                                    if ($fechaActual == $teorique_hour['data'])
                                        $horesteoriques = $dto->decimalsToTimeFormat($teorique_hour['horestreball']);


                                // Recorre los registros para ver si hay datos para este día
                                foreach ($idtreballador['rows'] as $row) {
                                    // Verificar si la fecha del registro coincide con el día actual
                                    $fechaRegistro = date("d", strtotime($row['fecha']));
                                    if ($diaActual == $fechaRegistro) {
                                        // Verificar las salidas sin llenar y aplicar el estilo en rojo
                                        $salida1 = !$row['salida1'] && $row['entrada1'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida1'];
                                        $salida2 = !$row['salida2'] && $row['entrada2'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida2'];
                                       

                                        $entrada1 = !$row['entrada1'] && $row['salida1'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada1'];
                                        $entrada2 = !$row['entrada2'] && $row['salida2'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada2'];
                                       $fechaRegistroData = $row['fecha'];
										

                                        // Puedes usar las variables $row['entrada1'], $row['salida1'], etc., para acceder a los datos del registro.
                                        $data_time= calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'],$id,$fechaRegistroData);


                                        $totalHoras_test_2 = intval($data_time['horas']);
                                        $totalMinutos_test_2 =  intval($data_time['minutos']);


                                        $observacions = $row['observacions'];

                                        $diferenciaHoras = restaHoras($data_time['totalFormato'], $horesteoriques);

                                        $totalHoras_diferencia_2 = intval($diferenciaHoras['horasDiferencia']);
                                        $totalMinutos_diferencia_2 =  intval($diferenciaHoras['minutosDiferencia']);


                                        if ($row['entrada1'] && $row['salida1'] || $row['entrada2'] && $row['salida2']) {
                                            $horasRegistradas = true;
                                            $horasDiferencia = true;

                                        }
                                    }

                                }


                                if(!empty($totalHoras_test_2)) $totalHoras_final[] = $totalHoras_test_2;
                                if(!empty($totalMinutos_test_2)) $totalMinutos_final[] = $totalMinutos_test_2;

                                if(!empty($totalHoras_diferencia_2)) $totalHoras_diferencia[] = $totalHoras_diferencia_2;
                                if(!empty($totalMinutos_diferencia_2)) $totalMinutos_diferencia[] = $totalMinutos_diferencia_2;

                                $totalHoras_test_2 = [];
                                $totalMinutos_test_2 = [];

                                $totalHoras_diferencia_2 = [];
                                $totalMinutos_diferencia_2 = [];


                                        // quito ultimos ceros para que quede formato horas - minutos
                                        $entradas = [$entrada1, $entrada2];
                                        $entrada_formato = [];
                                        foreach ($entradas as $entrada) {
                                            // Verificar si la entrada tiene el formato H:i:s y quitar los ceros
                                            if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $entrada)) $entrada = substr($entrada, 0, -3);

                                            // Almacenar en el array
                                            $entrada_formato[] = $entrada;
                                        }
                                        //quito ultimos ceros para que quede formato horas - minutos
                                        $salidas = [$salida1, $salida2];
                                        $salida_formato = [];
                                        foreach ($salidas as $salida) {
                                            // Verificar si la entrada tiene el formato H:i:s y quitar los ceros
                                            if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $salida)) $salida = substr($salida, 0, -3);
                                            // Almacenar en el array
                                            $salida_formato[] = $salida;
                                        }
								
								
                                // Mostrar los datos en los <td>
                                  echo "<tr>";
                                        echo "<td>$diaActual</td>";
                                        echo "<td>" . $entrada_formato[0] . "</td>";
                                        echo "<td>" . $salida_formato[0] . "</td>";
                                        echo "<td>" .$entrada_formato[1] . "</td>";
                                        echo "<td>" . $salida_formato[1] . "</td>";
								
                               
								 //SI LO QUE TRAIGO EN ENTRADAS NO TIENE VALOR, PONGO VACIO LAS DEMAS COLUMNAS Y DEJO OBSERVACIONES
                                $horesOrdinaries =  ($horasRegistradas ? $data_time['totalFormato'] : "0:00");
                                $horesVoluntaries =  ($horasDiferencia ? $diferenciaHoras['totalFormatoDiferencia'] : "0:00");
                               if ($entrada1 == "" && $salida1 == "" && $entrada2 == "" ) {
                                $horesOrdinaries = "" ;
                                $horesteoriques = "";
                                $horesVoluntaries = "";
                               }

                                echo "<td>" . $horesOrdinaries. "</td>";
                                echo "<td>" . $horesteoriques . "</td>";

                                echo "<td>" . $horesVoluntaries . "</td>";
								          //TRAIGO LOS FESTIVOS 
                                 $data1 = "";
            
                                 for($i=1;$i<=$diafi;$i++)
                                 {
                                    
                                     $j = "";
                                     if($i<10)$j = "0".$i;
                                     else $j = $i;
                                     $data1 = $any."-".$mes."-".$j;
                                    
                                     if($diaActual == $i){
                                     $tipusexcep = "";
                                     $rse = $dto->esExcepcioPerIdDia($id, $data1);
                                     //print_r($rse);
                                     
                                     if(!empty($rse)) {
                                         foreach($rse as $e){$tipusexcep = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusexcep",$e["idtipusexcep"],"nom"));}
                                         //print_r($tipusexcep);
                                         echo '<td>'.$tipusexcep.'</td>';
                                         
                                     }  else {
                                        echo "<td>" . $observacions . "</td>";
                                     }
 
                                         
                                     }}

                                  
								
								
                                echo "</tr>";


                                if ($horasDiferencia) $diferenciaHoras_format[] = $diferenciaHoras['totalFormatoDiferencia'];

                                // Avanzar al siguiente día
                                $fechaInicio->modify("+1 day");
                            }

                            /* *** PORCION SEBAS INICIO */

                            $formato_valido = "/^-?\d{2}:\d{2}$/";
                            $totales_a_restar = [];
                            foreach ($diferenciaHoras_format as $item) if (preg_match($formato_valido, $item)) $totales_a_restar[] = $item;

                            $horas_minutos_diferencia = [];
                            foreach ($totales_a_restar as $total_restar)
                            {
                                $partes = explode(':', $total_restar);
                                $horas = (int)$partes[0];
                                $minutos = (int)$partes[1];
                                $minutos = (int)$partes[1];
                                if (substr($partes[0], 0, 1) === "-") $minutos = -1 * (int)$partes[1];
                                $horas_minutos_diferencia[] = ['horas' => $horas, 'minutos' => $minutos];
                            }

                            $horas_totales_diferencia = 0;
                            $minutos_totales_diferencia = 0;

                            foreach ($horas_minutos_diferencia as $tiempo) {
                                $horas_totales_diferencia += $tiempo['horas'];
                                $minutos_totales_diferencia += $tiempo['minutos'];
                            }

                            // Asegurarse de que los minutos sean positivos
                            if ($minutos_totales_diferencia < 0) {
                                $horas_totales_diferencia--;  // Restar una hora
                                $minutos_totales_diferencia += 60;  // Convertir los minutos negativos en positivos
                            }

                            // Asegurarse de que los minutos no superen 59
                            $horas_totales_diferencia += floor($minutos_totales_diferencia / 60);
                            $minutos_totales_diferencia %= 60;

                            // Formatear la diferencia en un formato hh:mm
                            $resultado_totales_diferencia = sprintf("%d:%02d", $horas_totales_diferencia, $minutos_totales_diferencia);

                            /* *** PORCION SEBAS FINAL ***/


                            if(!empty($totalHoras_final)) $horas = array_sum($totalHoras_final);
                            if(!empty($totalMinutos_final)) $minutos = array_sum($totalMinutos_final);

                            if(!empty($totalHoras_diferencia)) $horasDiferencia = array_sum($totalHoras_diferencia);
                            if(!empty($totalMinutos_diferencia)) $minutosDiferencia = array_sum($totalMinutos_diferencia);

                            // Mostrar los totales al final de la tabla
                            echo "<tr>";
                            echo "<td colspan='5'><strong>Total Horas:</strong></td>";

                            // Supongamos que tienes los minutos y las horas en dos variables separadas, $horas y $minutos.



                            // Ajusta los minutos si superan los 60 y suma a las horas
                            if ($minutos >= 60) {
                                $horas += floor($minutos / 60); // Suma las horas completas
                                $minutos = $minutos % 60; // Mantén los minutos restantes
                            }

                            // Formatea el resultado en "HH:MM"
                            $resultado = sprintf("%02d:%02d", $horas, $minutos);

                            echo "<td><strong>" . $resultado . "</strong></td>";

                            echo "<td></td>";

                            // Supongamos que tienes los minutos y las horas en dos variables separadas, $horas y $minutos.


                            // Inicializa las variables en 0
                            $horasDiferencia = 0;
                            $minutosDiferencia = 0;


                            foreach ($totalHoras_diferencia as $horas) {
                                $horasDiferencia += $horas;
                            }

                            foreach ($totalMinutos_diferencia as $minutos) {
                                $minutosDiferencia += $minutos;
                            }

                            // Ajusta los minutos si superan los 60 y suma/resta a las horas según sea necesario
                            if ($minutosDiferencia >= 60) {
                                $horasDiferencia += floor($minutosDiferencia / 60); // Suma las horas completas
                                $minutosDiferencia = $minutosDiferencia % 60; // Mantén los minutos restantes
                            } elseif ($minutosDiferencia <= -60) {
                                $horasDiferencia -= floor(abs($minutosDiferencia) / 60); // Resta las horas completas (negativo)
                                $minutosDiferencia = abs($minutosDiferencia) % 60; // Mantén los minutos restantes (positivo)
                            }

                            if ($horasDiferencia < 0) {
                                $resultadoDiferencia = "-" . sprintf("%02d:%02d", abs($horasDiferencia), abs($minutosDiferencia));
                            } else {
                                $resultadoDiferencia = sprintf("%02d:%02d", $horasDiferencia, $minutosDiferencia);
                            }

                            echo "<td><strong>" . $resultado_totales_diferencia . "</strong></td>";

                            echo "<td></td>";
                            echo "</tr>";
                            ?>
                            </tbody>




                        </table>
                    </div>
                    

                </div>
                
            <?php endforeach; ?>
            <br><br>
        </div>

</center>

</body>

</html>