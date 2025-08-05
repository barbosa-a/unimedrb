<?php
//inicializar sessão
session_start();
$seguranca = true;
//Biblioteca auxiliares
include_once("../../../config/config.php");
//conexão 
include_once("../../../config/conexao.php");
//token de acesso do usuário
$token = filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if (empty($token)) {
  //token Invalido
  $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <small><i class="icon fas fa-ban"></i> Token não encontrado.</small>
                            </div>';
  header("Location: " . pg . "/login.php");

} else {
  //consultar token
  $pesq_usuario = "SELECT token FROM usuarios WHERE token = '$token' AND ult_token <= DATE_SUB(NOW(),INTERVAL 1 HOUR) LIMIT 1 ";
  $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
  if (($query_pesq_usuario) and ($query_pesq_usuario->num_rows > 0)) {
    $row_usuario = mysqli_fetch_array($query_pesq_usuario);
    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                  <small><i class="icon fas fa-ban"></i> Token expirado</small>
                                </div>';
    header("Location: " . pg . "/login.php");
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo nomeSistema; ?> | Atualizar senha</title>

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
        <form action="<?php echo pg; ?>/pages/modulo/update-password/valida/valida_senha_recover.php" method="POST">
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
              <input type="hidden" name="token" value="<?php echo $token; ?>" />
              <input type="submit" class="btn btn-block btn-primary" name="sendRedefinirSenha" value="Atualizar senha" />
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="<?php echo pg; ?>/login.php">Acessar</a>
        </p>
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
</body>

</html>