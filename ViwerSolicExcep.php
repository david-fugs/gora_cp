<!DOCTYPE html>
<html>

<head id="header">

    <?php
    session_start();
    include './Pantalles/HeadGeneric.html';
    include 'autoloader.php';
    
    $dto = new AdminApiImpl();
    $dto->navResolver();

    $idemp = $_SESSION["idempresa"];
    $lng = 0;
    if (isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $id = $_SESSION["id"];
    $master = $dto->esMaster($id);
    $idempresa = $idemp;
    $idsubempdef = 0;
    $rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa=' . $idemp . ' limit 1');

    foreach ($rssbe as $se)   $idsubempdef = $se["idsubempresa"];
    
    if (!isset($_GET["idsubemp"])) {
        if (isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
        else if (isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
        else $_GET["idsubemp"] = $idsubempdef;
    }
    $idsubemp = $_GET["idsubemp"];
    $TypeView = $_GET["View"];
    $_SESSION["filtidsubemp"] = $idsubemp;
    if (!isset($_GET["dpt"])) $_GET["dpt"] = 0;
    $dpt = $_GET["dpt"];
    $nomdpt = $dto->__($lng, "Tots");
    if ($dpt != 0) $nomdpt = $dto->__($lng, $dto->getCampPerIdCampTaula("departament", $dpt, "nom"));
    if (!isset($_GET["rol"])) $_GET["rol"] = 0;
    $rol = $_GET["rol"];
    $nomrol = $dto->__($lng, "Tots");
    if ($rol != 0) $nomrol = $dto->__($lng, $dto->getCampPerIdCampTaula("rol", $rol, "nom"));
    if (!isset($_GET["situacio"])) $_GET["situacio"] = 1;
    $situacio = $_GET["situacio"];
    $nomsituacio = "En Plantilla";
    

    switch ($situacio) {
        case 0:
            $nomsituacio = "Cessat";
            break;
        case 2:
            $nomsituacio = "Totes";
            break;
    }

    if ($TypeView != '957')  $FilterTable = "excepcio.idresp = " . $id;
    else  $FilterTable = "excepcio.idresp is not null";


       

        //DATA TABLE
        $tblpers = $dto->getSolicitudPeriodos($FilterTable, $lng,$id);

    ?>




    <style>


.fila{
    font-size: 14px;
}
        .btn-next {
            position: relative;
            /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color: transparent;
            /* Fondo transparente */
            color: black;
            /* Texto transparente */
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Animación suave en todos los cambios */
        }

        .btn-next .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px;
            /* Tamaño de la flecha */
            color: #007bff;
            /* Color de la flecha antes del hover */
            transition: color 0.3s ease;
            /* Animación de cambio de color de la flecha */
        }

        .btn-next .btn-text {
            position: relative;
            z-index: 1;
            /* Coloca el texto del botón sobre la flecha */
        }

        .btn-next:hover {
            background-color: #ff5722;
            /* Cambia el color de fondo durante el hover */
            color: #fff;
            /* Cambia el color del texto durante el hover */
            transform: scale(1.1);
            /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* Agrega una sombra durante el hover */
        }



        .btn-green {
            position: relative;
            /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color: transparent;
            /* Fondo transparente */
            color: black;
            /* Texto transparente */
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Animación suave en todos los cambios */
        }

        .btn-green .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px;
            /* Tamaño de la flecha */
            color: #007bff;
            /* Color de la flecha antes del hover */
            transition: color 0.3s ease;
            /* Animación de cambio de color de la flecha */
        }

        .btn-green .btn-text {
            position: relative;
            z-index: 1;
            /* Coloca el texto del botón sobre la flecha */
        }

        .btn-green:hover {
            background-color: #00cd00;
            /* Cambia el color de fondo durante el hover */
            color: #fff;
            /* Cambia el color del texto durante el hover */
            transform: scale(1.1);
            /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* Agrega una sombra durante el hover */
        }





        .btn-red {
            position: relative;
            /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color: transparent;
            /* Fondo transparente */
            color: black;
            /* Texto transparente */
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Animación suave en todos los cambios */
        }

        .btn-red .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px;
            /* Tamaño de la flecha */
            color: #007bff;
            /* Color de la flecha antes del hover */
            transition: color 0.3s ease;
            /* Animación de cambio de color de la flecha */
        }

        .btn-red .btn-text {
            position: relative;
            z-index: 1;
            /* Coloca el texto del botón sobre la flecha */
        }

        .btn-red:hover {
            background-color: #ec5653;
            /* Cambia el color de fondo durante el hover */
            color: #fff;
            /* Cambia el color del texto durante el hover */
            transform: scale(1.1);
            /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* Agrega una sombra durante el hover */
        }


        .btn-blue {
            position: relative;
            /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color: transparent;
            /* Fondo transparente */
            color: black;
            /* Texto transparente */
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Animación suave en todos los cambios */
        }

        .btn-blue .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px;
            /* Tamaño de la flecha */
            color: #007bff;
            /* Color de la flecha antes del hover */
            transition: color 0.3s ease;
            /* Animación de cambio de color de la flecha */
        }

        .btn-blue .btn-text {
            position: relative;
            z-index: 1;
            /* Coloca el texto del botón sobre la flecha */
        }

        .btn-blue:hover {
            background-color: #0088fa;
            /* Cambia el color de fondo durante el hover */
            color: #fff;
            /* Cambia el color del texto durante el hover */
            transform: scale(1.1);
            /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            /* Agrega una sombra durante el hover */
        }
    </style>


    <script type="text/javascript">
        function CahngeStateSolcExepct(ObserData, SolictID, type, MSJobligt) {

            if (ObserData.value == '') {
                alert(MSJobligt)
                return;
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var lati = pos['lat'];
                    var long = pos['lng'];

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            window.location.reload(window.location);
                        }
                    };

                    ObserData = encodeURI(ObserData.value)

                    xmlhttp.open("GET", "Serveis.php?action=UpdateStateSolicExcep&id=" + SolictID + "&Obs=" + ObserData + "&Type=" + type + "&utm_x=" + lati + "&utm_y=" + long, true);
                    xmlhttp.send();

                }, function() {

                    navigator.permissions.query({
                            name: 'geolocation'
                        })
                        .then(function(permissionStatus) {
                            popuphtml('geolocation permission state is ', permissionStatus.state);

                            permissionStatus.onchange = function() {
                                popuphtml('geolocation permission state has changed to ', this.state);
                            };
                        });
                });
            }


        }
    </script>
