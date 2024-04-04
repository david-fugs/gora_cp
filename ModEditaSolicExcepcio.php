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
    $nomexcep = $dto->getCampPerIdCampTaula("tipusexcep",$idtipusexcep,"nom");
    $dataini = $_GET["3"];
    $datafi = $_GET["4"];
    $idempleencarg = $_GET["5"];
    $nomempleencg= $dto->getCampPerIdCampTaula("empleat",$idempleencarg,"nom");
    $id = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"idempleat");
  
    ?>


<style>


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
    <div class="modal-dialog">
        <div class="modal-content glassmorphism">
        <div class="glassmorphism">
            <h3 style="color:white;"><?php echo $dto->__($lng,"Editar Solicitud Periodo");?></h3>
        </div>
          <div class="modal-body">
             
              <form name="editaexcepM" method="POST" enctype="multipart/form-data">
              <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcepM" value="<?php echo $dataini;?>">
              <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcepM" value="<?php echo $datafi;?>"><br><br>
              <label><?php echo $dto->__($lng,"Tipus");?>:</label>
              <input type="hidden" name="MSJrequiredDoc" value="<?php echo $dto->__($lng,"Archivo requerido"); ?>">
              <select id="tipusExcep" name="tipusExcepM">
                  <option hidden selected value="<?php echo $idtipusexcep;?>"><?php echo $dto->__($lng,$nomexcep);?></option>
              <?php
                  $tipus = $dto->seleccionaTipusExcepcions();
                  foreach($tipus as $valor)
                  {
                      $tipusData = $valor["idtipusexcep"]."|".$valor["DocFileReq"];
                      echo '<option value="'.$tipusData.'">'.$dto->__($lng,$valor["nom"]).'</option>';
                  }
              ?>
              </select>
              <label><?php echo $dto->__($lng,"Encargado");?>:</label>
                    <select name="idempleat" required>
                    <option hidden selected value="<?php echo $idempleencarg;?>"><?php echo $dto->__($lng,$nomempleencg);?></option>
                    <?php
   

   // Valor del parámetro idempleat
   $idempleat = $_GET["id"]; // Reemplaza con el valor adecuado de idempleat

   // Consulta para obtener el nombre completo de idresp
   $consultaNombre = "SELECT CONCAT(nom, ' ', cognom1) AS nombre_completo FROM empleat WHERE idempleat = (SELECT idresp FROM empleat WHERE idempleat = " . $idempleat . ")";

   // Ejecutar la consulta
   $resultadoNombre = mysqli_query($conn, $consultaNombre);

   if ($resultadoNombre) {
       if ($filaNombre = mysqli_fetch_assoc($resultadoNombre)) {
           $nombreCompleto = $filaNombre['nombre_completo'];

           // Imprimir la opción seleccionada con el nombre completo
           echo '<option value="' . $idempleat . '" selected>' . $nombreCompleto . '</option>';

           // Obtener el valor de idresp correspondiente al nombre completo
           $consultaIdResp = "SELECT idempleat FROM empleat WHERE CONCAT(nom, ' ', cognom1) = '" . $nombreCompleto . "'";
           $resultadoIdResp = mysqli_query($conn, $consultaIdResp);

           if ($resultadoIdResp && mysqli_num_rows($resultadoIdResp) > 0) {
               $filaIdResp = mysqli_fetch_assoc($resultadoIdResp);
               $idresp = $filaIdResp['idempleat'];

               // Utilizar el valor de idresp según sea necesario
               echo 'Valor de idresp: ' . $idresp;
           } else {
               echo 'No se encontró ningún valor para idresp.';
           }

           // Liberar el resultado de idresp (opcional, si ya no se necesita más adelante)
           mysqli_free_result($resultadoIdResp);
       } else {
           echo 'No se encontró ningún valor para el nombre completo.';
       }

       // Liberar el resultado de nombre completo (opcional, si ya no se necesita más adelante)
       mysqli_free_result($resultadoNombre);
   } else {
       echo 'Error en la consulta: ' . mysqli_error($conn);
   }

   // Cerrar la conexión a la base de datos (opcional, si ya no se necesita más adelante)
   mysqli_close($conn);
   ?>
                    </select>
                    <br> <br> <br>
                    <table class="table table-condensed table-striped table-hover" style="text-align: center" id="TableFiles">
                        <thead>
                        <h4 style="color:white"><strong><i><?php echo $dto->__($lng,"Archivos");?></i></strong></h4>
                        <th></th>
                        </thead>
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

                                    if (file_exists($pathFoler)) {

                                        $listFiles = array_values(array_diff(scandir($pathFoler), array('..', '.')));

                                        for ($i=0; $i < count($listFiles ); $i++) { 
                                            $nameFile = $listFiles[$i];
                                            $stringparse = "'".$pathFoler.$sep.$nameFile."'";
                                            echo '<tr><td><a href="FileDowloader.php?File='.urlencode($nameFile).'&Idexcepcio='.$idexcep.'">'.$nameFile.'</a></td>';
                                            echo '<td><button onclick="DeleteDocument('.$stringparse.',this);return false;"><span class="glyphicon glyphicon-remove" style="color:red" title="'.$dto->__($lng,"Eliminar archivo").'"></span></button></td>';
                                            echo '</tr>';
                                        }

                                        
                                    }

                            ?>
                        </tbody>
                    </table>
                    <label><?php echo $dto->__($lng,"Archivos");?>:</label><input type="file" name="inpFile[]" id="FilesSelect2" multiple>                    
             </form>
              <br>
          </div>
        <div class="">
        <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
        <button type="button" class="btn_modal" data-toggle="modal" onclick="ModSolcExepct(editaexcepM,<?php echo $idexcep;?>);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
        </div>
        </div>
      </div>

    </center>
</html>


