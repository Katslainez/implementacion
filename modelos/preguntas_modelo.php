<?php
try {
    require '../modelos/conectar.php';
    if (isset($_POST['id_pre']) && isset($_POST['respuesta'])) {
    $id_pre=$_POST["id_pre"];
    $respuesta=strtoupper($_POST["respuesta"]);
            if (!isset($_SESSION['cont_preg'])){
            $_SESSION['cont_preg']=1;
             }  

            $sql='SELECT * FROM TBL_PARAMETROS WHERE PARMT_CODIGO=1';
	        $resultado=$conexion->query($sql);	
		     while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){			
				$_SESSION['parametro']=	$registro['PARMT_VALOR'];
            }
            
            $sql1="SELECT * FROM TBL_PREGUNTAS_USUARIO WHERE USU_CODIGO=:id AND PRE_CODIGO=:pre";
        $resultado1=$conexion->prepare($sql1);	
        $resultado1->execute(array(":id"=>$_SESSION["id_us"],"pre"=>$id_pre));
        $num_rows1 = $resultado1->fetchColumn();
        if ($num_rows1>0){ 
           // echo '<script>alert("LA PREGUNTA YA ESTA REGISTRADA SELECCIONE UNA DIFERENTE");window.location= "../vistas/preguntas_vista.php"</script>';
           echo '<script> Swal.fire({
			position: "center",
			icon: "error",
			title: "LA PREGUNTA YA ESTÁ REGISTRADA, SELECCIONE UNA DIFERENTE",
			showConfirmButton: false,
			timer: 4000
		  })
		  </script>';
        }else{
           $sql2='INSERT INTO TBL_PREGUNTAS_USUARIO (PRE_CODIGO,USU_CODIGO,PREUSU_RESPUESTA) 
            VALUES (:id_pre,:id_usu,:respuesta)';
            $resultado2=$conexion->prepare($sql2);	
            $resultado2->execute(array("id_pre"=>$id_pre,":id_usu"=>$_SESSION["id_us"],":respuesta"=>$respuesta));

            $sql4="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
            VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
            $resultado4=$conexion->prepare($sql4);	
            $resultado4->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>4,":accion"=>'NUEVO',":descr"=>'REGISTRO PREGUNTAS DE SEGURIDAD',":fecha"=>date("Y-m-d H:m:s")));

            if ($resultado2) {	
             if ($_SESSION['cont_preg']<$_SESSION['parametro']){
                 ++$_SESSION['cont_preg'];
                 header('location:../vistas/preguntas_vista.php');
             }else {
                //echo '<script>alert("SE HA REGISTRADO LA PREGUNTAS Y RESPUESTAS CON EXITO");window.location="../vistas/cambiar_contra_vista.php"</script>';
                echo '<script>Swal.fire({
                    title: "¡BIEN!",
                    text: "SE HA REGISTRADO EXITOSAMENTE SUS PREGUNTAS Y RESPUESTAS",
                    icon: "success",
                    type: "success"
                    }).then(function() {
                    window.location = "../vistas/cambiar_contra_vista.php";
                    });
                </script>';

                unset($_SESSION['cont_preg']);           
             }
            }
        }
        $resultado->closeCursor();
    }
} catch (Exception $e) {
    die('Error: ' . $e->GetMessage());
    echo "Codigo del error" . $e->getCode();
}
?>