</head>

<body class="well">
    <div class="modal fade" id="modContent"></div>
   






    <center>
        <br>
        <div class="row" id="FiltresEmpleats">

            <div class="col-lg-12">
                <div class="col-lg-3">
                    <h2><?php echo $dto->__($lng, "Solicitud de periodos") ?></h2>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <form id="tblpers" onsubmit="event.preventDefault();">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed">
                            <thead>
                                <tr style="background-color: #f5f5f5; color: black; font-size:large;">
                                    <th class="col-lg-2"><?php echo $dto->__($lng, "Empleado"); ?></th>
                                    <th class="col-lg-1"><?php echo $dto->__($lng, "Tipus"); ?></th>
                                    <th class="col-lg-2"><?php echo $dto->__($lng, "Inici"); ?></th>
                                    <th class="col-lg-1"><?php echo $dto->__($lng, "Final"); ?></th>
                                    <th class="col-lg-2"><?php echo $dto->__($lng, "Estado"); ?></th>
                                    <th class="col-lg-2"><?php echo $dto->__($lng, "Comprobante"); ?></th>
                                    <?php
                                    if ($TypeView == '957') {
                                        echo '<th >' . $dto->__($lng, "Responsables") . '</th>';
                                    }
                                    ?>

                                    <th class="col-lg-2" ><?php echo $dto->__($lng, "Acciones"); ?></th>
                                    

                                </tr>
                            </thead>
                            <tbody style="background-color: white; overflow-y: auto">
                                <?php
                                echo $tblpers;
                                ?>
                            </tbody>
                        </table>
                </form>

            </div>

        </div>
    </center>
    </div>

</body>


<script>
    function añadirMasArchivos(micarpeta) {

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
        xhr.open('POST', "Serveis.php?action=añadirMasArchivos&carpeta=" + micarpeta, true)
        xhr.send(formData);
    }


    function borrarArchivo(micarpeta, namefile) {
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
        xhr.open('POST', "Serveis.php?action=borrarArchivo&carpeta=" + micarpeta, true)
        xhr.send(formData);
    }
</script>


</html>