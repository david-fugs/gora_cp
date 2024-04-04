<?php
session_start();
include 'autoloader.php';
    //CARGA DE NOMINAS.
    if (isset($_FILES["folder"]) && is_array($_FILES["folder"]["name"])) {

        
        try{
            $any = $_POST['any'];
            $mes = $_POST['mes'];
            
            $ruta_pdf_nomina = "public/nomina/" . $any . "/" . $mes . "/";

            $archivos = $_FILES["folder"]["name"];
            $response_archivo = [];
           
            // Verifica y crea la carpeta del año si no existe
            if (!file_exists("public/nomina/" . $any)) mkdir("public/nomina/" . $any, 0777, true);
            
            // Verifica y crea la carpeta del mes dentro de la carpeta del año si no existe
            if (!file_exists($ruta_pdf_nomina)) mkdir($ruta_pdf_nomina, 0777, true);
            
            foreach ($_FILES["folder"]["name"] as $index => $nombreArchivo) {

             
                
                if (pathinfo($nombreArchivo, PATHINFO_EXTENSION) === 'pdf') {
                    $ruta_destino = $ruta_pdf_nomina . $nombreArchivo;

                    $array_nombre_archivo = preg_split('/[-_]/', $nombreArchivo);
                    $dni = $array_nombre_archivo[0];
                    $dto = new AdminApiImpl();

                    $empleat = [];
                    $empleat = $dto->getDb()->executarConsulta('SELECT * FROM empleat WHERE dni = ' .$dni);
                    
                    $idempleat = '';
                    $nom = '';
                    if(count($empleat) > 0)
                    {
                        $idempleat = $empleat[0]['idempleat'];
                        $nom = $empleat[0]['nom'] .' ' .$empleat[0]['cognom1'] .' ' .$empleat[0]['cognom2'];
                    }

                    // Mueve el archivo a la ruta especificada
                    if (move_uploaded_file($_FILES["folder"]["tmp_name"][$index], $ruta_destino)) $response_archivo[] = [
                        'nombre_archivo' => $nombreArchivo, 
                        'ruta' => $ruta_destino,
                        'status' => 'success',
                        'any' => $any,
                        'mes' => $mes,
                        'idempleat' => $idempleat,
                        'nom' => $nom
                    ];
                    else $response_archivo[] = [
                        'nombre_archivo' => $nombreArchivo, 
                        'ruta' => $ruta_destino,
                        'status' => 'error',
                        'any' => $any,
                        'mes' => $mes,
                        'idempleat' => $idempleat,
                        'nom' => $nom
                    ];
                    
                }
            }

            
            //RESPONSE PARA ADMIN PERSONES PARA MONSTRAR MENSAJE EXITO CARGA O ERROR CARGA
            $_SESSION['archivosSubidos'] = $response_archivo;

            // Redireccionar a la página anterior
            $pagina_anterior = $_SERVER['HTTP_REFERER'];
            header("Location: $pagina_anterior");
            exit;
        } catch (\Exception $e)
        {
            //RESPONSE PARA ADMIN PERSONES PARA MONSTRAR MENSAJE EXITO CARGA O ERROR CARGA
            $_SESSION['archivosSubidos'] = $e->getMessage();
        }
        
    }

?>