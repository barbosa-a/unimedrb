<?php
if (!isset($seguranca)) {
  exit;
}
if (isset($_SESSION['msg'])) {
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
}
//recuperar valor do nvl passado pela url
$nvl = filter_input(INPUT_GET, 'nvl', FILTER_SANITIZE_NUMBER_INT);
//consultar perfil
$cons_nvl = "SELECT * FROM niveis_acessos WHERE id_nvl = '$nvl' LIMIT 1 ";
$query_cons_nvl = mysqli_query($conn, $cons_nvl);
$row_nvl = mysqli_fetch_assoc($query_cons_nvl);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn); ?>
          <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
            <button type="button" class="btn btn-primary btn-sm">
              <i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar
            </button>
          </a>
        </h1>
        
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Inicio</a></li>
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">Perfil de Acesso</a></li>
          <li class="breadcrumb-item">Permissões</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-4">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Perfil</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <p class=" text-uppercase">
              <b>Nome:</b> <?php echo $row_nvl['nome_nvl']; ?> <br>
              <b>Data:</b> <?php echo date('d/m/Y', strtotime($row_nvl['criado_nvl'])); ?>
            </p>
          </div>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Modulos</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovoModulo" data-card-widget="">
                <i class="fa fa-plus-square"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Permissão</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php echo ListarModulosPerfilAcesso($nvl, $_SESSION['usuarioNIVEL'], $_SESSION['usuarioORDEM'], $conn, $btn_del_nvl); ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Usuários</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Usuário</th>
                  <th>Cargo</th>
                </tr>
              </thead>
              <tbody>
                <?php echo ListarUsuarioPerfilAcesso($nvl, $conn); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-8">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Gerenciar permissões</h5>
            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Modulo ou processo" autocomplete="off" oninput="searchPermission(this.value, <?php echo $nvl ?>)">

                <div class="input-group-append">
                  <button type="button" class="btn btn-default">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="preloader-custom"></div>
            <table id="" class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Objeto</th>
                  <th scope="col">Modulo</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Ação</th>
                </tr>
              </thead>
              <tbody id="result-permission">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal Cadastrar novo modulo-->
<div class="modal fade" id="CadNovoModulo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Novo modulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/cadastrar/processa/proc_cad_nova_permissao" enctype="multipart/form-data">
          <div class="form-group">
            <label for="descrição do modulo">Modulo</label>
            <select class="form-control select2" data-toggle="select2" multiple name="modulo[]" required="">
              <?php echo ListarModulosPerfilAcessoAtual($nvl, $_SESSION['usuarioORDEM'], $conn); ?>
            </select>
          </div>
          <input type="hidden" name="nvl_atual" value="<?php echo $nvl; ?>">
          <input type="submit" class="btn btn-primary" name="sendCadastrarModulo" value="Salvar">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Cadastrar novo modulo-->

<!-- Modal -->
<div class="modal fade" id="sincronPg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Sincronizando...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">
          Aguarde...
        </p>
        <p class="text-center">
          Validando permissões do nivel de acesso
        </p>
      </div>
    </div>
  </div>
</div>