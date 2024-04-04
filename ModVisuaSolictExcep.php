<!DOCTYPE html>
<html>

    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();

     
    

    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idexcep = $_GET["1"];
    $idtipusexcep = $_GET["2"];
    $dataini = $_GET["3"];
    $datafi = $_GET["4"];
    $idempleencarg = $_GET["5"];
    $coment_excepcio =$_GET["7"];
    $nomempleencg= $dto->getCampPerIdCampTaula("empleat",$idempleencarg,"nom", "cognom1");
    $idsession = $_GET["6"];
    include 'Conexion.php';
    $idempresa=$_SESSION["idempresa"];
    $d = strtotime("now");
    if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
    $any = $_GET["any"];
    $diesespecials1s = array_fill(0,4,0);
    $diesespecials2s = array_fill(0,4,0);
    $diesespecialsmes1s = array_fill(0,4,0);
    $diesespecialsmes2s = array_fill(0,4,0);



    //EXCEPCION ELEMENTO SELECCIONADO
    $data_exception = $dto->seeException($idexcep, $idtipusexcep);

    $nomexcep = $data_exception['nom'];
    $id = $data_exception['id_employee'];
    $stateSolict = $data_exception['approved'];
    $comentario = $data_exception['comment'];
    $observations = $data_exception['observations'];
    $date_approved = $data_exception['date_approved'];


	
	//PRUEBA PARA QUE FILTRE POR AÑO DE SOLICITUD

$fecha_solicitud = new DateTime($dataini);
$any_solicitud = $fecha_solicitud->format('Y');
$mes_solicitud = $fecha_solicitud->format('m');




    //DIAS DE VACACIONES AÑO ANTERIOR Y AÑO ACTUAL

    $data_days_vacation = $dto->days_vacation($id);
	$data_dias_any_anterior = $dto->days_vacation_any_anterior($id);
	
	
    $year = date("Y");
    $before_year = $year - 1;

	
	$total_dias_any_anterior = $data_dias_any_anterior[$any_solicitud];
    $total_dias = $data_days_vacation[$any_solicitud];
	
   
$total_dias_anterior = $data_days_vacation[$any_solicitud-1];

    //TRAIGO LOS DIAS EXCEPCION
    $exception_days = $dto->days_exception($id, $any_solicitud, $datafi);
    $exception_days_last_year =  $dto->days_exception($id, $before_year,$datafi);


    // DIAS USADOS DE VACACIONES HASTA LA FECHA

    
    $data_days_vacation_used = $dto->days_vacation_used($id, '2023-09-08');
    
    $diesvacances = 0;
    $diesvacances = $data_days_vacation_used[2]['count_days'];

    $total_dias_actual_anterior = $total_dias + $total_dias_anterior;


    //OPERACIONES RESUMEN VACACIONES
    $total_dias_restantes = $total_dias + $total_dias_anterior - $diesvacances; //$total_dias + $total_dias_anterior - $diesvacances;


 //DIAS TOTAL VACACIONES AÑO ANTERIOR
			  
 $dias_total_vacaciones_año_anterior = 0;

 foreach ($exception_days_last_year  as $key =>   $dias)
         {
 foreach ($dias as  $item)
        {
    if ($item == 'Vacaciones') {
        $dias_total_vacaciones_año_anterior=$exception_days_last_year[2]['count_days'];		
    }
 
 }
}





    
    //DIAS TOTAL VACACIONES
			  
     $dias_total_vacaciones = 0;

 	foreach ($exception_days as $key =>   $dias)
 			{
     foreach ($dias as  $item)
    		{
        if ($item == 'Vacaciones') {
            $dias_total_vacaciones=$exception_days[2]['count_days'];		
        }
     
     }
    }
			  
	//TOTAL DIAS DISPONIBLES


$total_asignados = $total_dias + $total_dias_any_anterior;
$total_dias_disponibles = $total_asignados - $dias_total_vacaciones ;



	
    //ES ENCARGADO? ES MASTER? ES ADMIN?
    $is_encargat = $_SESSION['encargado'];
    $is_encargat = ($is_encargat == 1) ? true : false;
    $is_master = $_SESSION["master"];
    $is_master = ($is_master == 1) ? true : false;
    $is_admin = $_SESSION["admin"];
    $is_admin = ($is_admin == 1) ? true : false;

    //$nomexcep = $dto->getCampPerIdCampTaula("tipusexcep",$idtipusexcep,"nom");
    //$id = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"idempleat");
    //$stateSolict = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"aprobada");

    //$anys = $dto->mostraAnysContractePerId($id);


    
    ?>


    <?php
    /*
    include 'Conexion.php';
    $idexcepcio = $idexcep; // Reemplaza con el ID de excepcio adecuado
    // Consulta SQL para obtener el valor de la columna "comentario" de la tabla "excepcio"
    $sql = "SELECT comentario FROM excepcio WHERE idexcepcio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idexcepcio);
    $stmt->execute();
    $comentario = 'comentario';
    $stmt->bind_result($comentario);

    if ($stmt->fetch()) {
        print_r($comentario);
        echo "SE ENCONTRO COMENTARIO";
    } else {
        echo "No se encontró ningún comentario para el ID de excepcio especificado.";
    }
    $stmt->close();
    */
    ?>



    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link href="css/estilos_chat.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>


