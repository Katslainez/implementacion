<?php


try {
        require '../modelos/conectar.php';
        if (isset($_POST['nueva_contra'])) {
        $token=$_SESSION['token'];
        $id=$_SESSION['id_usu'];
        $fecha_venc=$_SESSION['fec_venc'];
        $nueva_contra= $_POST["nueva_contra"];
        $pass_nueva_cifrado=password_hash($nueva_contra,PASSWORD_DEFAULT,array("cost"=>12));


        $sql="SELECT * FROM TBL_USUARIO WHERE USU_CODIGO=:id_usuario and USU_TOKEN=:token";
        $resultado=$conexion->prepare($sql);	
        $resultado->execute(array(":id_usuario"=>$id,":token"=>$token));
        $num_rows = $resultado->fetchColumn();

        if ($num_rows==0){ 
            header('location:../vistas/login_vista.php');
        }else{
            $fecha_act=date('Y-m-d H:m:s');
            if (strtotime($fecha_act)>strtotime($fecha_venc)) {
               //echo '<script>alert("El codigo de recuperación de contraseña ha experirado expirado");window.location= "../vistas/restablecer_contraseña.php"</script>';
               echo '<script> Swal.fire({
                position: "center",
                icon: "warning",
                title: "EL CÓDIGO DE RECUPERACIÓN DE CONTRASEÑA HA EXPIRADO",
                showConfirmButton: false,
                timer: 3000
              })
              </script>';
            }else{
              $sql2=("UPDATE TBL_USUARIO SET USU_PASSWORD=:nueva,USU_TOKEN=:token,USU_FECHA_TOKEN=:f_venc WHERE USU_CODIGO=:codigo");
              $resultado2=$conexion->prepare($sql2);
              $resultado2->execute(array(":nueva"=>$pass_nueva_cifrado,":token"=>NULL,":f_venc"=>NULL,":codigo"=>$id));
              
              $sql4="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
    VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
    $resultado4=$conexion->prepare($sql4);	
    $resultado4->execute(array(":id"=>NULL,":usuc"=>$id,":objeto"=>7,":accion"=>'UPDATE',":descr"=>'ACTUALIZO LA CONTRASEÑA POR CORREO',":fecha"=>date("Y-m-d H:m:s")));
              session_destroy();
              //echo '<script>alert("SE HA RESTABLECIDO LA CONTRASEÑA CORRECTAMENTE");window.location="../vistas/login_vista.php"</script>';
              echo '<script>Swal.fire({
                title: "BIEN!",
                text: "SE HA REESTABLECIDO LA CONTRASEÑA CORRECTAMENTE",
                icon: "success",
                type: "success"
                }).then(function() {
                window.location = "../vistas/login_vista.php";
                });
            </script>';
            
            } 
             
            }
        
           }
        }catch (Exception $e) {
    echo 'Error: ' . $e->getCode();
    echo "Codigo del error" . $e->getCode();
}
?>