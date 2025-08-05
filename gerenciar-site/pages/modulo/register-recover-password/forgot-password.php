<?php
session_start();
//Biblioteca auxiliares
include_once("../../../config/config.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo nomeSistema; ?> | Solicitar nova senha</title>
  <meta name="description" content="Esqueceu sua senha? Aqui você pode facilmente recuperar uma nova senha.">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/fontawesome-free/css/font-awesome.min.css">
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
        <p class="login-box-msg">Esqueceu sua senha? Aqui você pode facilmente recuperar uma nova senha.</p>
        <form id="formDataSenhaEmail" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="E-mail" required autocomplete="off" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" id="btnSenhaEmail">Solicitar senha por E-mail</button>
              <button type="button" class="btn btn-primary btn-block" id="btnSenhaWpp" data-toggle="modal" data-target="#modalWpp">Solicitar senha por WhatsApp</button>
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

  <!-- Modal -->
  <div class="modal fade" id="modalWpp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Recuperar senha</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formDataSenhaWpp" method="post">
            <div class="input-group mb-3">
              <input type="number" class="form-control" name="wpp" placeholder="Digite seu número com DDD" required autocomplete="off" autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa fa-whatsapp"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">                
                <button type="submit" class="btn btn-primary" id="btnSenhaWpp">Solicitar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

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