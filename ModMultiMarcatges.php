<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $id = $_GET['1'];
    $data = $_GET["2"];
    $idempresa = $dto->getCampPerIdCampTaula("empleat",$id,"idempresa");
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

</style>



    <center>
            <div class="modal-dialog ">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism">

                <div class="modal-body">
                    <form name="noumarc">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <h3 style="color: white;"><?php echo $dto->__($lng,"Registrar Múltiples Marcatges");?></h3>
                        <div class="col-lg-10">
                            <h3 style="color:white"><label><?php echo $dto->__($lng,"Empleat");?>: </label> <?php echo $dto->mostraNomEmpPerId($id);?></h3></div>
                    </div>
                    <br>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                    <label style="color:white"><?php echo $dto->__($lng,"Des de");?>:</label> <input type="date" name="dataini" value="<?php echo $data;?>" required>
                        </div>
                        <div class="col-lg-6">
                    <label style="color:white"><?php echo $dto->__($lng,"Fins a");?>:</label> <input type="date" name="datafi" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10" style="text-align: center">
                            <label style="color:white"><?php echo $dto->__($lng,"Hores segons l'Horari o rotació assignat");?>: <input class="smtag" checked type="checkbox" name="chkhrqd" id="chkhrqd" onclick="try{lockhours();}catch(err){alert(err);}" style="width: 25px; height: 25px; align-self: baseline"></label>
                        </div>                   
                    </div><br>
                    <div class="row" id="frmhores">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                    <label style="color:white"><?php echo $dto->__($lng,"Hora Inici");?>:</label> <input id="horam1" disabled type="time" name="horaini">
                        </div>
                        <div class="col-lg-5">
                    <label style="color:white"><?php echo $dto->__($lng,"Hora Fi");?>:</label> <input id="horam2" disabled type="time" name="horafi">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10" style="text-align: center">
                            <label style="color:white"><?php echo $dto->__($lng,"Hora sortida variable de 0 a 5 mins aleatoris");?>: <input class="smtag" checked type="checkbox" name="chkhrrd" id="chkhrrd" onclick="" style="width: 25px; height: 25px; align-self: baseline"></label>
                        </div>                   
                    </div>
                    </form><br><br><br>

                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn_modal" data-dismiss="modal" onclick="try{insereixMultiMarcatges(noumarc.id.value,noumarc.dataini.value,noumarc.horaini.value,noumarc.datafi.value,noumarc.horafi.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                </div>
                <div class="glassmorphism">

                </div>
              </div>
            </div>
            </center>
</html>