<style>
input[type="date"],
input[type="text"] {
  display: inline-block;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 250px;
  margin-bottom: 10px;
}

input[type="date"]:read-only,
input[type="text"]:read-only {
  background-color: #ddd;
}




      /* Estilo para el fondo del modal */
      .modal-content.glassmorphism {
          background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          backdrop-filter: blur(10px); /* Efecto de desenfoque */
          border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
          border-radius: 10px; /* Borde redondeado */
      }

      /* Estilo para el cuerpo del modal */
      .modal-body {
          background: rgba(255, 255, 255, 0.1); /* Color de fondo con transparencia */
          padding: 20px; /* Espaciado interior */
      }

      /* Estilo para los botones dentro del modal */
      .btn_modal {
          background-color: rgba(72, 90, 255, 0.9); /* Color de fondo con transparencia */
          border: none; /* Sin borde */
          color: white; /* Color del texto */
          border-radius: 5px; /* Borde redondeado */
          margin-right: 10px; /* Espaciado entre botones */
      }

      /* Estilo para los botones cuando están en hover */
      .btn_modal:hover {
          background-color: rgba(81, 209, 246, 0.7); /* Cambia el color de fondo durante el hover */
          color: white; /* Cambia el color del texto durante el hover */
      }


      /* Estilo para el título del modal */
      .modal-body h3 {
          color: white; /* Color del texto del título */
          text-align: center; /* Alineación del texto del título */
      }


      /* Estilo para el select */
      .mi-select {
          width: 100%; /* Ancho del select, puedes ajustarlo según tus necesidades */
          padding: 10px; /* Espaciado interno */
          font-size: 16px; /* Tamaño de fuente */
          border: 1px solid #ccc; /* Borde del select */
          border-radius: 10px; /* Borde redondeado */
          background-color: #fff; /* Color de fondo */
          color: #333; /* Color del texto */
      }

      /* Estilo para el select cuando está en hover (opcional) */
      .mi-select:hover {
          border-color: #007bff; /* Cambia el color del borde al pasar el mouse sobre él */
      }

      /* Estilo para el select cuando está enfocado (opcional) */
      .mi-select:focus {
          border-color: #007bff; /* Cambia el color del borde cuando el select está enfocado */
          outline: none; /* Elimina el contorno predeterminado al hacer clic en el select */
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Agrega una sombra suave cuando el select está enfocado */
      }


</style>










