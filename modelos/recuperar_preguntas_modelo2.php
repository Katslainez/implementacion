<?php


try{
    require '../modelos/conectar.php';
    if (isset($_POST['id_pre2']) && isset($_POST['respuesta2'])) {
    $id_pre2=$_POST["id_pre2"];
    $respuesta2=strtoupper($_POST["respuesta2"]);
    $estado='BLOQUEADO';
        
        $sql="SELECT * FROM TBL_PREGUNTAS_USUARIO WHERE USU_CODIGO=:id_u AND PRE_CODIGO=:id_pre AND PREUSU_RESPUESTA=:respuesta";
        $resultado=$conexion->prepare($sql);	
        $resultado->execute(array(":id_u"=>$_SESSION["id_u"],"id_pre"=>$id_pre2,":respuesta"=>$respuesta2));
        $num_rows = $resultado->fetchColumn();
            
        if ($num_rows==0){ 
            $sql2=("UPDATE TBL_USUARIO SET  USU_ESTADO=:estado WHERE USU_CODIGO=:id_usu");
            $resultado2=$conexion->prepare($sql2);
            $resultado2->execute(array(":estado"=>$estado,":id_usu"=>$_SESSION["id_u"]));
            // echo '<script>alert("TU USUARIO HA SIDO BLOQUEADO CONTACTA CON EL ADMINISTRADOR");window.location= "../vistas/login_vista.php"</script>';
            echo '<script>Swal.fire({
                title: ¡ALGO SALIO MAL!",
                text: "TU USUARIO HA SIDO BLOQUEADO CONTACTA CON EL ADMINISTRADOR",
                icon: "success",
                type: "success"
                }).then(function() {
                window.location = "../vistas/login_vista.php";
                });
            </script>';
        }else{
            $sql2="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
$resultado2=$conexion->prepare($sql2);	
$resultado2->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_u"],":objeto"=>8,":accion"=>'CONSULTA',":descr"=>'VERIFICAR PREGUNTAS DE SEGURIDAD',":fecha"=>date("Y-m-d H:m:s")));
            header('location:../vistas/restablecer_preguntas_vista.php');
         }  
         
         }
}catch(Exception $e){
    die('Error: ' . $e->GetMessage());
    echo "Codigo del error" . $e->getCode();
}
?>