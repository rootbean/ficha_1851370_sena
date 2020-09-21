<?php

$msg = '';

// Variables para guardar los datos del usuario a registrar
$nombres = '';
$email = '';
$password = '';
$repite_password = '';

if (
  isset($_POST['nombres']) &&
  isset($_POST['email']) &&
  isset($_POST['password']) &&
  isset($_POST['repite_password']) &&
  isset($_POST['terminos'])) {

    echo 'HOla';

    if ($_POST['nombres'] == '') {
      $msg = $msg.'El nombre es requerido! <br>';     // $msg.='El nombre es requerido! <br>';
    }

    if ($_POST['email'] == '') {
      $msg = $msg.'El email es requerido! <br>';
    }

    if ($_POST['password'] == '') {
      $msg = $msg.'La contraseña es requerida! <br>';
    }

    if ($_POST['repite_password'] == '') {
      $msg = $msg.'Debe ingresar nuevamente la contraseña! <br>';
    }

    $nombres = strip_tags($_POST['nombres']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $repite_password = strip_tags($_POST['repite_password']);

    if ($password != $repite_password) {

      $msg = $msg.'Las contraseñas no coinciden! <br>';
    } else if (strlen($password) < 8) {
      $msg = $msg.'La contraseña debe tener mínimo 8 caracteres! <br>';
    } else {

      $password = sha1($password);

      try {
        $connection_bd = new PDO('mysql:host=localhost; dbname=ejemplo_clase_girardota', 'root', '');

        $connection_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $connection_bd->exec('SET CHARACTER SET utf8');

        $sql = "INSERT INTO usuarios(usuarios_nombres, usuarios_email, usuarios_password) VALUES (?, ?, ?)";

        $resultado = $connection_bd->prepare($sql);

        $resultado->execute(array($nombres, $email, $password));

        $msg = 'Usuario registrado correctamente! <br>';
      } catch( Exception $e) {
        die('Error: '.$e->GetMessage());
      } finally {
        $connection_bd = null;
      }

    }

  }

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registrar Usuario</p>

      <form action="register.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nombre" name="nombres">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="repite_password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terminos" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p> <?php echo $msg; ?> </p>
      <a href="login.php" class="text-center">Inicar Sesión</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>
