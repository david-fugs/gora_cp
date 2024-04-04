<!DOCTYPE html>
<html>
        <?php
        session_start();
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        include './Pantalles/HeadGeneric.html';
        $dto->navResolver();

        ?>

<head>
    <?php
    if (isset($_GET["tipusexcep"])) $tipusexcep = $_GET["tipusexcep"];
    else $tipusexcep = 'Tots';

    $lng = 0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idempresa = $_SESSION["idempresa"];
    if(!isset($_GET["idsubemp"])){
        if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
        else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
        else $_GET["idsubemp"]="Totes";
    }
    $idsubemp = $_GET["idsubemp"];
    $_SESSION["filtidsubempq"] = $idsubemp;
    $d = strtotime("now");
    if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
    $any = $_GET["any"];
    if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));
    $mes = $_GET["mes"];
    if(!isset($_GET["dpt"]))$_GET["dpt"]="Tots";
    $dpt = $_GET["dpt"];
    $anys = $dto->mostraAnysMarcatges();

    if (isset($_GET["periodo"])) $periodo = $_GET["periodo"];
    else $periodo = 'anual';

    if (isset($_GET["empleat"])) $empleat = $_GET["empleat"];
    else $empleat = 'Tots';

    //EMPLEADOS
    $empleats = $dto->getIdEmployees($idsubemp);
    ?>
    <style>
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
    <script>
        function assignaExcep(id,idtipus,dataini,datafi)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    window.location.reload(window.location);
                }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi + "&tipusexcep=" + <?php echo $tipusexcep; ?>, true);
            xmlhttp.send();
        }

        function showModalDays (data, exception)
        {
            let days = JSON.parse(data);

            $('#modDays').modal('show');
            $('#title_modDays').text('Dias de ' + exception);
            $('#nameEmpleat_modDays').text(days['Persona/Mes']);

            let daysContent = document.getElementById('days_content');
            daysContent.innerHTML = '';

            // Crear la fila inicial
            let initialRow = document.createElement('div');
            initialRow.classList.add('row');

            // Agregar columnas a la fila inicial
            let col1 = document.createElement('div');
            col1.classList.add('col-lg-3');
            initialRow.appendChild(col1);

            let col2 = document.createElement('div');
            col2.classList.add('col-lg-3');
            let strong1 = document.createElement('strong');
            strong1.textContent = 'Mes';
            col2.appendChild(strong1);
            initialRow.appendChild(col2);

            let col3 = document.createElement('div');
            col3.classList.add('col-lg-4');
            let strong2 = document.createElement('strong');
            strong2.textContent = 'Días';
            col3.appendChild(strong2);
            initialRow.appendChild(col3);

            // Agregar la fila inicial a daysContent
            daysContent.appendChild(initialRow);

            //CREO EL BR
            let br = document.createElement('br');
            daysContent.appendChild(br);


            for (let key in days) {
                if (key !== 'Persona/Mes' && key !== 'idempleat') {

                    let dateDiv = document.createElement('div');
                    dateDiv.classList.add('row');

                    //FIRST COL
                    let firstCol = document.createElement('div');
                    firstCol.classList.add("col-lg-3");

                    //CREO EL COL DEL MES
                    let label = document.createElement('div');
                    label.classList.add('col-lg-3');

                   //EN EL LABEL CREO UN STRONG Y LO METO AHI
                     let strong = document.createElement('strong');
                    strong.textContent = (key === 'Total_Dies') ? 'Total dias' : key + ':';
                    label.appendChild(strong);

                    //CREO EL COL DE LA CANTIDAD DE DIAS
                    let label2 = document.createElement('div');
                    label2.classList.add('col-lg-4');

                    //EN EL LABEL2 CREO UN STRONG Y LO METO AHI
                    let strong2 = document.createElement('strong');
                    strong2.textContent = days[key];
                    label2.appendChild(strong2);

                    // Agrega el label e input al div fechaDiv
                    dateDiv.appendChild(firstCol);
                    dateDiv.appendChild(label);
                    dateDiv.appendChild(label2);

                    daysContent.appendChild(dateDiv);

                }
            }
        }

    </script>
</head>

