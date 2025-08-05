<?php
session_start();

header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

//segurança do ADM
$seguranca = true;
include_once("config/seguranca.php");
seguranca();
//Biblioteca auxiliares
include_once("config/config.php");
include_once("config/conexao.php");
include_once("lib/lib_valida.php");
include_once("lib/lib_funcoes.php");
include_once("lib/lib_botoes.php");
include_once("lib/lib_token.php");
include_once("lib/lib_timezone.php");

include_once("lib/ModEmail.php");
include_once("lib/ModSistema.php");
include_once("lib/ModBaseConhecimento.php");
include_once("lib/ModControleAcesso.php");
include_once("lib/ModInformativo.php");
include_once("lib/ModPagamento.php");

//Load Composer's autoloader
require 'vendor/autoload.php';

//Verificar contratos
VerificarStatusContrato($conn);
//Verificar tempo de senha
VerificarTempSenha($conn);
//Enquete
$ExibirEnquete = tmpEnquete($conn);
//Nome página
$Pagina_Atual = NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn);
//Dados do contrato
$contrato = ListarDadosContrato($_SESSION['contratoUSER'], $conn);

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo dados_sistema("nome_sistema", $conn); ?> | <?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn); ?></title>
  <meta name="description" content="Sistema <?php echo nomeSistema; ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/fontawesome-free/css/font-awesome.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/toastr/toastr.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/dropzone/min/dropzone.min.css">
  <script src="<?php echo pg; ?>/dist/plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/summernote/summernote-bs4.min.css">
  <!-- CodeMirror -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/codemirror/codemirror.css">
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/codemirror/theme/monokai.css">
  <!-- SimpleMDE 
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/simplemde/simplemde.min.css">-->
  <!-- Customização -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/css/custom.css">

  <!-- Import prismjs stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/themes/prism.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/line-highlight/prism-line-highlight.min.css">

  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/ui/trumbowyg.min.css">
  <!-- Import emoji plugin specific stylesheet -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/emoji/ui/trumbowyg.emoji.min.css">
  <!-- Import highlight plugin specific stylesheet -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/highlight/ui/trumbowyg.highlight.min.css">
  <!-- Import table plugin specific stylesheet -->
  <link rel="stylesheet" href="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/table/ui/trumbowyg.table.min.css">

  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/data.js"></script>
  <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?php echo pg; ?>/dist/img/<?php echo dados_sistema("logo_sistema", $conn); ?>" alt="Logo" height="60" width="60">
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Abrir todas mensagens</a>
          </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Abrir todas notificações</a>
          </div>
        </li>

        <!--<li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fa fa-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fa fa-th-large"></i>
        </a>
      </li>-->

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="<?php echo pg; ?>/dist/img/<?php echo dados_sistema("logo_sistema", $conn); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo dados_sistema("nome_sistema", $conn); ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php if (empty($_SESSION['usuarioFOTO'])) { ?>
              <img src="<?php echo pg; ?>/dist/img/user-default-160x160.png" class="img-circle elevation-2" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo pg; ?>/<?php echo $_SESSION['usuarioFOTO']; ?>" class="img-circle elevation-2" alt="User Image">
            <?php } ?>
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo abreviarNomeUsuario($_SESSION['usuarioNOME']); ?></a>
          </div>
        </div>
        <!-- SidebarSearch Form 
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Buscar modulo" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fa fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <?php echo CarregarMenuLateral($_SESSION['usuarioNIVEL'], $conn); ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->

      <div class="sidebar-custom">
        <a href="#" class="btn btn-link text-white">
          <?php if (!empty($contrato['nome_fantasia'])) {
            echo $contrato['nome_fantasia'];
          } ?>
        </a>
        <a href="#" class="btn btn-secondary hide-on-collapse pos-right" data-toggle="modal" data-target="#carregarEnquete">
          <i class="fa fa-sign-out" aria-hidden="true"></i> Sair
        </a>
      </div>
      <!-- /.sidebar-custom -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php
      $url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
      //echo $url;
      $arquivo_original = (!empty($url)) ? $url : 'pages/modulo/home/home';
      $arquivo = limparurl($arquivo_original);
      $file = $arquivo . '.php';
      //echo $arquivo;
      $pagina = "SELECT 
          pg.id_pg,
          pg.nome_pg,
          pg.icon,
          nivpg.id_nvl_pg,
          nivpg.permissao
        FROM 
          paginas pg 
        INNER JOIN 
          niveis_acessos_paginas nivpg on nivpg.pagina_id = pg.id_pg
        WHERE 
          pg.endereco_pg = '$arquivo' 
        AND nivpg.pagina_id = pg.id_pg 
        AND nivpg.niveis_acesso_id = '{$_SESSION['usuarioNIVEL']}' 
        AND nivpg.permissao = 1 
      ";
      $query_pagina = mysqli_query($conn, $pagina);
      if (($query_pagina) and ($query_pagina->num_rows != 0)) {
        $row_pg = mysqli_fetch_assoc($query_pagina);
        if (file_exists($file)) {
          include $file;
        } else {
          include_once("pages/modulo/home/home.php");
        }
      } else { //Se não encontrar nenhuma pagina carregar a home
        //echo 'Seu nivel de acesso não permite acessar esta pagina';
        include_once("pages/modulo/404/404.php");
      }
      ?>
      <div class="modal fade" id="alterarSenhaExpUsuário" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Alterar senha</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body m-3">
              <form id="nova_senha_exp" method="post">
                <div class="form-group">
                  <label class="form-label">Senha atual</label>
                  <input type="password" class="form-control" name="senha_atual" placeholder="Digite a senha atual" required="" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="form-label">Nova senha</label>
                  <input type="password" class="form-control" name="nova_senha" placeholder="Digite a nova senha" required="" autocomplete="off">
                </div>
                <div class="form-group">
                  <label class="form-label">Confirmar senha</label>
                  <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar sua nova senha" required="" autocomplete="off">
                </div>
                <div class="form-group">
                  <?php if ($btn_altera_senha_perfil) { ?>
                    <input type="submit" id="SendUpSenha" class="btn btn-primary" value="Alterar senha">
                  <?php } else { ?>
                    <input type="button" id="SendUpSenha" class="btn btn-primary" value="Alterar senha" disabled="" />
                  <?php } ?>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Carregamento de enquete -->
      <div class="modal fade" id="carregarEnquete" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Enquete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Em sua avaliação, qual o nível de satisfação com a utilização do sistema nesta data?</p>
              <form method="POST" action="<?php echo pg; ?>/pages/modulo/logout/sair">
                <div class="estrelas text-center mb-4">
                  <input type="radio" id="cm_star-empty" name="resultado" value="" checked />
                  <label for="cm_star-1"><i class="fa"></i></label>
                  <input type="radio" id="cm_star-1" name="resultado" value="1" />
                  <label for="cm_star-2"><i class="fa"></i></label>
                  <input type="radio" id="cm_star-2" name="resultado" value="2" />
                  <label for="cm_star-3"><i class="fa"></i></label>
                  <input type="radio" id="cm_star-3" name="resultado" value="3" />
                  <label for="cm_star-4"><i class="fa"></i></label>
                  <input type="radio" id="cm_star-4" name="resultado" value="4" />
                  <label for="cm_star-5"><i class="fa"></i></label>
                  <input type="radio" id="cm_star-5" name="resultado" value="5" />
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="obs" rows="3" placeholder="Deixe um comentário"></textarea>
                </div>
                <hr>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary btn-block" name="SendCadAvaliacao" value="Sair do sistema" />
                  <!--<a href="<?php echo pg; ?>/pages/modulo/logout/sair.php">
                      <button type="button" class="btn btn-primary">Sair do sistema</button>
                  </a>-->
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- Modal Carregamento de enquete -->
      <!-- Direct chat 
    <div class="back-to-top">
      <button type="button" class="btn btn-secondary">
        <i class="fa fa-comment" aria-hidden="true"></i>
      </button>
    </div>   -->
      <!-- Direct chat -->
    </div><!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->

    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Versão <?php echo dados_sistema("versao", $conn); ?>
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2022-<?php echo date('Y'); ?> <a href="<?php echo dados_sistema("site_sistema", $conn); ?>" target="_blank"><?php echo dados_sistema("nome_sistema", $conn); ?></a>.</strong> Todos os direitos reservados.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="<?php echo pg; ?>/dist/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo pg; ?>/dist/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo pg; ?>/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo pg; ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo pg; ?>/dist/plugins/toastr/toastr.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo pg; ?>/dist/plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo pg; ?>/dist/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="<?php echo pg; ?>/dist/plugins/moment/moment.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- jquery maskmoney -->
  <script src="<?php echo pg; ?>/dist/plugins/jquery-maskmoney/jquery.maskMoney.js"></script>
  <!-- date-range-picker -->
  <script src="<?php echo pg; ?>/dist/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?php echo pg; ?>/dist/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo pg; ?>/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="<?php echo pg; ?>/dist/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="<?php echo pg; ?>/dist/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="<?php echo pg; ?>/dist/plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Ekko Lightbox -->
  <script src="<?php echo pg; ?>/dist/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <!-- Filterizr-->
  <script src="<?php echo pg; ?>/dist/plugins/filterizr/jquery.filterizr.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?php echo pg; ?>/dist/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo pg; ?>/dist/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- overlayScrollbars -->
  <script src="<?php echo pg; ?>/dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- Import prismjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
  <!-- Import prismjs line highlight plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/line-highlight/prism-line-highlight.min.js"></script>
  <!-- trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/trumbowyg.min.js"></script>
  <!-- Import Trumbowyg plugins... -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/upload/trumbowyg.upload.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/base64/trumbowyg.base64.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/fontfamily/trumbowyg.fontfamily.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/fontsize/trumbowyg.fontsize.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/history/trumbowyg.history.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/insertaudio/trumbowyg.insertaudio.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/lineheight/trumbowyg.lineheight.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/noembed/trumbowyg.noembed.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/pasteembed/trumbowyg.pasteembed.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/pasteimage/trumbowyg.pasteimage.min.js"></script>
  <!-- Import dependency for Resizimg (tested with version 0.35). For a production setup, follow install instructions here: https://github.com/RickStrahl/jquery-resizable -->
  <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/resizimg/trumbowyg.resizimg.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/table/trumbowyg.table.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/emoji/trumbowyg.emoji.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/colors/trumbowyg.colors.min.js"></script>
  <!-- Import all plugins you want AFTER importing jQuery and Trumbowyg -->
  <script src="<?php echo pg; ?>/dist/plugins/Trumbowyg-main/dist/plugins/highlight/trumbowyg.highlight.min.js"></script>

  <!-- AdminLTE App -->
  <script src="<?php echo pg; ?>/dist/js/adminlte.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo pg; ?>/dist/plugins/summernote/summernote-bs4.min.js"></script>

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo pg; ?>/dist/js/pages/dashboard.js"></script>

  <!-- Funções personalizadas -->
  <script src="<?php echo pg; ?>/dist/js/MinhasFuncoes.js"></script>
  <script src="<?php echo pg; ?>/dist/js/email.js"></script>
  <script src="<?php echo pg; ?>/dist/js/sistema.js"></script>
  <script src="<?php echo pg; ?>/dist/js/controleAcesso.js"></script>
  <script src="<?php echo pg; ?>/dist/js/meuPerfil.js"></script>
  <script src="<?php echo pg; ?>/dist/js/baseConhecimento.js"></script>
  <script src="<?php echo pg; ?>/dist/js/informativo.js"></script>
  <script src="<?php echo pg; ?>/dist/js/pagamento.js"></script>
  <script src="<?php echo pg; ?>/dist/js/quiz.js"></script>
  <script src="<?php echo pg; ?>/dist/js/mod-site.js"></script>
</body>

</html>
