<!DOCTYPE html>
<html>
    <?php
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        $lng = 0;
        session_start();
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = intval($_GET['id']);
        $idsubemp = $dto->getCampPerIdCampTaula("empleat",$id,"idsubempresa");
        $sbe = $dto->mostraSubempreses($dto->mostraIdEmpresaPerIdEmpleat($id));


        if(isset($_GET['any'])) $any = $_GET['any']; else $any = date('Y');
        if(isset($_GET['mes'])) $mes = $_GET['mes']; else $mes = date('m');

        $data = $dto->getValidarMarcaje(intval($any), $id);

    ?>

    <center>
        <style>
            /* Estilo para el fondo del modal */
            .modal-content.glassmorphism {
                background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
                backdrop-filter: blur(10px); /* Efecto de desenfoque */
                border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
                border-radius: 10px; /* Borde redondeado */

                position: relative;
                top: -50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 800px; /* ajusta el ancho según tus necesidades */
                margin-top: 250px;
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

            <div class="modal-dialog modal-sm glassmorphism">
              <div class="modal-content glassmorphism ">
                <div class="text-right" style="cursor: true;"><span class='glyphicon glyphicon-remove' data-dismiss="modal"></span></div>
                <div class="modal-body">
                    <h3 style="color:black;"><?php echo "Validar Marcajes"?></h3><br>

                    <table class="table">
                        <thead>
                            <th style="text-align: center; background-color: #fff; color: black;">Año</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Mes</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Ver Marcaje</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Validar</th>
                            <th style="text-align: center; background-color: #fff; color: black;">Nomina</th>
                            
                        <thead>
                        <tbody style="background-color: white">
                            <?php foreach ($data as $item) : ?>
                                
                                <tr style="font-weight: bold">
                                <td class="text-center"> <?php echo $item['any']; ?> </td>
                                <td class="text-center"> <?php echo $item['mes']; ?> </td>
                                <td class="text-center"> <a class="btn btn-primary btn-sm" href="<?php echo $item['route_marcaje']; ?>" target="_blank"><i class="fas fa-eye"></i> </a> </td> </td>
                                <td class="text-center"> <button onclick="validar_marcaje_desde_fitxa(<?php echo $item['validar'];?>, <?php echo $item['any'];?>, <?php echo $item['mes'];?>, <?php echo $id;?>)" type="button" class="btn <?php echo ($item['validar'] == 1) ? 'btn-success' : 'btn-warning'; ?> btn-sm"> <?php if($item['validar'] == 0) echo 'validar'; if($item['validar'] == 1) echo'Validado ' .$item['dataregValidacion'];  ?>  </button> </td>
                                <?php if($item['route_nomina'] !== null) : ?>
                                    <td class="text-center"> <a class="btn btn-danger btn-sm" href="<?php echo $item['route_nomina']; ?>" target="_blank"> <i class="fas fa-regular fa-file-pdf"></i> pdf </a> </td>
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
    
</html>