<body class="well">
<div id="content">
    <center>

        <br>



        <div class="row">

            <div class="col-lg-12">

                <div class="col-lg-3">
                    <h2> <?php echo $dto->__($lng,"Informe Periodos Especiales"); ?> </h2>
                </div>

                <div class="col-lg-1">
                    <br>
                    <button class="btn-green" onclick="informe2Excel();" title="Exportar el llistat a Excel"><span class="glyphicon glyphicon-list-alt"></span> Exportar</button>
                </div>

                <div class="col-lg-9 text-right">
                    <h3>
                        <a href="" style="color: black">
                            <p  data-toggle="collapse" href="#filtroCollapse" aria-expanded="false" aria-controls="filtroCollapse">
                                Filtrar
                                <i class="filtro-icon fas fa-chevron-down"></i>
                            </p>
                        </a>
                    </h3>


                    <div class="collapse" id="filtroCollapse">
                        <div class="filtro-content">
                            <div id="filtroCollapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filtroHeading">





                                <div class="panel-body">



                                    <div class="col-lg-2">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <?php
                                                echo '<select class="glass-select" name="idsubemp" onchange="this.form.submit();">
                                                        <option hidden selected value="'.$idsubemp.'">';
                                                if($idsubemp=="Totes") echo $dto->__($lng,$idsubemp);
                                                else echo $dto->mostraNomSubempresa($idsubemp);
                                                echo '</option><option value="Totes">'.$dto->__($lng,"Totes").'</option>';
                                                $resemp = $dto->mostraSubempreses($idempresa);
                                                foreach ($resemp as $emp)
                                                {
                                                    echo '<option value="'.$emp["idsubempresa"].'">'.$emp["nom"].'</option>';
                                                }
                                                echo '</select>';
                                                ?>


                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-2">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <select class="glass-select" name="dpt" onchange="this.form.submit();">
                                                    <option hidden selected value><?php echo $dto->__($lng,$dpt); ?></option>
                                                    <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                                                    <?php
                                                    $resdpt = $dto->mostraNomsDpt($idempresa);
                                                    foreach ($resdpt as $deptm)
                                                    {
                                                        echo '<option value="'.$deptm["nom"].'">'.$deptm["nom"].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-2">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Empleado"); ?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <select class="glass-select" name="empleat" onchange="this.form.submit();">
                                                    <option value="Tots" <?php if ($empleat == "Tots") echo "selected"; ?>><?php echo $dto->__($lng,"Tots");?></option>
                                                    <?php
                                                    foreach ($empleats as $empleatOption) {
                                                        echo '<option value="' . $empleatOption['idempleat'] . '" ' . ($empleat == $empleatOption['idempleat'] ? 'selected' : '') . '>' . $empleatOption['nom'] . ' ' . $empleatOption['cognom1'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-3">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng, "Tipus"); ?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <select class="glass-select" name="tipusexcep" onchange="this.form.submit();">
                                                    <option value="Tots" <?php if ($tipusexcep == "Tots") echo "selected"; ?>><?php echo $dto->__($lng, "-------Seleccionar Tipo-------");?></option>
                                                    <?php
                                                    $idExcepcion = 1000000;
                                                    $selected = ($tipusexcep == $idExcepcion) ? "selected" : "";
                                                    $todos = 'Todos';
                                                    echo '<option value="' . $idExcepcion . '" ' . $selected . '>' . $todos . '</option>';
                                                    $nombresExcepcion = $dto->verNomExcep();
                                                    foreach ($nombresExcepcion as $index => $nombre) {
                                                        $idExcepcion = $index + 1;

                                                        $selected = ($tipusexcep == $idExcepcion) ? "selected" : "";
                                                        echo '<option value="' . $idExcepcion . '" ' . $selected . '>' . $nombre . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-1">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <select class="glass-select" name="any" id="LlistaAnys" onchange="this.form.submit()">
                                                    <option hidden selected value><?php echo $any; ?></option>
                                                    <?php
                                                    foreach($anys as $year)
                                                    {
                                                        echo '<option value:"'.$year["anys"].'">'.$year["anys"].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-1">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Mes");?>:</label><br>
                                            <div class = "custom-select-container glass-container">

                                                <select class="glass-select" name="mes" id="LlistaMesos" onchange="this.form.submit()">
                                                    <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                                                    <?php
                                                    for ($month = 1; $month <= 12; $month++) {
                                                        echo '<option value="' . $month . '"';
                                                        if ($month == $mes) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $dto->__($lng, $dto->mostraNomMes($month)) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="periodo" value="<?php echo $periodo; ?>">
                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-1">
                                        <form action="AdminInformeBaixes.php" method="GET">
                                            <label><?php echo $dto->__($lng,"Periodo");?>:</label><br>
                                            <div class = "custom-select-container glass-container">


                                                <?php
                                                $periodos = [
                                                    'anual'  => 'Anual',
                                                    'semestre' => 'Semestre',
                                                    'cuatrimestre' => 'Cuatrimestre',
                                                    'trimestre' => 'Trimestre',
                                                    'bimestre' => 'Bimestre',
                                                    'mensual' => 'Mensual'
                                                ];

                                                echo '<select class="glass-select" name="periodo" id="LlistaPeriodos" onchange="this.form.submit()">';

                                                foreach ($periodos as $value => $label) {
                                                    $selected = ($value == $periodo) ? "selected" : "";
                                                    echo '<option value="' . $value . '" ' . $selected . ' ';
                                                    echo '>' . $dto->__($lng, $label) . '</option>';
                                                }
                                                echo '</select>';
                                                ?>

                                                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                                <input type="hidden" name="empleat" value="<?php echo $empleat; ?>">
                                                <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                                                <input type="hidden" name="any" value="<?php echo $any; ?>">
                                                <input type="hidden" name="mes" value="<?php echo $mes; ?>">

                                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                                            </div>
                                        </form>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>








        <br>

        <div class="row">
            <div class="col-lg-12">

                <?php

                //DATA PARA UN SOLO TIPO
                if ($tipusexcep != 1000000)
                {
                    //CABECERA DE LA TABLA
                    $header = $dto->headerSpecialPeriodsReport($mes, $any, $periodo);
                    $employees_periods = $dto->dataSpecialPeriodsReport($idsubemp, $dpt, $tipusexcep, $idempresa, $mes, $any, $periodo, $empleat);

                    echo '<table id="tableinforme" name="tableinforme" class="table table-striped table-hover table-condensed" style="text-align:center; width: 100%; "><thead><tr>';
                    foreach ($header as $title) {
                        if ($title == "Persona \ Mes" || $title == "Total Dies")  {
                            echo '<th style="min-width: 40px; text-align: center; background-color: #f5f5f5; color: black">'.$dto->__($lng,$title).'</th>';
                        } else {
                            echo '<th style="min-width: 40px; text-align: center; background-color: #f5f5f5; color: black">'.$title.'</th>';
                        }
                    }
                    echo '</tr></thead>';

                    echo   "<tbody>";

                    foreach ($employees_periods as $employee_periods)
                    {
                        echo "<tr>";
                        foreach ($employee_periods as $key => $employee_period)
                        {
                            //OPCION PARA LA COLUMNA NOMBRE
                            if ($key == 'Persona/Mes') echo '<td style="width:1%; white-space:nowrap;">'.$employee_period.'</td>';

                            //OPCION PARA LA COLUMNA TOTAL DIAS
                            if ($key === 'Total_Dies')
                            {
                                if($employee_period >= 45) echo '<td style="background-color: rgb(255,128,128)"> '.$employee_period.' <td>';
                                else echo '<td>'.$employee_period.'</td>';
                            }

                            //OPCION PARA LOS PERIODOS
                            if ($key != 'Persona/Mes' && $key != 'Total_Dies' && $key != 'idempleat')
                            {
                                if($employee_period > 0) echo '<td style="background-color: rgb(255,128,128)">'.$employee_period.'</td>';
                                else echo '<td>'.$employee_period.'</td>';
                            }

                        }
                        echo "</tr>";
                    }

                    echo "</tbody></table>";
                }

                //PARA TODOS LOS TIPOS
                if ($tipusexcep == 1000000)
                {
                    $header = $dto->allHeaderSpecialPeriodsReport($mes, $any);
                    $allData = $dto->allDataSpecialPeriodsReport($idsubemp, $dpt, $idempresa, $mes, $any, $periodo, $empleat);
                    echo '<table id="tableinforme" name="tableinforme" class="table table-striped table-hover table-condensed" style="text-align:center; width: 100%; "><thead><tr>';
                    foreach ($header as $title) {
                        if ($title == "Persona \ Mes")  {
                            echo '<th style="min-width: 40px; text-align: center; background-color: #f5f5f5; color: black">'.$dto->__($lng,$title).'</th>';
                        } else {
                            echo '<th style="min-width: 40px; text-align: center; background-color: #f5f5f5; color: black">'.$title.'</th>';
                        }
                    }
                    echo '</tr></thead>';


                    foreach ($allData as $empleat)
                    {
                        echo "<tr>";
                        foreach ($empleat as $key => $value)
                        {

                            if ($key == 'Persona/Mes') echo '<td style="width:1%; white-space:nowrap;">'.$value.'</td>';
                            if ($key != 'Persona/Mes') {
                                // Utiliza json_encode para convertir el array a formato JSON y escapa las comillas dobles
                                $encodedArray = htmlspecialchars(json_encode($value['data']), ENT_QUOTES, 'UTF-8');
                                if ($value['value'] > 0) echo '<td style="background-color: rgb(255,128,128); cursor: pointer;" onclick="showModalDays(\'' . $encodedArray . '\', \'' . $key . '\')">' . $value['value'] . '</td>';
                                else echo '<td style="cursor: pointer;" onclick="showModalDays(\'' . $encodedArray . '\', \'' . $key . '\')">' . $value['value'] . '</td>';
                            }

                        }
                        echo "</tr>";
                    }
                }

                ?>

                </table>
            </div>
        </div>

    </center>
</div>



<div class="modal fade" id="modDays" role="dialog">
    <center>
        <div class="modal-dialog">
            <div class="modal-content glassmorphism">
                <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white"></h3></div>
                <div class="modal-body">
                    <h4 id="title_modDays"></h4><br>
                    <h5 id="nameEmpleat_modDays"></h5><br>
                        <div id="days_content" class="justify-content-center align-items-center"></div>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Salir"); ?></button>
                </div>
            </div>
        </div>
    </center>
</div>



</body>

</html>
