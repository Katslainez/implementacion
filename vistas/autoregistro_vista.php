
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registro de usuarios</title>
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
    <!-- Validacion del ojo -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <link rel="stylesheet" href="../vistas/plugins/sweetalert/dist/sweetalert2.min.css">

  <script src="../vistas/Js/jquery-3.4.1.min.js"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
  <b>Registro de</b> Usuario
    </div>
  <div class="register-box-body">
    <p class="login-box-msg"></p>
    <form action=" " method="POST" name="Form_registrar">
       
    <div class="form-group has-feedback">
      <!--<label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>-->
        <input type="text" autocomplete="off" class="form-control nombres" style="text-transform:uppercase" placeholder="NOMBRES"  name="nombres" id="nombres">
        <span class="	fa fa-id-card form-control-feedback"></span>
      </div>     
      <div class="form-group has-feedback">
        <input type="text" autocomplete="off" class="form-control apellidos"  style="text-transform:uppercase" placeholder="APELLIDOS"  name="apellidos" id="apellidos" >
        <span class="	fa fa-id-card form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" autocomplete="off" style="text-transform:uppercase"  style="text-transform:uppercase" class="form-control usuario" placeholder="USUARIO" name="usuario" id="usuario">
        <span class="	glyphicon glyphicon-user form-control-feedback"></span>
      </div>
  
      <div class="form-group has-feedback">
        <input type="text" autocomplete="off" class="form-control correo" placeholder="CORREO" name="correo" id="correo" >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div id ="alerta"></div>
      <div class="row">
        <div class="col-12 forgot">
        <div style='float:center;margin:auto;width:90px;'><button type="button" class="btn btn-primary btnregistrar" onclick="validar_registro();">REGISTRARSE</button></div>
        </div>     
    </div>
      </div>
    </form>
    <br>
    <div style='float:center;margin:auto;width:185px;'><a>¿YA TIENES USUARIO?    </a><a href="../vistas/login_vista.php">INICIAR SESIÓN</a> </div>
 <br>
  </div>  
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
<?php require"../modelos/autoregistro_modelo.php" ?>