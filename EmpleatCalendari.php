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

        ?>
    <script type="text/javascript">
        function mostraTornsPerId(id,idhorari)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modTorns").innerHTML = this.responseText;
                $modal = $('#modTorns');
                $modal.modal('show'); 
            }
            };
            xmlhttp.open("GET", "ModalTorns.php?id=" + id + "&idhorari=" + idhorari, true);
            xmlhttp.send();
        }
        
        function assignaHorariTipus(id,idtipus,datainici,datafi)
        {   
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaHorariTipus&id=" + id + "&idtipus=" + idtipus + "&datainici=" + datainici + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
        
        function editaPeriodeHorari(idquadrant,idtipus,novadataini,novadatafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=editaPeriodeHorari&idquadrant=" + idquadrant + "&idtipus=" + idtipus + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
            xmlhttp.send();
        }        
        
        function mostraPeriodeHorari(idquadrant,idtipus,dataini,datafi) 
        {        
        $('#datainici').val(dataString(dataini));
        $('#datafi').val(dataString(datafi));
        $('#idnouhorari').val(idtipus);
        $('#idquadrant').val(idquadrant);
        $modal = $('#modEditaPeriodeHorariTipus');
        $modal.modal('show');
        }
        
        function confElimPeriodeHorari(idquadrant,nomhorari) 
        {
           
        document.getElementById("tipushorariaelim").innerHTML = nomhorari+"?";
        $('#idhorariaelim').val(idquadrant);
        $modal = $('#modConfElimPeriodeHorari');
        $modal.modal('show');
        }
        
        function eliminaPeriodeHorari(idquadrant)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaPeriodeHorari&idquadrant=" + idquadrant, true);
            xmlhttp.send();
        }
    
        
        
        function assignaExcep(id,idtipus,dataini,datafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi, true);
            xmlhttp.send();
        }

        function ModSolcExepct(formCont,SolictID)
        {

            try {
                const inpFile = formCont.querySelector('[id="FilesSelect2"]').files
                const tipusdata = formCont.querySelector('[name="tipusExcepM"]').value
                    
                const tipus =  tipusdata.split('|',2)

                const cantFiles  = formCont.querySelector('[id="TableFiles"]').rows.length

                if (tipus[1] == '1'){
                    if(inpFile.length == 0) {
                        if ( cantFiles == '1'){
                            alert(formCont.querySelector('[name="MSJrequiredDoc"]').value)
                            return
                        }
                    
                    } 
                }

                const dataini = formCont.querySelector('[name="datainiexcepM"]').value
                const datafi = formCont.querySelector('[name="datafiexcepM"]').value
                const idempleat = formCont.querySelector('[name="idempleat"]').value
                
                const formData = new FormData()

                for (const file of inpFile) {
                    formData.append("myFiles[]",file)
                }

                // post form data
                const xhr = new XMLHttpRequest()

                xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    window.location.reload(window.location);
                }
                };

                // log response
                xhr.onload = () => {
                    console.log(xhr.responseText)
                }

                // create and send the reqeust
                xhr.open('POST', "Serveis.php?action=ModSolicitexcep&id=" + SolictID + "&idtipus=" + tipus[0] + "&dataini=" + dataini + "&datafi=" + datafi+ "&idEncargado=" + idempleat, true)
                xhr.send(formData)

            } catch (error) {
                alert(error);
            }
            
           
        }

        function DeleteDocument(File,ctrlthis){

            try {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "Serveis.php?action=DeleteFile&FilePath=" + File, true);
                xmlhttp.send();
                
                row = ctrlthis.parentNode;
                row = row.parentNode;
                row.parentNode.removeChild(row);

            } catch (error) {
                alert(error);
            }

            
            return false;

        }
        
        function editaExcep(idexcep,noutipus,novadataini,novadatafi)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=editaExcep&idexcep=" + idexcep + "&tipus=" + noutipus + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
            xmlhttp.send();
        }
        
        function confElimExcep(idexcep) 
        {
        var nomexcep = document.getElementById("nomexcep"+idexcep+"").innerHTML;
        document.getElementById("tipusexcepaelim").innerHTML = nomexcep+"?";
        $('#idexcepaelim').val(idexcep);
        $modal = $('#modConfElimExcep');
        $modal.modal('show');
        }
        
        function eliminaExcep(idexcep)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaExcep&idexcep=" + idexcep, true);
            xmlhttp.send();
        }
        
        


    </script>




