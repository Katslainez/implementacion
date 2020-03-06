<?php
session_start();
if (!isset($_SESSION["id_us"])) {
  header('location:../vistas/login_vista.php');
}
require_once "../modelos/conectar.php"; 
$sql2="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
$resultado2=$conexion->prepare($sql2);	
$resultado2->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_us"],":objeto"=>4,":accion"=>'INGRESO',":descr"=>'INGRESO ALA PANTALLA DE REGISTRAR PREGUNTAS',":fecha"=>date("Y-m-d H:m:s")));            
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Preguntas de seguridad</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../vistas/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../vistas/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../vistas/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="../vistas/Plugins/sweetalert/dist/sweetalert2.min.css">
  <script src="../vistas/Js/jquery-3.4.1.min.js"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <b>Preguntas de Seguridad</b>
  </div>
  <div class="register-box-body">
    <p style="text-align: justify">Seleccione tres preguntas de seguridad. Estas preguntas nos ayudaran a verificar su identidad por si olvida su contraseña.</p><br>

    <form action=" " method="POST" name="form_pregun">
    <div class="form-group has-feedback">
    <select class="form-control" name="id_pre" id="combox">
        <option value="0">SELECCIONE UNA PREGUNTA:</option>
        <?php
        require '../modelos/conectar.php';
          $resultado = $conexion -> query ("SELECT * FROM TBL_PREGUNTAS");
          while ($registro=$resultado->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$registro["PRE_CODIGO"].'">'.$registro["PRE_NOMBRE"].'</option>';
          }
        ?>
       
      </select>
      </div>
    <div class="form-group has-feedback">
        <input id="respuesta" autocomplete="off" type="text" class="form-control" style="text-transform:uppercase" placeholder="RESPUESTA" name="respuesta" >
        <span class="fa fa-reply form-control-feedback"></span>
    </div>
    <div id="alerta8"></div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col text-center">
       
        <div>
        <button type="button" class="btn btn-primary" onclick="validar_pre();">SIGUIENTE</button>
    </div>
           <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="../vistas/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../vistas/Js/Validaciones.js"></script>
<script src="../vistas/plugins/sweetalert/dist/sweetalert2.all.min.js"></script>
<script src="../vistas/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
<?php require"../modelos/preguntas_modelo.php" ?>
