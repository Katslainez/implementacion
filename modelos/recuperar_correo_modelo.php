<?php


// Importar clases PHPMailer en el espacio de nombres global
// Deben estar en la parte superior de su script, no dentro de una función
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vistas/PHPMailer/Exception.php';
require '../vistas/PHPMailer/PHPMailer.php';
require '../vistas/PHPMailer/SMTP.php';
require '../controladores/funciones.php';


// La creación de instancias y pasar `true` permite excepciones
$mail = new PHPMailer(true);

try{

    if (isset($_POST['usuario2'])) {
    $usuario2=strtoupper(htmlentities(addslashes($_POST["usuario2"])));
    $token=generar_token();
    $fecha_ven_token=date('Y-m-d H:m:s',strtotime('+24 hours'));
    $contador=0;

    
        require '../modelos/conectar.php';
        $sql="SELECT * FROM TBL_USUARIO WHERE USU_USUARIO= :usuario";
        $resultado=$conexion->prepare($sql);	
        $resultado->execute(array(":usuario"=>$usuario2));
        $num_rows = $resultado->fetchColumn();
            
        if ($num_rows==0){ 
            //echo '<script>alert("INTENTELO DE NUEVO");window.location= "../vistas/recuperar_correo.php"</script>';
            echo '<script> Swal.fire({
                position: "center",
                icon: "Error",
                title: "¡ALGO SALIÓ MAL!",
                text:"INTENTELO DE NUEVO",
                showConfirmButton: false,
                timer: 3000
              })
              </script>';
        }else{
    
            $sql2="UPDATE TBL_USUARIO SET USU_TOKEN=:token,USU_FECHA_TOKEN=:fecha_vencimiento WHERE USU_USUARIO=:usuario2";
            $resultado2=$conexion->prepare($sql2);
            $resultado2->execute(array(":token"=>$token,":fecha_vencimiento"=>$fecha_ven_token,":usuario2"=>$usuario2));
           
            $sql3="SELECT * FROM TBL_USUARIO  WHERE USU_USUARIO=:usuario3";
            $resultado3=$conexion->prepare($sql3);
            $resultado3->execute(array(":usuario3"=>$usuario2));
            session_start();
            while($registro=$resultado3->fetch(PDO::FETCH_ASSOC)){	
                
                $_SESSION['id_usu']=$registro['USU_CODIGO'];
                $_SESSION['usu']=$registro['USU_USUARIO'];
                $_SESSION['correo']=$registro['USU_CORREO'];
                $_SESSION['token']=$registro['USU_TOKEN'];
                $_SESSION['fec_venc']=$registro['USU_FECHA_TOKEN'];
            }
         } 
         $sql8="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado8=$conexion->prepare($sql8);	
                        $resultado8->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_usu"],":objeto"=>6,":accion"=>'INGRESO',":descr"=>'INGRESO A LA PANTALLA RECUPERAR CONTRA',":fecha"=>date("Y-m-d H:m:s")));
                        $sql9="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado9=$conexion->prepare($sql9);	
						$resultado9->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_usu"],":objeto"=>6,":accion"=>'CONSULTA',":descr"=>'VERIFICA LAS CREDENCIALES DEL USUARIO',":fecha"=>date("Y-m-d H:m:s")));
         $template=file_get_contents('../vistas/template.php');
         $template=str_replace("{{name}}",$_SESSION['usu'],$template);
         $template=str_replace("{{action_url_1}}","http://localhost:8080/implementacion/vistas/restablecer_contraseña.php?'.$token.'",$template);
         $template=str_replace("{{year}}",date('Y'),$template);
          //Configuración del servidor
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
        $mail->addAddress( $_SESSION['correo'], $_SESSION['usu']);     // Agregar un destinatario
     
    
        // Archivos adjuntos archivos img
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Agregar archivos adjuntos
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Nombre opcional
    
        // Contenido
        $mail->isHTML(true);                                  // Establecer formato de correo electrónico a HTML
        $mail->Subject = 'Recuperar Contraseña';
        $mail->Body    = $template;
        
        //$mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo no HTML';
    
        $mail->send();

        //echo '<script>alert("SE HA ENVIADO UN CORREO ELECTRONICO PARA EL CAMBIO DE CONTRASEÑA. POR FAVOR VERIFICA LA INFORMACION ENVIADA.");window.location= "../vistas/recuperar_correo.php"</script>';
        echo '<script>Swal.fire({
			title: "BIEN!",
			text: "SE HA ENVIADO UN CORREO CORREO ELECTRÓNICO PARA EL CAMNBIO DE CONTRASEÑA. POR FAVOR VERIFIQUE LA INFORMACIÓN",
			icon: "success",
			type: "success"
			}).then(function() {
			window.location = "../vistas/recuperar_correo.php";
			});
        </script>';
    }
        
}catch(Exception $e){
    die('Error: ' . $e->GetMessage());
    echo "Codigo del error" . $e->getCode();
    echo "Hubo un error al enviar el correo: {$mail-> ErrorInfo}";
}