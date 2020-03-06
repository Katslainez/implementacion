<?php	

// Importar clases PHPMailer en el espacio de nombres global
// Deben estar en la parte superior de su script, no dentro de una función
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vistas/PHPMailer/Exception.php';
require '../vistas/PHPMailer/PHPMailer.php';
require '../vistas/PHPMailer/SMTP.php';

// La creación de instancias y pasar `true` permite excepciones
$mail = new PHPMailer(true);
//creo un token 

$caracteres='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$pass ="";
for($i=0;$i<8;$i++) {
$pass .=substr($caracteres,rand(0,53),1);
}


	try{
		require '../modelos/conectar.php';
		if (isset($_POST['nombres']) && isset($_POST['apellidos'])&& isset($_POST['usuario'])&& isset($_POST['correo'])) {
	 $idrol=2;
     $nombres= strtoupper ($_POST["nombres"]);
     $apellidos=strtoupper ( $_POST["apellidos"]);
     $usuario= strtoupper($_POST["usuario"]);
     $pass_cifrado=password_hash($pass,PASSWORD_DEFAULT,array("cost"=>12));
     $estado="NUEVO";
     $fecha_creacion= date("Y-m-d H:m:s");
     $fecha_vencimiento= date("Y-m-d H:m:s",strtotime("+1 years"));
     $correo= $_POST["correo"];
		$consulta=$conexion->prepare("SELECT * FROM TBL_USUARIO WHERE USU_USUARIO='$usuario'");
        $consulta->execute();
        $num_rows = $consulta->fetchColumn();
       if ($num_rows>0){ 
		  //echo '<script>alert("Usuario ya se encuentran registrado");window.location= "../vistas/autoregistro_vista.php"</script>';	  
		  echo '<script> Swal.fire({
			position: "center",
			icon: "error",
			title: "USUARIO YA SE ENCUENTRA REGISTRADO",
			showConfirmButton: false,
			timer: 3000
		  })
		  </script>';
		}else{
		$template_correo=file_get_contents('../vistas/template_correo.php');
		$template_correo=str_replace("{{pass}}",$pass,$template_correo);
		$template_correo=str_replace("{{year}}",date('Y'),$template_correo);
		
		$mail->SMTPDebug = 0;                       // Habilitar salida de depuración detallada
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();                                            // Enviar usando SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Configure el servidor SMTP para enviar a través de
		$mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
		$mail->Username   = 'system32unah@gmail.com';                     // SMTP usuario
		$mail->Password   = 'coronavirus2020';                               // SMTP contraseña
		$mail->SMTPSecure = 'tsl';         // Habilitar el cifrado TLS; `PHPMailer :: ENCRYPTION_SMTPS` también aceptado
		$mail->Port       = 587;                                    // Puerto TCP para conectarse

		//Destinatarios
		$mail->setFrom('system32unah@gmail.com', 'System32');    //desde donde se va enviar
		$mail->addAddress( $correo);     // Agregar un destinatario

		$mail->isHTML(true);                                  // Establecer formato de correo electrónico a HTML
		$mail->Subject = 'Recuperar Contraseña';
		$mail->Body    = $template_correo;

		$mail->send();
		   
	   $sql="INSERT INTO TBL_USUARIO (ROL_CODIGO,USU_USUARIO,USU_NOMBRES,USU_APELLIDOS,USU_PASSWORD,USU_ESTADO,USU_PREGUNTAS_CONTESTADAS,USU_PRIMER_INGRESO,USU_FECHA_CREACION,USU_FECHA_VENCIMIENTO,USU_TOKEN,USU_FECHA_TOKEN,USU_CORREO) 
	   VALUES (:rol,:usuario,:nombres,:apellidos,:contra,:estado,'','',:fecha_creacion,:fecha_vencimiento,'','',:correo)";
	
	   $resultado=$conexion->prepare($sql);	
       $resultado->execute(array(":rol"=>$idrol,":usuario"=>$usuario,":nombres"=>$nombres,":apellidos"=>$apellidos,":contra"=>$pass_cifrado,":estado"=>$estado,":fecha_creacion" =>$fecha_creacion, ":fecha_vencimiento"=>$fecha_vencimiento,":correo"=>$correo));
	   if ($resultado) {
		//echo '<script>alert("Se ha registrado exitosamente,revise su correo electronico");window.location= "../vistas/login_vista.php"</script>';
		echo '<script>Swal.fire({
			title: "¡BIEN!",
			text: "SE HA REGISTRADO EXITOSAMENTE, REVISE SU CORREO ELECTRÓNICO.",
			icon: "success",
			type: "success"
			}).then(function() {
			window.location = "../vistas/login_vista.php";
			});
		</script>';
	   } else {
		//echo '<script>alert("Error al registrarse");window.location= "../vistas/autoregistro_vista.php"</script>';	
		echo '<script> Swal.fire({
			position: "center",
			icon: "Error",
			title: "¡ALGO SALIÓ MAL!",
			text:"ERROR AL REGISTRARSE",
			showConfirmButton: false,
			timer: 3000
		  })
		  </script>';
		}
		$resultado->closeCursor();
	}
	  }
	}catch(Exception $e){			
		
        die('Error: ' . $e->GetMessage());
		echo "Codigo del error" . $e->getCode();	
	}

?>
</body>
</html>