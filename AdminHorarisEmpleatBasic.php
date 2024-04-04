<!DOCTYPE html>
<html>

    <head>
        <?php
        session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        $dto->navResolver();
        ?>
        <style>
        /* Estilo para el select personalizado */

        .btn-next {
            position: relative; /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color:  transparent;
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
            background-color: transparent;
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



        .btn-supersmall {
            padding: 4px 6px; /* Ajusta el espaciado para botones pequeños */
            font-size: 10px; /* Tamaño de fuente más pequeño */
            /* Otros estilos específicos para botones pequeños si es necesario */
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





        /* Estilos para el select personalizado */
        .custom-select {
            appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #f2f2f2; /* Color de fondo del select */
            border: 1px solid #ccc; /* Borde del select */
            padding: 10px; /* Espaciado interno del select */
            border-radius: 5px; /* Radio de borde del select */
            width: 100%; /* Ancho del select */
            cursor: pointer; /* Cambia el cursor al pasar sobre el select */
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





        .select-arrow {
            position: absolute;
            top: 50%;
            right: 10px; /* Ajusta el margen derecho según tu preferencia */
            transform: translateY(-50%);
            pointer-events: none; /* Evita que la flecha sea interactiva */
        }





        /* Estilo para la tabla */
        .glass-table {
            border-collapse: collapse;
            width: 100%;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px); /* Agrega el efecto de desenfoque */
            border: 1px solid rgba(255, 255, 255, 0.18);
        }




        /* Estilo para las celdas de datos */
        .glass-table td {
            background: rgba(255, 255, 255, 0.4); /* Blanco con transparencia */
            color: #333;
            padding: 5px;
            font-size: 15px;

        }

        /* Estilo para las celdas de datos */
        .glass-table th {
            background: rgba(255, 255, 255, 0.4); /* Blanco con transparencia */
            color: #333;
            padding: 5px;
            font-size: 15px;

        }

        /* Estilo para las filas impares */
        .glass-table tr:nth-child(odd) {
            background: rgba(255, 255, 255, 0.3); /* Blanco con más transparencia */
        }

        /* Estilo para las celdas de entrada */



        .glass-table input {
            border: none; /* Elimina el borde predeterminado */
            background: rgba(255, 255, 255, 0.7); /* Fondo con transparencia */
            width: 100%;
            font-size: 15px;
            color: #333;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.6); /* Agrega una sombra */
            transition: background 0.3s, box-shadow 0.6s; /* Agrega una transición suave */
        }

        /* Estilo para los campos de entrada al enfocar (hover) */
        .glass-table input:focus {
            background: rgba(255, 168, 189, 0.9); /* Cambia el fondo al enfocar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); /* Aumenta la sombra al enfocar */
        }


        /* Estilo para los selectores */
        .glass-table select {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 15px;
            color: #333;
        }




        /* Cambiar el color de fondo en hover */
        .glass-table.table-hover tbody tr:hover {
            background-color:rgba(4, 60, 172, 0.1); /* Reemplaza "tu-color-preferido" con el color que desees */
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
    </head>

    <body class="well">

        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_GET["id"];
        $idempresa=$_SESSION["idempresa"];
        $diesnat = $dto->getCampPerIdCampTaula("empresa",$idempresa,"comptadiesnatvac");
        $anys = $dto->mostraAnysContractePerId($id);
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        $nom = $dto->getCampPerIdCampTaula("empleat",$id,"nom");
        $apellido1 = $dto->getCampPerIdCampTaula("empleat",$id,"cognom1");
        $apellido2 = $dto->getCampPerIdCampTaula("empleat",$id,"cognom2");
        $persopt = "";
        $persant = "";
        $persseg = "";
        $idsubemp = $dto->getCampPerIdCampTaula("empleat",$id,"idsubempresa");
        $rspers = $dto->seleccionaEmpPerEmpresaActius($idsubemp);
        $i = 0;
        $idpersant = 0;
        $chkpers = 0;
        foreach($rspers as $rp)
        {
            if(($i==0)&&($id!=$rp["idempleat"])) {$idpersant=$rp["idempleat"];}
            if(($i>0)&&($id==$rp["idempleat"])) {$persant='<button class="btn btn-default btn-lg" name="id" value="'.$idpersant.'" formaction="AdminHorarisEmpleat.php" title="'.$dto->__($lng,"Anterior").'"><span class="glyphicon glyphicon-arrow-left"></span></button>';}
            else{$idpersant=$rp["idempleat"];}
            $persopt.='<option value="'.$rp["idempleat"].'">'.$rp["cognom1"].' '.$rp["cognom2"].' '.$rp["nom"].'</option>';
            if($chkpers==1) {$persseg='<button class="btn btn-default btn-lg" name="id" value="'.$rp["idempleat"].'" formaction="AdminHorarisEmpleat.php" title="'.$dto->__($lng,"Següent").'"><span class="glyphicon glyphicon-arrow-right"></span></button>';$chkpers=0;}
            if(($id==$rp["idempleat"])) {$chkpers=1;}
            $i++;
        }

        //DATA PARA CALENDARIO
        $data = $dto->monthlyEmployeeCalendar($id,$any,$i,16.66,$lng);
        $exception_days = $data['exception_days'];
        $months = $data['months'];
        ?>



        <br><br> <h4 class="text-center"><?php echo $apellido1 . " " . $apellido2 . " " . $nom .  " - " . $any;?></h4> <br><br>

        <div class="container" style="min-width: 1200px;">
            <?php $dto->paintCalendarMonth(1, $months[1], $lng);?>
            <?php $dto->paintCalendarMonth(2, $months[2], $lng);?>
            <?php $dto->paintCalendarMonth(3, $months[3], $lng);?>
            <?php $dto->paintCalendarMonth(4, $months[4], $lng);?>
        </div><br>


        <div class="container" style="min-width: 1200px;">
            <?php $dto->paintCalendarMonth(5, $months[5], $lng);?>
            <?php $dto->paintCalendarMonth(6, $months[6], $lng);?>
            <?php $dto->paintCalendarMonth(7, $months[7], $lng);?>
            <?php $dto->paintCalendarMonth(8, $months[8], $lng);?>
        </div><br>


        <div class="container" style="min-width: 1200px;">
            <?php $dto->paintCalendarMonth(9, $months[9], $lng);?>
            <?php $dto->paintCalendarMonth(10, $months[10], $lng);?>
            <?php $dto->paintCalendarMonth(11, $months[11], $lng);?>
            <?php $dto->paintCalendarMonth(12, $months[12], $lng);?>
        </div><br><br><br>

		
		<div class="container" style="min-width: 1200px;">
            <center>
                <?php foreach ($exception_days as $exception_day)
                {
                    echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Dies de ' .$exception_day['type_excepcio']  .' any').' '.$any.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'</label><br>';
                }
                ?>
            </center>
        </div><br><br>
		
		
		
        <div class="container" style="min-width: 1100px;">

                <center>
                    <h4 class=""><?php echo $dto->__($lng,"Períodes Especials");?>: </h4><br><br>
                    <div>
                        <table class="table" style="text-align: center">
                            <thead>
                            <th style="background-color: #f5f5f5; color: black; text-align: center;"><?php echo $dto->__($lng,"Inici");?></th>
                            <th style="text-align: center; background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng,"Final");?></th>
                            <th style="text-align: center; background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng,"Tipus");?></th>
                            </thead>
                            <tbody>
                            <?php
                            $excepcions = $dto->seleccionaExcepcionsEmpPerId($id, $any);

                            foreach($excepcions as $periode)
                            {
                                $tipus = $periode["nom"];
                                $inicial = substr($periode["nom"],0,4);
                                $datafi = "";
                                if(strtotime($periode["datafinal"])>=strtotime($periode["datainici"])) $datafi = date('d/m/Y',strtotime($periode["datafinal"]));

                                // Verifica si se encontraron colores en la base de datos
                                if ($periode['r'] !== null && $periode['g'] !== null && $periode['b'] !== null) $color = "rgb(" . $periode['r'] . ", " . $periode['g'] . ", " . $periode['b'] . ")";
                                else $color = "rgb(255, 255, 255)";

                                echo '<tr style="background-color: ' . $color . '">';
                                echo '<td>'.date('d/m/Y',strtotime($periode["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td id="nomexcep'.$periode["idexcepcio"].'">'.$dto->__($lng,$tipus).'</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <br>

                </center>

        </div>

    </body>
</html>
