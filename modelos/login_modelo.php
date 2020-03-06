<?php

try{
	require '../modelos/conectar.php';
	if (isset($_POST['login']) && isset($_POST['contra2'])) {
	$login=strtoupper(htmlentities(addslashes($_POST["login"])));
	$password=htmlentities(addslashes($_POST["contra2"]));
	$estado='BLOQUEADO';
	$contador=0;
	$sql="SELECT * FROM TBL_USUARIO WHERE USU_USUARIO= :login";
	$resultado=$conexion->prepare($sql);	
	$resultado->execute(array(":login"=>$login));
	session_start();
	if (!isset($_SESSION['cont_inte'])){
		$_SESSION['cont_inte']=0;
		 } 
		 $sql5='SELECT * FROM TBL_PARAMETROS WHERE PARMT_CODIGO=2';
	        $resultado5=$conexion->query($sql5);	
		     while($registro5=$resultado5->fetch(PDO::FETCH_ASSOC)){			
				$_SESSION['parametro']=	$registro5['PARMT_VALOR'];
            }
		while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){			
				if (password_verify($password,$registro['USU_PASSWORD'])) {
					$_SESSION["id_us"]=$registro['USU_CODIGO'];
					$_SESSION["est"]=$registro['USU_ESTADO'];
					$_SESSION["ROL"]=$registro['ROL_CODIGO'];
					$contador++;
				}	
		}
		if ($contador>0){
		
				if ($_SESSION["est"]=="NUEVO" and $_SESSION["ROL"]==2) {
					    $sql8="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado8=$conexion->prepare($sql8);	
						$resultado8->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'INGRESO',":descr"=>'INGRESO A LA PANTALLA DE LOGIN',":fecha"=>date("Y-m-d H:m:s")));
                         
						$sql9="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado9=$conexion->prepare($sql9);	
						$resultado9->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'CONSULTA',":descr"=>'VERIFICA LAS CREDENCIALES DEL USUARIO',":fecha"=>date("Y-m-d H:m:s")));
				
					header("location:../vistas/preguntas_vista.php"); 
					}elseif ($_SESSION["est"]=="ACTIVO" and $_SESSION["ROL"]==1) {
						$sql2="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado2=$conexion->prepare($sql2);	
						$resultado2->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'INGRESO',":descr"=>'INGRESO A LA PANTALLA DE LOGIN',":fecha"=>date("Y-m-d H:m:s")));

						$sql7="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado7=$conexion->prepare($sql7);	
						$resultado7->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'CONSULTA',":descr"=>'VERIFICA LAS CREDENCIALES DEL USUARIO',":fecha"=>date("Y-m-d H:m:s")));

						header("location:../vistas/mostrar_vista.php"); 
					}elseif ($_SESSION["est"]=="ACTIVO" and $_SESSION["ROL"]==2) {
						$sql10="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado10=$conexion->prepare($sql10);	
						$resultado10->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'INGRESO',":descr"=>'INGRESO A LA PANTALLA DE LOGIN',":fecha"=>date("Y-m-d H:m:s")));

						$sql11="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
						VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
						$resultado11=$conexion->prepare($sql11);	
						$resultado11->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'CONSULTA',":descr"=>'VERIFICA LAS CREDENCIALES DEL USUARIO',":fecha"=>date("Y-m-d H:m:s")));
					header("location:../vistas/index.php");
					
					}elseif ($_SESSION["est"]=="BLOQUEADO" ) {
						echo '<script> Swal.fire({
							position: "center",
							icon: "info",
							title: "SU USUARIO HA SIDO BLOQUEADO. CONTACTE CON EL ADMINISTRADOR",
							showConfirmButton: false,
							timer: 3000
						  })
						  </script>';    
						//header("location:../vistas/login_vista.php");
					}
		
			/*if ($_SESSION["est"]) {
                    switch ($_SESSION["est"]) {
					case 'NUEVO': 
					header("location:../vistas/preguntas_vista.php");  
					break;
					case 'ACTIVO':  
					$sql2="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
		            VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
	                $resultado2=$conexion->prepare($sql2);	
		            $resultado2->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>2,":accion"=>'INGRESO',":descr"=>'INICIO SESION',":fecha"=>date("Y-m-d H:m:s")));
					header("location:../vistas/insertar_mant_vista.php");            
					break;
					case 'BLOQUEADO':  
					echo '<script>alert("TU USUARIO HA SIDO BLOQUEADO CONTACTA CON EL ADNISTRADOR");window.location= "../vistas/login_vista.php"</script>';         
					break;
					default:    
					header("location:../vistas/login_vista.php");     
					break;
                  }
            }else{
                echo "La variable estado no tiene datos";                
              }*/
		}else{
			
				
				if ($_SESSION['cont_inte']<$_SESSION['parametro']){
					++$_SESSION['cont_inte'];
					//echo '<script>alert("USUARIO O CONTRASEÑA INCORRECTA ");window.location= "../vistas/login_vista.php"</script>';
					echo '<script> Swal.fire({
						position: "center",
						icon: "error",
						title: "USUARIO O CONTRASEÑA INCORRECTA",
						showConfirmButton: false,
						timer: 3000
					  })
					  </script>';
				}else {
					$sql3=("UPDATE TBL_USUARIO SET  USU_ESTADO=:estado WHERE USU_USUARIO=:usu");
					$resultado3=$conexion->prepare($sql3);
					$resultado3->execute(array(":estado"=>$estado,":usu"=>$login));
					unset($_SESSION['cont_inte']); 
				   //echo '<script>alert("Has superado el número de intentos y el acceso a esta cuenta ha sido bloqueado. Contacta con el administrador");window.location="../vistas/login_vista.php"</script>';
				   echo '<script> Swal.fire({
					position: "center",
					icon: "warning",
					title: "HAZ SUPERADO EL NÚMERO DE INTENTOS Y EL ACCESO A ESTA CUENTA HA SIDO BLOQUEADO. CONTACTE CON EL ADMINISTRADOR",
					showConfirmButton: false,
					timer: 5000
				  })
				  </script>';     
				}
			   
		}
		$resultado->closeCursor();
		
		}
}catch(Exception $e){
    die('Error: ' . $e->GetMessage());
    echo "Codigo del error" . $e->getCode();
}