<center>
    <div class="modal-dialog_admin">
        <div class="modal-content glassmorphism ">

            <div class="glassmorphism">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 style="color:white" class="modal-title"><?php echo $dto->__($lng,"Solicitud Periodo");?></h3>
            </div>

          <div class="modal-body_admin">
            <?php
                if ($id != $idsession) {
                    echo '<h4>'.$dto->__($lng,"Empleat").': '.$dto->mostraNomEmpPerId($id).'</h4><br>';
                }
            ?>

              <form name="editaexcepM">
                  <label style="color: black;" class="label_admin"><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcepM" value="<?php echo $dataini;?>" readonly>
                  <label style="color: black;" class="label_admin"><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcepM" value="<?php echo $datafi;?>" readonly><br><br>
                  <label style="color: black;" class="label_admin"><?php echo $dto->__($lng,"Tipus");?>:</label><input type="text" id="Tipus" name="TipusM" value="<?php echo $dto->__($lng,$nomexcep);?>" readonly>
                  <label style="color: black;" class="label_admin"><?php echo $dto->__($lng,"Encargados");?>:</label><input type="text" id="idempleat" name="idempleat" value="<?php echo $dto->__($lng,$nomempleencg);?>" readonly><br>


                  <label style="color: black;" class="label_admin"><?php echo $dto->__($lng,"Comentario");?>:</label><input type="text" id="idempleat" name="idempleat" value="<?php echo $dto->__($lng,$comentario);?>" readonly>
                  <br><br>
				  <h4 style="color:white"><strong><i><?php echo $dto->__($lng,"Archivos");?></i></strong></h4>
                  <table class="table" style="text-align: center">
                     
                      <tbody>
                      <?php
						  
						  
						  
						  
						  
						  
                      $root = $_SERVER["DOCUMENT_ROOT"];

                      if (strpos($root,'/') === false) {
                          $sep = "\\";
                      }else{
                          $sep = "/";
                      }

                      $micarpeta = $root.$sep.'excepciFiles';
                      $pathFoler = $micarpeta.$sep.$idexcep;

						  print_r($pathFoler);
						  
						  
                      if (file_exists($pathFoler)) {

                          $listFiles = array_values(array_diff(scandir($pathFoler), array('..', '.')));

                          for ($i=0; $i < count($listFiles ); $i++) {
                              $nameFile = $listFiles[$i];
                              $stringparse = "'".$pathFoler.$sep.$nameFile."'";
                              echo '<tr>';
                          echo '<td><a href="FileDowloader.php?File='.urlencode($nameFile).'&Idexcepcio='.$idexcep.'">'.$nameFile.'</a></td>';
                          echo '<td><button class="btn btn-danger btn-sm" onclick="borrarArchivo(' . $idexcep . ', \'' . $nameFile . '\')">Borrar</button></td>';
                          echo '</tr>';
                          }
                      }
                      ?>
                      </tbody>


					  
					  
                  </table>
				  
				  
				  
				     <label style="color:black"><?php echo $dto->__($lng,"Añadir mas archivos");?>:</label>

            <div class="row">

            <div class="col-sm-6">
                <input type="file" name="inpFile[]" id="FilesSelectSecond" multiple>
            </div>

            <div class="col-sm-6">
                <button type="button" role="button" class="btn_modal" onclick="añadirMasArchivos(<?php echo $idexcep;?>)" > <span class="glyphicon glyphicon-ok"></span>  <?php echo $dto->__($lng,"Añadir");?></button>
            </div>

            </div>

				  
				  
                  <label style="color: black; margin-top : 40px;" class="label_admin"><?php echo $dto->__($lng,"Estado");?>:</label><input type="text" id="Estate" name="EstateN" value="<?php

                  $stateExept = $dto->__($lng,"pendiente");
                  if($stateSolict == '1') $stateExept = $dto->__($lng,"aprobada");
                  else if($stateSolict == '0') $stateExept = $dto->__($lng,"Denegada");
                  echo $stateExept;?>" readonly>


                  <br>

                <?php 
                if (!is_null($stateSolict)){
                    echo  '<label style="color: black;" class="label_admin">'.$dto->__($lng,"Fecha").' '.$date_approved.':</label><input type="date" id="DateActu" name="DateActuN" value="'.$date_approved.'" readonly>';
                    echo '<br><br>';
                    echo  '<label style="color: black;" class="label_admin">'.$dto->__($lng,"Observaciones").':</label><input type="text" id="observ" name="observN" value="'.$observations.'" readonly>';
                }
                ?>
                
              </form>

              <br><br>

                <strong> <h3 class="modal-title">Total de permisos acumulados aprobados hasta la fecha</h3></strong>
                <br>


              <?php foreach ($exception_days as $exception_day)
              {
                  echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Dies de ' .$exception_day['type_excepcio']  .' any').' '.$any_solicitud.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'  </label><br>';


              }
              ?>


            <h3><strong>Resumen Vacaciones</strong></h3>

            <?php
			  
			 
			  
			  
                 echo '<span><span class="glyphicon glyphicon-stop" style="color: rgb(51, 156, 255)"></span> ' . $dto->__($lng, "Días de vacaciones") . ' ' . $any_solicitud . '' . ":" . ' ' . $total_dias . '</span> ' . '/ ';
                 echo '<span>' . $dto->__($lng, "Días vacaciones año anterior") . ' : ' . $total_dias_any_anterior . '</span> ' . '/ ';
                 // echo '<span>' . $dto->__($lng, "Vacaciones asignadas totales:") . ' ' . '' . $total_dias_actual_anterior . ' ' . '</span>';
                echo '<span>' . $dto->__($lng, "Total asignados:") . '' . ":" . ' ' .$total_asignados . '</span> <br>';
                echo '<span>' . $dto->__($lng, "Vacaciones Disponibles:") . '' . ":" . ' ' .$total_dias_disponibles . '</span>';           
                

            ?>



          </div>

       
			
                <div class="row">

                    <div class="col-sm-6">
                       <?php
                        if ($is_encargat || $is_master || $is_admin)
                        {
                            echo '<form method="get" action="AdminHorarisEmpleatBasic.php" target="_blank">';
                            echo '<input type="hidden" name="id" value="'.$id.'">';
                            echo '<button class="btn-blue btn-small" onclick="this.form.submit();"  title="' . $dto->__($lng, "Veure Calendari") . '">';
                            echo '<span class="glyphicon glyphicon-calendar"></span>';
                            echo '</button>';
                            echo '</form>';
                        }
                        ?>
                    </div>

                    <div class="col-sm-6">

                        <button type="button" class="btn_modal" data-dismiss="modal"><?php echo $dto->__($lng,"Cerrar");?></button>
                    </div>

                </div>
			
			
			
			

                <br>

            </div>
        </div>

    </div>
     

        </div>
        </div>
      </div>


    </center>






</html>
