<?php
include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $any = $_POST["any"];
    $numero = $_POST["numero"];
    $id_empleat = $_POST["id_empleat"];
    $any_anterior = $_POST ["any_anterior"];


    $año="";
//AGARRO EL AÑO DE LA FILA DE LA DB 
    $sql = "SELECT any FROM vacances WHERE idempleat = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleat);

// Ejecutar la consulta
$stmt->execute();

// Vincular el resultado a una variable
$stmt->bind_result($año);



// Obtener el resultado
$stmt->fetch();

// Ahora $año contiene el valor de la columna 'any'

// Cerrar la consulta
$stmt->close();

// if($año != $any){
//     $sqlInsert = "INSERT any FROM vacances WHERE idempleat = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $id_empleat);
    
//     // Ejecutar la consulta
//     $stmt->execute();
    
//     // Vincular el resultado a una variable
//     $stmt->bind_result($año);
    
    
    
//     // Obtener el resultado
//     $stmt->fetch();
    
// }

    if ($any_anterior == 0) {
        //perparar insercion y ejecutar
        $sqlUpdate = "UPDATE vacances SET dias_any_anterior = ? WHERE idempleat = ? AND any = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("iii", $numero, $id_empleat, $any);

        
        if ($stmtUpdate->execute()) {
           
            $stmtUpdate->close();
        
            // Redirigir a la sección específica con el valor de $id_empleat
            header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
            exit();
            } else {
                $error = "Error al ejecutar la consulta de inserción: " . $stmtUpdate->error;
            }
        } 
       
    } 

// Preparar y ejecutar la consulta SQL de actualización o inserción
// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Verificar si ya existe una fila con el mismo idempleat y any
$sqlCheck = "SELECT COUNT(*) FROM vacances WHERE idempleat = ? AND any = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id_empleat, $any);
$stmtCheck->execute();
$stmtCheck->bind_result($rowCount);
$stmtCheck->fetch();
$stmtCheck->close();

if ($rowCount > 0) {
    // Si ya existe una fila, realizar una actualización (UPDATE)
    $sqlUpdate = "UPDATE vacances SET total_dias = ? WHERE idempleat = ? AND any = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de actualización: " . $stmtUpdate->error;
    }
} else {
    // Si no existe una fila, realizar una inserción (INSERT)
    $sqlInsert = "INSERT INTO vacances (total_dias, idempleat, any) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $numero, $id_empleat, $any);
    
    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}


// Si la actualización no afectó ninguna fila, entonces realizar la inserción
if ($stmtUpdate->affected_rows == 0) {
    // Preparar y ejecutar la consulta SQL de inserción
    $sqlInsert = "INSERT INTO vacances (idempleat, any, total_dias) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $id_empleat, $any, $numero);

    // Ejecutar la consulta de inserción
    if ($stmtInsert->execute()) {
        $stmtInsert->close();

        // Redirigir a la sección específica con el valor de $id_empleat
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    } else {
        $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
    }
}

// Manejo de errores
if (isset($error)) {
    echo $error;
}

?>
