<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idmarcatge = $_GET["1"];
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
    <div class="modal-dialog">
      <div class="modal-content glassmorphism">
          <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color: white"><?php echo $dto->__($lng,"Eliminar Marcatge");?></h3></div>
            <div class="modal-body">
            <h3 style="color: white"><?php echo $dto->__($lng,"Està segur d'eliminar aquest Marcatge?");?></h3>
                <br>
            </div>
          <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-danger" onclick="eliminaMarcatge(<?php echo $idmarcatge;?>);"><span class="glyphicon glyphicon-trash"></span> <?php echo $dto->__($lng,"Eliminar");?></button>

      </div>
    </div>
    </center>
</html>
