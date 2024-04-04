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
            #modValidarMarcaje {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .custom-select-año {
                appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #f2f2f2; /* Color de fondo del select */
                border: none;/* Borde del select */
                border-radius: 5px; /* Radio de borde del select */
                width: 50%; /* Ancho del select */
                cursor: pointer; /* Cambia el cursor al pasar sobre el select */
                color:#333;
            }

            .custom-select-año option {
                padding: 10px; /* Espaciado interno de las opciones */
                cursor: pointer; /* Cambia el cursor al pasar sobre las opciones */
            }

            /* Estilos para el contenedor del select */
             .custom-select-container-año {
                display: inline-block; /* Alinea el contenedor en línea */
                position: relative; /* Establece una posición relativa para el contenedor */
                width: 90%; /* Ancho del contenedor */
            }

                /* Estilos para el triángulo desplegable (flecha) */
            .custom-select-año::after {
                content: '\25BC'; /* Código Unicode para una flecha hacia abajo */
                position: absolute; /* Posición absoluta en relación con el contenedor */
                top: 50%; /* Alinea la flecha verticalmente en el centro */
                right: 10px; /* Espaciado desde el borde derecho */
                transform: translateY(-50%); /* Alinea la flecha verticalmente en el centro */
                pointer-events: none; /* Evita que la flecha sea clickeable */
            }

            /* Estilos para el select al pasar el cursor sobre él */
            .glass-select-año:hover {
                background-color: #d1ffff; /* Cambia el color de fondo en hover */
                transition: background-color 0.3s, border 0.3s; /* Agrega una transición suave */
                border-radius: 10px;
            }

            .select-arrow-año {
                position: absolute;
                top: 50%;
                right: 10px; /* Ajusta el margen derecho según tu preferencia */
                transform: translateY(-50%);
                pointer-events: none; /* Evita que la flecha sea interactiva */
            }

            .glass-container-año {
                background: rgba(255, 255, 255, 0.2); /* Color de fondo transparente */
                backdrop-filter: blur(10px);
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
            }

            .glass-select-año {
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





            .btn-next {
                position: relative;
                /* Necesario para el posicionamiento de los elementos internos */
                padding: 10px 20px;
                background-color: transparent;
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
                margin-left: 30px;
                margin-left: 30px;
                margin-top: 25px;
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






            .btn-neutro {
                position: relative;
                /* Necesario para el posicionamiento de los elementos internos */
                padding: 10px 20px;
                background-color: transparent;
                color: black;
                /* Texto transparente */
                border: 2px solid rgba(0, 0, 0, 0.3);
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s ease;
                /* Animación suave en todos los cambios */
            }

            .btn-neutro .icon-arrow-right {
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

            .btn-neutro .btn-text {
                position: relative;
                z-index: 1;
                /* Coloca el texto del botón sobre la flecha */
            }

            .btn-neutro:hover {
                background-color: #919191;
                /* Cambia el color de fondo durante el hover */
                color: #fff;
                /* Cambia el color del texto durante el hover */
                transform: scale(1.1);
                /* Aumenta ligeramente el tamaño durante el hover */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                /* Agrega una sombra durante el hover */
            }





            /* Estilos para el select personalizado */
            .custom-select {
                appearance: none;
                /* Elimina los estilos de apariencia nativos del sistema */
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #f2f2f2;
                /* Color de fondo del select */
                border: 1px solid #ccc;
                /* Borde del select */
                padding: 10px;
                /* Espaciado interno del select */
                border-radius: 5px;
                /* Radio de borde del select */
                width: 100%;
                /* Ancho del select */
                cursor: pointer;
                /* Cambia el cursor al pasar sobre el select */
            }

            /* Estilos para el desplegable del select */
            .custom-select option {
                padding: 10px;
                /* Espaciado interno de las opciones */
                cursor: pointer;
                /* Cambia el cursor al pasar sobre las opciones */
            }

            /* Estilos para el contenedor del select */
            .custom-select-container {
                display: inline-block;
                /* Alinea el contenedor en línea */
                position: relative;
                /* Establece una posición relativa para el contenedor */
                width: 100%;
                /* Ancho del contenedor */
            }

            /* Estilos para el triángulo desplegable (flecha) */
            .custom-select::after {
                content: '\25BC';
                /* Código Unicode para una flecha hacia abajo */
                position: absolute;
                /* Posición absoluta en relación con el contenedor */
                top: 50%;
                /* Alinea la flecha verticalmente en el centro */
                right: 10px;
                /* Espaciado desde el borde derecho */
                transform: translateY(-50%);
                /* Alinea la flecha verticalmente en el centro */
                pointer-events: none;
                /* Evita que la flecha sea clickeable */
            }





            .select-arrow {
                position: absolute;
                top: 50%;
                right: 10px;
                /* Ajusta el margen derecho según tu preferencia */
                transform: translateY(-50%);
                pointer-events: none;
                /* Evita que la flecha sea interactiva */
            }





            /* Estilo para la tabla */
            .glass-table {
                border-collapse: collapse;
                width: 100%;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                /* Agrega el efecto de desenfoque */
                border: 1px solid rgba(255, 255, 255, 0.18);
            }




            /* Estilo para las celdas de datos */
            .glass-table td {
                background: rgba(255, 255, 255, 0.4);
                /* Blanco con transparencia */
                color: #333;
                padding: 5px;
                font-size: 15px;

            }

            /* Estilo para las celdas de datos */
            .glass-table th {
                background: rgba(255, 255, 255, 0.4);
                /* Blanco con transparencia */
                color: #333;
                padding: 5px;
                font-size: 15px;

            }

            /* Estilo para las filas impares */
            .glass-table tr:nth-child(odd) {
                background: rgba(255, 255, 255, 0.3);
                /* Blanco con más transparencia */
            }

            /* Estilo para las celdas de entrada */



            .glass-table input {
                border: none;
                /* Elimina el borde predeterminado */
                background: rgba(255, 255, 255, 0.7);
                /* Fondo con transparencia */
                width: 100%;
                font-size: 15px;
                color: #333;
                padding: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.6);
                /* Agrega una sombra */
                transition: background 0.3s, box-shadow 0.6s;
                /* Agrega una transición suave */
            }

            /* Estilo para los campos de entrada al enfocar (hover) */
            .glass-table input:focus {
                background: rgba(255, 168, 189, 0.9);
                /* Cambia el fondo al enfocar */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
                /* Aumenta la sombra al enfocar */
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
                background-color: rgba(4, 60, 172, 0.1);
                /* Reemplaza "tu-color-preferido" con el color que desees */
            }




            .btn-supersmall {
                padding: 2px 5px;
                /* Ajusta el espaciado para botones pequeños */
                font-size: 10px;
                /* Tamaño de fuente más pequeño */
                /* Otros estilos específicos para botones pequeños si es necesario */
            }

            .btn-small {
                padding: 5px 10px;
                /* Ajusta el espaciado para botones pequeños */
                font-size: 14px;
                /* Tamaño de fuente más pequeño */
                /* Otros estilos específicos para botones pequeños si es necesario */
            }

            .btn-medium {
                padding: 10px 15px;
                /* Ajusta el espaciado para botones pequeños */
                font-size: 18px;
                /* Tamaño de fuente más pequeño */
                /* Otros estilos específicos para botones pequeños si es necesario */
            }

            /* Estilo para el fondo del modal */
            .modal-content.glassmorphism {
                background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
                backdrop-filter: blur(10px); /* Efecto de desenfoque */
                border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
                border-radius: 10px; /* Borde redondeado */

                
                top: -50%;
                left: 50%;
                transform: translate(-50%, -30%);
                width: 800px; /* ajusta el ancho según tus necesidades */
                margin-top: 250px;
            }

            /* Estilo para el cuerpo del modal */
            .modal-body {
                background: rgba(255, 255, 255, 0.1); /* Color de fondo con transparencia */
                padding: 20px; /* Espaciado interior */
                overflow: hidden;
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

        <script>
            const showModalValidarMarcaje = (idempleat) => {
                
                const selectElement_any = document.querySelector('select[name="validar_marcajes_año"]');
                const any = selectElement_any.value;

                const form = document.createElement('form');
                form.method = 'GET';
                form.action = 'ValidarMarcaje.php'; // Reemplaza con la URL correcta de tu script PHP
                form.id = 'miFormulario'; // Dale un ID para poder referenciarlo


                const idEmpleadoInput = document.createElement('input');
                idEmpleadoInput.type = 'number';
                idEmpleadoInput.name = 'id';
                idEmpleadoInput.value = idempleat;
                form.appendChild(idEmpleadoInput);

                const anyInput = document.createElement('input');
                anyInput.type = 'text'; // Puedes ajustar el tipo según tu necesidad
                anyInput.name = 'any';
                anyInput.value = any;
                form.appendChild(anyInput);

                document.body.appendChild(form);
            
                form.submit();
            }
        </script>

    </head>

    <body class ="well">

        <?php
            $idempresa = $_SESSION["idempresa"];
            if(isset($_GET['idsubemp'])) $idsubemp = $_GET['idsubemp'];
            if (isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"]; else $lng = 0;
            $id = $_GET["id"];
            if (isset($_GET["any"])) $any = $_GET["any"]; else $any = date("Y");
            if(isset($_GET["noinforme"])) $no_informe = $_GET["noinforme"]; else $no_informe = 0;
            $any_actual = date('Y');
            $anys = [];
            for ($i = $any_actual; $i > $any_actual - 5; $i--) $anys[] = $i;

            $data = $dto->getValidarMarcaje(intval($any), $id);
        ?>
        <center>
            <div class="row">

                <div class ="col-lg-12" style = "margin-top: 5px">

                    <div class="col-lg-2" style="text-align: center;"></div>

                    <div class="col-lg-2" style = "text-align:center;"></div>

                    <div class="col-lg-1">
                        <label> Desde Año:</label>
                        <div class = "custom-select-container-año glass-container-año">
                            <select class="glass-select-año" name="validar_marcajes_año">
                                <option hidden selected value="<?php echo $any; ?>"><?php echo $any; ?></option>
                                <?php foreach($anys as $any): ?>
                                    <option value="<?php echo $any; ?>"><?php echo $any; ?></option>
                                <?php endforeach; ?>
                                
                            </select>
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                    </div>

                    <div class = "col-lg-1"></div>

                    <div class="col-lg-2">
                        <button type="button" onclick="showModalValidarMarcaje(<?php echo $id; ?>)" class="btn-green" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Validar Marcajes"); ?>"><span class="glyphicon glyphicon-zoom-in"></span>
                            Filtrar año
                        </button>
                    </div>

                    <div class = "col-lg-1"></div>


                    <div class="col-lg-1">
                        
                    </div>

                </div>
            </div>
        </center>

        
        <center>
            <div class="modal-dialog modal-sm glassmorphism">
              <div class="modal-content glassmorphism ">
                <div class="modal-body">
                    <h3 style="color:black;"><?php echo "Validar Marcajes"?></h3>
                    
                    <div class="alert alert-success" role="alert" id="success_validacion" style="width: auto; display: none;">
                        <span id="message_success_validacion"></span>
                    </div>

                    <div class="alert alert-danger" role="alert" id="error_validacion" style="width: auto; display: none;">
                        <span id="message_danger_validacion"></span>
                    </div>
                    
                    <?php if($no_informe != 0) : ?>
                        <div class="alert alert-danger" role="alert" id="error_validacion" style="width: auto;">
                            <span> No puede visualizar el informe marcaje aún del mes <?php echo $no_informe; ?> </span>
                        </div>
                    <?php endif ?>

                    <table class="table">
                        <thead>
                            <th style="text-align: center; background-color: #fff; color: black;">Año</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Mes</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Informe Marcaje</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Validar</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Nomina</th>
                        <thead>
                        <tbody style="background-color: white">
                            <?php foreach ($data as $index => $item) : ?>
                                <tr style="font-weight: bold">
                                    <td class="text-center"> <?php echo $item['any']; ?> </td>
                                    <td class="text-center"> <?php echo $item['mes']; ?> </td>
                                    <td class="text-center"> 
                                        <a class="btn btn-primary btn-sm"
                                         href="<?php echo $item['route_marcaje'];?>"
                                         target="<?php echo $item['target'];?>"
                                          >
                                            <i class="fas fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td class="text-center" id="button_validar_<?php echo $index; ?>"> 
                                        <button onclick="validar_marcaje(<?php echo $item['validar'];?>, <?php echo $item['any'];?>, <?php echo $item['mes'];?>, <?php echo $id;?>, <?php echo $index;?>)" type="button" class="btn <?php echo ($item['validar'] == 1) ? 'btn-success' : 'btn-warning'; ?> btn-sm"> 
                                            <?php if($item['validar'] == 0) echo 'validar'; if($item['validar'] == 1) echo'Validado ' .$item['dataregValidacion'];  ?>  
                                        </button> 
                                    </td>
                                    <?php if($item['route_nomina'] !== null) : ?>
                                        <td class="text-center"> 
                                            <a class="btn btn-danger btn-sm" href="<?php echo $item['route_nomina']; ?>" target="_blank"> 
                                                <i class="fas fa-regular fa-file-pdf"></i> pdf 
                                            </a> 
                                        </td>
                                    <?php else : ?>
                                        <td class="text-center"> No nomina </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?> 
                        </tbody>
                    </table>

                </div>
              </div>
            </div>
        </center>
    </body>
    <script>
        const validar_marcaje = (validar,any,mes,id, index) => {
            if(validar == 0)
            {
                //VERIFICAMOS SI SE PUEDE HACER EL MARCAJE
                //Neceistamos verificar si hoy estamos a mas de 4 de dicho mes, si no no
                const date_actual = new Date();
                const dia_actual = date_actual.getDate();
                const mes_actual = date_actual.getMonth() + 1;

                //SI EL MES AÑO ES MAYOR A LA FECHA ACTUAL ERROR
                if(mes_actual > mes || (mes_actual == mes && dia_actual > 4)) methodHTTPValidacionMarcaje(any,mes,id, index); 
                else showMessageValidationError(mes, any);   
            }
        }

        const methodHTTPValidacionMarcaje = (any,mes,id, index) => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4) if(this.status === 200) {console.log(this.responseText); showMessageValidation(mes, any, index);}            
            };
            xmlhttp.open("GET", "updateValidacionMarcaje.php?id="+id+"&any="+any+"&mes="+mes, true);
            xmlhttp.send();
        }

        const showMessageValidation = (mes, any, index) => {  
            document.getElementById("success_validacion").style.display = 'block';
            document.getElementById("message_success_validacion").innerText = "Validacion del mes " +mes + ' ' + any + ' exitosa';
            hideMessage("success_validacion");
            
            const buttonValidar = document.getElementById("button_validar_"+index);
            const fecha_actual = obtenerFechaActual();
            buttonValidar.innerHTML =`<div class="btn btn-success btn-sm">Validado ${fecha_actual}</div>`;
        }

        const obtenerFechaActual = () => {
            const fechaActual = new Date();
            const year = fechaActual.getFullYear();
            const month = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
            const day = fechaActual.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        const showMessageValidationError = (mes,any) => {
            document.getElementById("error_validacion").style.display = 'block';
            document.getElementById("message_danger_validacion").innerText = "No se puede validar el mes " +mes + ' ' + any + ' aún';
            hideMessage("error_validacion");
        }

        const hideMessage = (idcomponente) => {
            setTimeout(() => {
                document.getElementById(idcomponente).style.display = 'none';
            }, 3000);
        }

    </script>
</html>
