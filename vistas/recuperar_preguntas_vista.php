<?php
session_start();
//error_reporting(0);
if (!isset($_SESSION['id_u'])) {
  header('location:../vistas/login_vista.php');
   die();
}
require_once "../modelos/conectar.php"; 
$sql2="INSERT  INTO TBL_BITACORA (BIT_CODIGO,USU_CODIGO,OBJ_CODIGO,BIT_ACCION,BIT_DESCRIPCION,BIT_FECHA) 
VALUES (:id,:usuc,:objeto,:accion,:descr,:fecha)";
$resultado2=$conexion->prepare($sql2);	
$resultado2->execute(array(":id"=>NULL,":usuc"=>$_SESSION["id_u"],":objeto"=>8,":accion"=>'INGRESO',":descr"=>'INGRESO ALA PANTALLA DE VERIFICAR PREGUNTAS',":fecha"=>date("Y-m-d H:m:s")));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Recuperación por preguntas</title>
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
    <b>Recuperación por preguntas</b>
  </div>
  <div class="register-box-body">
    <p style="text-align: justify">Ingrese una pregunta y una respuesta de las que recuerde haber registrado para restablecer contraseña</p><br>

    <form action=" " method="POST" name="form_recu" >
    <div class="form-group has-feedback">
    <select class="form-control" name="id_pre2" id="combox2">
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
        <input id="respuesta2" autocomplete="off" type="text" class="form-control" style="text-transform:uppercase" placeholder="RESPUESTA" name="respuesta2" >
        <span class="fa fa-reply form-control-feedback"></span>
    </div>
      <div id="alerta8"></div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col text-center">
        <div><button type="button" class="btn btn-primary" onclick="validar_recu();">VERIFICAR</button>
        
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

<?php require"../modelos/recuperar_preguntas_modelo2.php" ?>
