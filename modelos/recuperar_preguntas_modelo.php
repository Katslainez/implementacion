<?php

try{
        require '../modelos/conectar.php';
        if (isset($_POST['usuario2'])) {
        $usuario2=strtoupper(htmlentities(addslashes($_POST["usuario2"])));
        $sql="SELECT * FROM TBL_USUARIO WHERE USU_USUARIO= :usuario";
        $resultado=$conexion->prepare($sql);	
        $resultado->execute(array(":usuario"=>$usuario2));
        $num_rows = $resultado->fetchColumn();
            
        if ($num_rows==0){ 
            //echo '<script>alert("INTENTELO DE NUEVO");window.location= "../vistas/recuperar_correo.php"</script>';
        }else{
            $sql2="SELECT * FROM TBL_USUARIO  WHERE USU_USUARIO=:usuario2";
            $resultado2=$conexion->prepare($sql2);
            $resultado2->execute(array(":usuario2"=>$usuario2));
            session_start();
            while($registro=$resultado2->fetch(PDO::FETCH_ASSOC)){	
                $_SESSION['id_u']=$registro['USU_CODIGO'];
            }
            $sql8="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado8=$conexion->prepare($sql8);	
                        $resultado8->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_u"],":objeto"=>6,":accion"=>'INGRESO',":descr"=>'INGRESO A LA PANTALLA RECUPERAR CONTRA',":fecha"=>date("Y-m-d H:m:s")));
                        $sql9="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado9=$conexion->prepare($sql9);	
						$resultado9->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_u"],":objeto"=>6,":accion"=>'CONSULTA',":descr"=>'VERIFICA LAS CREDENCIALES DEL USUARIO',":fecha"=>date("Y-m-d H:m:s")));
        
            header('location:../vistas/recuperar_preguntas_vista.php');
         }   
         $num_rows->closeCursor();
         $resultado2->closeCursor();

         }
}catch(Exception $e){
    die('Error: ' . $e->GetMessage());
    echo "Codigo del error" . $e->getCode();
}
?>