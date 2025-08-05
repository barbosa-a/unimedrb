<?php
    //inicializar sessão
    session_start();
    //Biblioteca auxiliares
    include_once("config/config.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo nomeSistema; ?> | Login</title>
  <meta name="description" content="Login de acesso | área administrativa do site <?php echo nomeSistema; ?>">
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
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <p class="login-box-msg">
        Faça login para iniciar sua sessão
        <?php
          if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }
        ?>
      </p>

      <form id="formDataLogin" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="usuario" placeholder="Login de acesso" autofocus autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="senha" placeholder="Senha de acesso" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block" id="btnLogin">
              <i class="fas fa-unlock" aria-hidden="true"></i> Acessar
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="row text-center mt-2 mb-3">
        <?php if (btnTrocarSenha) { ?>
        <div class="col">
          <a href="<?php echo pg; ?>/pages/modulo/update-password/update.php" class="btn btn-block btn-primary">
            <i class="fa fa-key mr-2"></i> Trocar senha
          </a>
        </div>
        <?php } ?>
        <?php if (btnCadastro) { ?>
          <div class="col">
            <a href="<?php echo pg; ?>/pages/modulo/clientes-sistema/novo-cadastro.php" class="btn btn-block btn-primary">
              <i class="fa fa-user-plus mr-2"></i> Cadastre-se
            </a>
          </div>
        <?php } ?>
      </div>
      <!-- /.social-auth-links -->
      <?php if (btnTextoRodape) { ?>
        <div class="text-center text-muted"><?php echo textoRodape; ?></div>
      <?php } ?>
      <?php if (btnSubTextoRodape) { ?>
        <div class="text-center text-muted"><?php echo subTextoRodape; ?></div>
      <?php } ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
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