<style>
    /* Estilo específico para la palabra "Filtro" */
    .filtro-text {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-right: 10px; /* Agrega un espacio entre la palabra "Filtro" y el desplegable */
        color: black;
        text-decoration: none;
    }

    /* Estilo para el enlace del desplegable */
    .filtro-link {
        font-size: 16px;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        padding: 5px 10px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
        outline: none;
    }

    /* Estilo para el enlace del desplegable al pasar el mouse por encima */
    .filtro-link:hover {
        background-color: #ddd;
        color: #333;
    }

    /* Estilo para el contenido del desplegable */
    .filtro-content {
        background-color: #fff;
        border: 1px solid #ddd;
        border-top: 0;
        border-radius: 0 0 4px 4px;
        padding: 10px;
    }


    .btn-next {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-next .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-next .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-next:hover {
      background-color: #ff5722; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }



  .btn-green {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
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





	  .btn-red {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-red .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-red .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-red:hover {
      background-color: #ec5653; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }


  .btn-blue {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-blue .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-blue .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-blue:hover {
      background-color: #0088fa; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }



  .btn-neutro {
            position: relative; /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color: transparent;
            color: black; /* Texto transparente */
            border:2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease; /* Animación suave en todos los cambios */
        }

        .btn-neutro .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px; /* Tamaño de la flecha */
            color: #007bff; /* Color de la flecha antes del hover */
            transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
        }

        .btn-neutro .btn-text {
            position: relative;
            z-index: 1; /* Coloca el texto del botón sobre la flecha */
        }

        .btn-neutro:hover {
            background-color: #919191; /* Cambia el color de fondo durante el hover */
            color: #fff; /* Cambia el color del texto durante el hover */
            transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
        }


  .btn-small {
    padding: 5px 10px; /* Ajusta el espaciado para botones pequeños */
    font-size: 14px; /* Tamaño de fuente más pequeño */
    /* Otros estilos específicos para botones pequeños si es necesario */
    }

    .btn-medium {
        padding: 10px 15px; /* Ajusta el espaciado para botones pequeños */
        font-size: 18px; /* Tamaño de fuente más pequeño */
        /* Otros estilos específicos para botones pequeños si es necesario */
    }




  .custom-select {
  appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #f2f2f2; /* Color de fondo del select */
  border: none;/* Borde del select */

  border-radius: 5px; /* Radio de borde del select */
  width: 100%; /* Ancho del select */
  cursor: pointer; /* Cambia el cursor al pasar sobre el select */
  color:#333;

  }

  /* Estilos para el desplegable del select */
  .custom-select option {
  padding: 10px; /* Espaciado interno de las opciones */
  cursor: pointer; /* Cambia el cursor al pasar sobre las opciones */

  }

  /* Estilos para el contenedor del select */
  .custom-select-container {
  display: inline-block; /* Alinea el contenedor en línea */
  position: relative; /* Establece una posición relativa para el contenedor */
  width: 100%; /* Ancho del contenedor */
  }

  /* Estilos para el triángulo desplegable (flecha) */
  .custom-select::after {
  content: '\25BC'; /* Código Unicode para una flecha hacia abajo */
  position: absolute; /* Posición absoluta en relación con el contenedor */
  top: 50%; /* Alinea la flecha verticalmente en el centro */
  right: 10px; /* Espaciado desde el borde derecho */
  transform: translateY(-50%); /* Alinea la flecha verticalmente en el centro */
  pointer-events: none; /* Evita que la flecha sea clickeable */
  }




        /* Estilos para el select al pasar el cursor sobre él */
        .glass-select:hover {
        background-color: #d1ffff; /* Cambia el color de fondo en hover */

        transition: background-color 0.3s, border 0.3s; /* Agrega una transición suave */
        border-radius: 10px;
        }






        .select-arrow {
            position: absolute;
            top: 50%;
            right: 10px; /* Ajusta el margen derecho según tu preferencia */
            transform: translateY(-50%);
            pointer-events: none; /* Evita que la flecha sea interactiva */
            }

            .glass-container {
            background: rgba(255, 255, 255, 0.2); /* Color de fondo transparente */
            backdrop-filter: blur(10px);
            border-radius: 10px;
           
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .glass-select {
            background: transparent;
            border: none;
            outline: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            color: #333; /* Color del texto */
            appearance: none;
            cursor: pointer;
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


</style>



    </head>
    <body class = "well">
        <div class="modal fade" id="modContent"></div>
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_GET["id"];
        $idempresa=$_SESSION["idempresa"];
        $anys = $dto->mostraAnysContractePerId($id);
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        $diesespecials1s = array_fill(0,11,0);
        $diesespecials2s = array_fill(0,11,0);
        $diesespecialsmes1s = array_fill(0,11,0);
        $diesespecialsmes2s = array_fill(0,11,0);
   
       
        ?>
        <center>            
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="col-lg-4" style="text-align: left">
                    <form action="EmpleatCalendari.php" method="GET">
                    <h2 class=""><?php echo $dto->__($lng,"Calendari Anual"); ?> 
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </form>            
                </div>
                <div class="col-lg-4">
                    <h3 class=""><?php echo $dto->mostraNomEmpPerId($id);?></h3><br><br>

                    <!-- se quita este label a peticion del cliente
                    <label class="smtag"><?php echo $dto->__($lng,"Hores")." ".$dto->__($lng,"Teòriques")." ".$dto->__($lng,"any")." ".$year;?>:</label> <strong class="smtag"><?php echo number_format($horesteoany,1,",",".");?> h</strong>-->
                    
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3" style="text-align: right">
                    <form method="get">
<!-------------------------------------Comento esta seccion por peticios del cliente de eliminar estos botones, pero lo comento por si mas adelante los necesitan nuevamente  

                    <button type="submit" formaction="EmpleatFitxa.php" class="btn btn-default btn-lg" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Fitxa");?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button type="submit" formaction="EmpleatMarcatges.php" class="btn btn-warning btn-lg" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Marcatges");?>"><span class="glyphicon glyphicon-list"></span></button>
                    <a class="btn btn-default btn-lg" href='index.php' title="<?php echo $dto->__($lng,"Inici");?>"><span class="glyphicon glyphicon-home"></span></a>

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                </form>
                </div>
            </div>
        </div>   
        
        
<!-----------------------------------------------------------INICIO DE LA TABLA DE DE PERIODOS ESPECIALES------------------------------------------------------------------------------->

<?php
//DATA PARA CALENDARIO
$i=0;
$data = $dto->monthlyEmployeeCalendar($id,$any,$i,16.66,$lng);
$exception_days = $data['exception_days'];
$months = $data['months'];
?>


<div class="container" style="min-width: 1200px; display:none;">
    <?php $dto->paintCalendarMonth(1, $months[1], $lng);?>
    <?php $dto->paintCalendarMonth(2, $months[2], $lng);?>
    <?php $dto->paintCalendarMonth(3, $months[3], $lng);?>
    <?php $dto->paintCalendarMonth(4, $months[4], $lng);?>
</div><br>


<div class="container" style="min-width: 1200px; display:none;">
    <?php $dto->paintCalendarMonth(5, $months[5], $lng);?>
    <?php $dto->paintCalendarMonth(6, $months[6], $lng);?>
    <?php $dto->paintCalendarMonth(7, $months[7], $lng);?>
    <?php $dto->paintCalendarMonth(8, $months[8], $lng);?>
</div><br>


<div class="container" style="min-width: 1200px; display:none;">
    <?php $dto->paintCalendarMonth(9, $months[9], $lng);?>
    <?php $dto->paintCalendarMonth(10, $months[10], $lng);?>
    <?php $dto->paintCalendarMonth(11, $months[11], $lng);?>
    <?php $dto->paintCalendarMonth(12, $months[12], $lng);?>
</div><br>




</div>
</div>
<br><br>


        <div class="container" style="min-width: 1200px; position: relative;">




             <center>



            <section style="width:75%; float:center; margin-top:10px; ">
               
          
               
                    <label class=""><?php echo $dto->__($lng,"Periodos Solicitados");?>:</label><br>
                    <div>
                <table class="table table-condensed table-striped table-hover" style="text-align: center">
                        <thead>
                        <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:large;"><?php echo $dto->__($lng,"Inici");?></th>
                        <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:large;"><?php echo $dto->__($lng,"Final");?></th>
                        <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:large;"><?php echo $dto->__($lng,"Tipus");?></th>
                        <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:large;"><?php echo $dto->__($lng,"Estado");?></th>
                        <th style="background-color: #f5f5f5; color: black; font-size:large;"></th>
                        </thead>
                        <tbody>
                            <?php
                            $excepcions = $dto->seleccionaSolictExcepcionsEmpPerId($id);
                            
                            foreach($excepcions as $periode)
                            {
                                $tipus = $periode["nom"];
                                $inicial = substr($periode["nom"],0,3);
                                $datafi = "";
                                if(strtotime($periode["datafinal"])>=strtotime($periode["datainici"])) $datafi = date('d/m/Y',strtotime($periode["datafinal"]));
                            
                                $estado = $dto->__($lng, "Pendiente");
                                if($periode["aprobada"] == '1') $estado = $dto->__($lng, "aprobada");
                                else if($periode["aprobada"] == '0') $estado = $dto->__($lng, "Denegada");
                            
                                $background_color = "";
                                if($estado == $dto->__($lng, "aprobada")) $background_color = "background-color: rgb(128,255,128)";//verde
                                else if($estado == $dto->__($lng, "Pendiente")) $background_color = "background-color: rgb(255,135,50)";//naranja
                                else if($estado == $dto->__($lng, "Denegada")) $background_color = "background-color: rgb(255,56,36)";//rojo
                               
                            
                                echo '<tr style="'.$background_color.'">';
                                echo '<td>'.date('d/m/Y',strtotime($periode["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td id="nomexcep'.$periode["idexcepcio"].'">'.$dto->__($lng,$tipus).'</td>';
                                echo '<td>'.$dto->__($lng,$estado).'</td>';
                                echo '<td style="background-color: rgb(255,255,255)">';
                                echo '<button class="btn-blue btn-small" onclick="VerSolicExcep('.$periode["idexcepcio"].','.$periode["idtipusexcep"].",'".$periode["datainici"]."','".$periode["datafinal"]."'".','.$periode["idresp"].','.$id.');"><span class="glyphicon glyphicon-eye-open"  title="'.$dto->__($lng,"Ver solicitud de periodo").'"></span></button>';
                                if(is_null($periode["aprobada"])){
                                    echo '<button class="btn-neutro btn-small" onclick="EditSolicExcep('.$periode["idexcepcio"].','.$periode["idtipusexcep"].",'".$periode["datainici"]."','".$periode["datafinal"]."'".','.$periode["idresp"].');">';
                                    echo '<span class="glyphicon glyphicon-pencil" style="color:black" title="'.$dto->__($lng,"Editar solicitud Període").'"></span></button>';
                                    echo '<button class="btn-red btn-small" onclick="confElimExcep('.$periode["idexcepcio"].');"><span class="glyphicon glyphicon-remove" style="color:red" title="'.$dto->__($lng,"Eliminar solicitud Període").'"></span></button>';



                                    echo '<a href="comentario.php?idexcepcio=' . $periode["idexcepcio"] . '&idempleat=' . $_SESSION["id"] . '" class="btn-green btn-supersmall" target="_blank">'
                                    . '<i class="fa fa-user"></i> ' . $dto->__($lng, "Chat") . '</a>';
                                


                                }
                                echo '</td></tr>';
                            }
                            
                        
                            ?>
                        </tbody>
                    </table>
                    </div><br>
                    <a class="btn-blue" data-toggle="modal" data-target="#modSolictNouPeriodeEspecial"><span class="glyphicon glyphicon-plus"></span> <?php echo $dto->__($lng,"Solicitar Nuevo");?></a>
                </center>
            </section>
            <br><br><br><br><br><br>
        </div>


        </center>
<!-------------------------------------------------------------------------------FINALIZACIÓN DE LA TABLA DE DE PERIODOS ESPECIALES-------------------------------------------------------------------------->





<center>
    <?php foreach ($exception_days as $exception_day)
    {
        echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Días de ' .$exception_day['type_excepcio']  .' año').' '.$any.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'</label><br>';
    }?>
    <br>
    <br>
</center>


        <!br><br><br>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
            <div class="container" style="min-width: 1200px;">  
            <?php for($i=1;$i<=4;$i++) {$diesespecialsmes1s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                   $diesespecials1s[0]+=$diesespecialsmes1s[0];
                   $diesespecials1s[1]+=$diesespecialsmes1s[1];
                   $diesespecials1s[2]+=$diesespecialsmes1s[2];
                   $diesespecials1s[3]+=$diesespecialsmes1s[3];
                   $diesespecials1s[4]+=$diesespecialsmes1s[4];
                   $diesespecials1s[5]+=$diesespecialsmes1s[5];
                   $diesespecials1s[6]+=$diesespecialsmes1s[6];
                   $diesespecials1s[7]+=$diesespecialsmes1s[7];
                   $diesespecials1s[8]+=$diesespecialsmes1s[8];
                   $diesespecials1s[9]+=$diesespecialsmes1s[9];
                   $diesespecials1s[10]+=$diesespecialsmes1s[10];}
            ?>       
        </div><br>
        <div class="container" style="min-width: 1200px;">
            <?php for($i=5;$i<=8;$i++) {$diesespecialsmes2s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                    $diesespecials2s[0]+=$diesespecialsmes2s[0];
                    $diesespecials2s[1]+=$diesespecialsmes2s[1];
                    $diesespecials2s[2]+=$diesespecialsmes2s[2];
                    $diesespecials2s[3]+=$diesespecialsmes2s[3];
                    $diesespecials2s[4]+=$diesespecialsmes2s[4];
                    $diesespecials2s[5]+=$diesespecialsmes2s[5];
                    $diesespecials2s[6]+=$diesespecialsmes2s[6];
                    $diesespecials2s[7]+=$diesespecialsmes2s[7];
                    $diesespecials2s[8]+=$diesespecialsmes2s[8];
                    $diesespecials2s[9]+=$diesespecialsmes2s[9];
                    $diesespecials2s[10]+=$diesespecialsmes2s[10];}            
            ?>        
        </div><!--br-->
        <div class="container" style="min-width: 1200px;">  
            <?php for($i=9;$i<=12;$i++) {$diesespecialsmes1s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                   $diesespecials1s[0]+=$diesespecialsmes1s[0];
                   $diesespecials1s[1]+=$diesespecialsmes1s[1];
                   $diesespecials1s[2]+=$diesespecialsmes1s[2];
                   $diesespecials1s[3]+=$diesespecialsmes1s[3];
                   $diesespecials1s[4]+=$diesespecialsmes1s[4];
                   $diesespecials1s[5]+=$diesespecialsmes1s[5];
                   $diesespecials1s[6]+=$diesespecialsmes1s[6];
                   $diesespecials1s[7]+=$diesespecialsmes1s[7];
                   $diesespecials1s[8]+=$diesespecialsmes1s[8];
                   $diesespecials1s[9]+=$diesespecialsmes1s[9];
                   $diesespecials1s[10]+=$diesespecialsmes1s[10];}
            ?>       
        </div><br>
            </div>
        </div>        
            <br>
            <center>    
            <form method="get" action="EmpleatFitxa.php">
                <button type="submit" class="btn btn-default" name="id" value="<?php echo $id;?>"><span class="glyphicon glyphicon-user"></span> <?php echo $dto->__($lng,"Fitxa");?></button>
            </form>
            <br>
        </center>
    <div class="modal fade" id="modTorns" role="dialog">
            
    </div>        
    <div class="modal fade" id="modAssignaNouHorariTipus" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Assignar Nou Horari per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="assignahoraritipus">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="datainici" required>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select name="idnouhorari">
                    <?php
                        $tipus = $dto->seleccionaHorarisActiusEmpresa($idempresa);
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="assignaHorariTipus(<?php echo $id; ?>,assignahoraritipus.idnouhorari.value,assignahoraritipus.datainici.value,assignahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Assignar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modEditaPeriodeHorariTipus" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Editar Període Horari per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editahoraritipus">
                    <input type="hidden" id="idquadrant" name="idquadrant">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainici" name="datainici" required>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafi" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select id="idnouhorari" name="idnouhorari">
                    <?php
                        $tipus = $dto->seleccionaTipusHoraris($idempresa);
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="editaPeriodeHorari(editahoraritipus.idquadrant.value,editahoraritipus.idnouhorari.value,editahoraritipus.datainici.value,editahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
  



    
<!--------------------------------------------------INICIO MODAL PARA SOLICITAR PERIODOS ESPECIALES------------------------------------------------->

<?php
if(isset($_GET['openModal']) && $_GET['openModal'] == 'true'){
    echo "<script>$(document).ready(function() { $('#modSolictNouPeriodeEspecial').modal('show'); });</script>";
}
?>


<div class="modal fade" id="modSolictNouPeriodeEspecial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content glassmorphism">
    <div class="glassmorphism">
                <h4 style="color:white;" class="modal-title"><?php echo $dto->__($lng,"Solicitar Nuevo Periodo Especial");?></h4>

            </div>
            <div class="modal-body">
                <form name="assignaexcep" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label style="color:black"><?php echo $dto->__($lng,"Data Inici");?>:</label>
                        <input type="date" class="form-control" name="datainici" required>
                    </div>
                    <div class="form-group">
                        <label style="color:black"><?php echo $dto->__($lng,"Data Fi");?>:</label>
                        <input type="date" class="form-control" name="datafi" required>
                    </div>
                    <div class="form-group">
                        <label style="color:black"><?php echo $dto->__($lng,"Tipus");?>:</label>
                        <select class="form-control" name="idtipusexcep" required>
                            <?php
                            $tipus = $dto->seleccionaTipusExcepcions();
                            foreach($tipus as $valor)
                            {
                                $tipusData = $valor["idtipusexcep"]."|".$valor["DocFileReq"];
                                echo '<option value="'.$tipusData.'">'.$dto->__($lng,$valor["nom"]).'</option>';
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group_empleat">
                            <label style="color:black">Comentario:</label>
                            <textarea class="form-control" name="coment_excepcio"></textarea>
                        </div>
                              

                    <input type="hidden" name="MSJrequiredDoc" value="<?php echo $dto->__($lng,"Archivo requerido"); ?>">
                    <input type="hidden" name="MSJDatesInvalid" value="<?php echo $dto->__($lng,"Periodo invalido"); ?>">
                    <div class="form-group"><br>




                    <label style="color:black"><?php echo $dto->__($lng,"Encargado");?>:</label>
                        <select class="form-control" name="idempleat" required>
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

                   
                   <!--
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
-->

                    </div>
                    <div class="form-group">
                        <label style="color:black"><?php echo $dto->__($lng,"Archivos");?>:</label>
                        <input type="file" name="inpFile[]" id="FilesSelect" multiple>
                    </div>

                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="submit" role="button" class="btn_modal" ><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Solicitar");?></button>
                    </form>


                    <br><br>
                    <center>
            <h3><strong>Total Periodos Solicitados</strong></h3>
            </center>
                   

<center>
    <?php foreach ($exception_days as $exception_day)
    {
        echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Días de ' .$exception_day['type_excepcio']  .' aaño').' '.$any.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'</label><br>';
    }?>
    <br>
    <br>
</center>


       



<script>
function toggleSelect() {
  var checkbox = document.getElementById("checkbox");
  var select = document.getElementById("mySelect");

  if (checkbox.checked) {
    select.disabled = false;
  } else {
    select.disabled = true;
  }
}

	function añadirMasArchivos (micarpeta) {

    const assignaexcep_second = document.forms['assignaexcep_second'];
    var inputElement = document.getElementById('FilesSelectSecond');

    var formData = new FormData();
    for (var i = 0; i < inputElement.files.length; i++) formData.append('myFiles[]', inputElement.files[i]);

    // post form data
    const xhr = new XMLHttpRequest()

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) window.location.reload(window.location);
    };

    // log response
    xhr.onload = () => {
        console.log(xhr.responseText)
    }

    // create and send the reqeust
    xhr.open('POST', "Serveis.php?action=añadirMasArchivos&carpeta="+micarpeta, true)
    xhr.send(formData);
}

	function borrarArchivo (micarpeta, namefile)
{
    const xhr = new XMLHttpRequest()
    var formData = new FormData();
    formData.append('namefile', namefile);

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) window.location.reload(window.location);
    };

    // log response
    xhr.onload = () => {
        console.log(xhr.responseText)
    }

    // create and send the reqeust
    xhr.open('POST', "Serveis.php?action=borrarArchivo&carpeta="+micarpeta, true)
    xhr.send(formData);
}



</script>








           
    </div>
  </div>
</div>

<!--------------------------------------------------FINAL MODAL PARA SOLICITAR PERIODOS ESPECIALES------------------------------------------------->









<div class="modal fade" id="modSolictNouPeriodeEspecial" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
           
                    <script type="text/javascript">
                        assignaexcep.addEventListener('submit', e => {
                            // disable default action
                            e.preventDefault()

                             // collect files
                            const inpFile = assignaexcep.querySelector('[id="FilesSelect"]').files
                            const id = assignaexcep.querySelector('[name="id"]').value
                           
                            const tipusdata = assignaexcep.querySelector('[name="idtipusexcep"]').value
                    
                            const tipus =  tipusdata.split('|',2)
        
                            if (tipus[1] == '1'){
                               if(inpFile.length == 0){
                                alert(assignaexcep.querySelector('[name="MSJrequiredDoc"]').value)
                                return
                               } 
                            }

                            const dataini = assignaexcep.querySelector('[name="datainici"]').value
                            const datafi = assignaexcep.querySelector('[name="datafi"]').value
                            const idempleat = assignaexcep.querySelector('[name="idempleat"]').value
                            const coment_excepcio = assignaexcep.querySelector('[name="coment_excepcio"]').value; 
                            const formData = new FormData()

                            const dini = new Date(dataini);
                            const dfin = new Date(datafi);

                            if(dfin<dini){
                                alert(assignaexcep.querySelector('[name="MSJDatesInvalid"]').value)
                                return
                            }

                            for (const file of inpFile) {
                                formData.append("myFiles[]",file)
                            }

                           

                            // post form data
                            const xhr = new XMLHttpRequest()

                            xhr.onreadystatechange = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                window.location.reload(window.location);
                            }
                            };

                            // log response
                            xhr.onload = () => {
                                console.log(xhr.responseText)
                            }

                            // create and send the reqeust
                            xhr.open('POST', "Serveis.php?action=Solicitexcep&id=" + id + "&idtipus=" + tipus[0] + "&dataini=" + dataini + "&datafi=" + datafi+ "&idEncargado=" + <?php echo $idresp; ?>+ "&coment_excepcio=" + encodeURIComponent(coment_excepcio), true)
                            xhr.send(formData)


                            })
                    </script>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimPeriodeHorari" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Eliminar Període Horari");?></h3><br>
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar aquest període horari de");?> <span id="tipushorariaelim"></span></h4>
                    <br><br>
                    <form name="eliminaperiodehorari">
                    <input type="hidden" id="idhorariaelim" name="idhorariaelim">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaPeriodeHorari(eliminaperiodehorari.idhorariaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    <div class="modal fade" id="modExcep" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Editar Període Especial per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editaexcep">
                    <input type="hidden" id="idExcep" name="idExcep">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcep">
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcep"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select id="tipusExcep" name="tipusExcep">
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select>
                    <br><br><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="editaExcep(editaexcep.idExcep.value,editaexcep.tipusExcep.value,editaexcep.datainiexcep.value,editaexcep.datafiexcep.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimExcep" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Eliminar solicitud de periodo");?></h3><br>
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar solicitud de periodo de");?> <span id="tipusexcepaelim"></span></h4>
                    <br><br>
                    <form name="eliminaexcep">
                    <input type="hidden" id="idexcepaelim" name="idexcepaelim">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaExcep(eliminaexcep.idexcepaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    </body>
    
</html>
