<?php
  if (!isset($seguranca)) {
      exit;
  }
  if (isset($_SESSION['msg'])) {
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
  }
?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn); ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">          
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item">Controle de acesso</li>
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
      <div class="col-3">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="m-0">Menus</h5>
          </div>
          <div class="card-body">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-pesquisar-tab" data-toggle="pill" href="#v-pills-pesquisar" role="tab" aria-controls="v-pills-pesquisar" aria-selected="true">Pesquisar usuário</a>
              <a class="nav-link" id="v-pills-cargos-tab" data-toggle="pill" href="#v-pills-cargos" role="tab" aria-controls="v-pills-cargos" aria-selected="false">Cargos</a>
              <a class="nav-link" id="v-pills-departamentos-tab" data-toggle="pill" href="#v-pills-departamentos" role="tab" aria-controls="v-pills-departamentos" aria-selected="false">Departamentos</a>
              <a class="nav-link" id="v-pills-grupos-tab" data-toggle="pill" href="#v-pills-grupos" role="tab" aria-controls="v-pills-grupos" aria-selected="false">Grupos</a>
              <a class="nav-link" id="v-pills-perfilAcesso-tab" data-toggle="pill" href="#v-pills-perfilAcesso" role="tab" aria-controls="v-pills-perfilAcesso" aria-selected="false">Perfil de acesso</a>
              <a class="nav-link" id="v-pills-unidades-tab" data-toggle="pill" href="#v-pills-unidades" role="tab" aria-controls="v-pills-unidades" aria-selected="false">Unidades</a>
            </div>             
          </div>
        </div>         
      </div>
      <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-pesquisar" role="tabpanel" aria-labelledby="v-pills-pesquisar-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Gerenciamento de usuários</h5>
              </div>
              <div class="card-body">
                <div class="input-group mb-3">
                  <label class="w-100">Pesquisar usuário</label>
                    <input type="text" class="form-control" name="dados_usuario" id="dados_usuario" onkeyup="PesquisarUsuario(this.value);" placeholder="Digite aqui..." autofocus autocomplete="off" />
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary btn-flat" onclick="PesquisarUsuario();">Pesquisar</button>
                      <?php if ($botao_cad_user) { ?>
                        <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/cadastrar/cad_usuario">
                          <button type="button" class="btn btn-primary btn-flat">Incluir</button>
                        </a>
                      <?php }else{ ?>
                        <button type="button" class="btn btn-primary btn-flat" disabled>Incluir</button>
                      <?php } ?> 
                    </span>
                </div>
                <div id="resultado_usuario"></div>                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-cargos" role="tabpanel" aria-labelledby="v-pills-cargos-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Cargos</h5>
              </div>
              <div class="card-body">
                <table id="tbcargos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Departamento</th>
                    <th>Data</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>                      
                    <?php echo listarCargos($botao_edit_cargo, $botao_apagar_cargo, $conn); ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Departamento</th>
                    <th>Data</th>
                    <th>Ações</th>
                  </tr>
                  </tfoot>
                </table>                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-departamentos" role="tabpanel" aria-labelledby="v-pills-departamentos-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Departamentos</h5>
              </div>
              <div class="card-body">
                <table id="tbdepartamento" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </thead>
                  <tbody>                      
                    <?php echo listarDepartamentos($botao_edit_departamento, $botao_apagar_departamento, $conn); ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </tfoot>
                </table>                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-grupos" role="tabpanel" aria-labelledby="v-pills-grupos-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Grupos</h5>
              </div>
              <div class="card-body">
                <table id="tbgrupos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </thead>
                  <tbody>                      
                    <?php echo listarGrupos($botao_edit_grupo, $botao_apagar_grupo, $conn); ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </tfoot>
                </table>                  
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-perfilAcesso" role="tabpanel" aria-labelledby="v-pills-perfilAcesso-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Perfis de acesso</h5>
              </div>
              <div class="card-body">
                <table id="tbperfisacesso" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </thead>
                  <tbody>                      
                    <?php echo listarPerfilAcesso($botao_perm_perfil, $botao_edit_perfil, $botao_apagar_perfil, $_SESSION['usuarioNIVEL'], $_SESSION['usuarioID'], $conn); ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </tfoot>
                </table>                  
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-unidades" role="tabpanel" aria-labelledby="v-pills-unidades-tab">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Unidades</h5>
              </div>
              <div class="card-body">
                <table id="tbunidade" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sigla</th>
                    <th>Nome</th>
                    <th>Grupo</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </thead>
                  <tbody>                      
                    <?php echo listarUnidades($botao_edit_unidade, $botao_apagar_unidade, $conn); ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sigla</th>
                    <th>Nome</th>
                    <th>Grupo</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  </tfoot>
                </table>                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->