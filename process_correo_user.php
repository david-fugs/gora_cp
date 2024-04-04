



<?php
include 'Conexion.php';
require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;







if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT user, contrasenya, email, nom, cognom1 FROM empleat WHERE idempleat = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usuario = $row['user'];
        $contrasenya = $row['contrasenya'];
        $correoEmpleado = $row['email'];
        $nombreEmpleado = $row['nom'];
        $apellidoEmpleado = $row['cognom1'];

        $msg = sendUserAndPasswordEmail($correoEmpleado, $usuario, $contrasenya,  $nombreEmpleado );

        
        $nombreCompleto = $nombreEmpleado . ' ' . $apellidoEmpleado;
        header("Location: AdminFitxaEmpleat.php?id=" . $id . "&correo_enviado=1&nombre_empleado=" . urlencode($nombreCompleto));
        exit;
    } else {
        echo "No se encontró información para el empleado con ID: $id";
    }
}



function sendUserAndPasswordEmail($to, $user, $password,  $nombreEmpleado )
{
   

    $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'sebastiand.onyx@gmail.com';             //SMTP username
                $mail->Password   = 'xwxg roml lhzs trur';                   //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
		$mail->CharSet = PHPMailer::CHARSET_UTF8;
                $mail->Port       = 465;

                $mail->setFrom('sebastiand.onyx@gmail.com', 'Grupo-minim.controlpresencia.online');
                $mail->addAddress($to, 'Receptor');

                $mail->isHTML(true);
    $mail->Subject = 'Información de usuario y contraseña';
    $mensaje = "<p>Hola  $nombreEmpleado ,</p>";
    $mensaje .= "<p>Te enviamos la siguiente información para ingresar al Portal del Empleado:</p>";
    $mensaje .= "<ul>";
    $mensaje .= "<li><strong>Usuario:</strong> $user</li>";
    $mensaje .= "<li><strong>Contraseña:</strong> $password</li>";
    $mensaje .= "</ul>";
    $mensaje .= "<strong>Para ingresar al Portal del Empleado por favor da click en el siguiente enlace e ingresa las credenciales:</strong> <a href ='grupo-minim.controlpresencia.online'>Portal del Empleado</a>";
    $mensaje .= '

    <p style="line-height:1.295; margin-bottom:11px">
    <span style="font-size:11pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif">
    <span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal">
    <span style="text-decoration:none">
    Si tienes cualquier duda, podr&iacute;as ponerte en contacto con tu responsable de departamento.
    </span></span></span></span></span></span>
    </p>
    
    <p>&nbsp;</p>
    
    <p style="line-height:1.295; margin-bottom:11px">
    <span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap">
    <span style="font-family:Calibri,sans-serif">
    <span style="color:#0d0d0d">
    <span style="font-weight:400">
    <span style="font-style:normal">
    <span style="text-decoration:none">Plataforma Portal del empleado</span></span></span></span></span></span>
    </p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:11pt; font-variant:normal; white-space:pre-wrap">
    <span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal">
    <span style="text-decoration:none">&nbsp;</span></span></span></span></span></span></p>
    
    <p>&nbsp;</p>
    ';


    $mail->Body = $mensaje;

    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 'Message sent!';
    }
}

?>
