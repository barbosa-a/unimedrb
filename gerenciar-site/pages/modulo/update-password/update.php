<?php
//inicializar sessão
session_start();
//Biblioteca auxiliares
include_once("../../../config/config.php");

if (!btnTrocarSenha) {
  die("Impossivel conectar a url");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo nomeSistema; ?> | Atualizar senha</title>
  <meta name="description" content="Você está a apenas um passo de sua nova senha, atualize sua senha agora.">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/fontawesome-free/css/all.min.css">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/sweetalert2/sweetalert2.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b><?php echo nomeSistema; ?></b></a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg fs-7">
          Você está a apenas um passo de sua nova senha, atualize sua senha agora. <br>
          <?php
          if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }
          ?>
        </p>
        <form id="formDataUpdateSenha" method="POST">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="usuario" placeholder="Usuário" required autocomplete="off" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="senha_atual" placeholder="Senha atual" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="nova_senha" placeholder="Nova senha" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar senha" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" class="btn btn-block btn-primary" id="sendRedefinirSenha" name="sendRedefinirSenha" value="Atualizar senha" />
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="row">
          <div class="col">
            <p class="mt-3 mb-1">
              <a href="<?php echo pg; ?>/login.php">Acessar</a>
            </p>
          </div>
          <div class="col">
            <p class="mt-3 mb-1 float-right">
              <a href="<?php echo pg; ?>/pages/modulo/register-recover-password/forgot-password.php">Redefinir senha</a>
            </p>
          </div>
        </div>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo pg; ?>/dist/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo pg; ?>/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- AdminLTE App -->
  <script src="<?php echo pg; ?>/dist/js/adminlte.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo pg; ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo pg; ?>/dist/js/login.js"></script>
</body>

</html>