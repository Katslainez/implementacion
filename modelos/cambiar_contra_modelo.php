<?php

try {
    require '../modelos/conectar.php';
    if (isset($_POST['nueva_contra'])) {
    $id_usu=$_SESSION['id_us'];
    $nueva_contra= $_POST["nueva_contra"];
    $pass_nueva_cifrado=password_hash($nueva_contra,PASSWORD_DEFAULT,array("cost"=>12));
    $estado='ACTIVO';
    
    $sql=("UPDATE TBL_USUARIO SET USU_PASSWORD=:nueva, USU_ESTADO=:estado WHERE USU_CODIGO=:id_usu");
    $resultado=$conexion->prepare($sql);
    $resultado->execute(array(":nueva"=>$pass_nueva_cifrado, ":estado"=>$estado,":id_usu"=>$id_usu));
    
    $sql4="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
    VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
    $resultado4=$conexion->prepare($sql4);	
    $resultado4->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>5,":accion"=>'UPDATE',":descr"=>'ACTUALIZO CONTRASEÑA',":fecha"=>date("Y-m-d H:m:s")));
    session_destroy();
    //echo '<script>alert("SE HA CAMBIADO LA CONTRASEÑA CORRECTAMENTE");window.location="../vistas/login_vista.php"</script>';
    echo '<script>Swal.fire({
        title: "BIEN!",
        text: "SE HA CAMBIADO LA CONTRASEÑA CORRECTAMENTE",
        icon: "success",
        type: "success"
        }).then(function() {
        window.location = "../vistas/login_vista.php";
        });
    </script>';
    $resultado->closeCursor();

       }

    }catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    echo "Codigo del error" . $e->getCode();
}
?>