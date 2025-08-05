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
          <li class="breadcrumb-item"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item"><a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">Controle de acesso</a></li>          
          <li class="breadcrumb-item active">Cadastrar novo usuário</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h5 class="m-0">Formulario de cadastro</h5>
      </div>
      <div class="card-body">
        <form id="formDataCadUser">            
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="Nome completo do usuário">Nome completo</label>
                  <input type="text" class="form-control" name="nome_completo" placeholder="Nome completo" required="" autofocus="" oninput="upperCase(event)" />
              </div>
              <div class="form-group col-md-6">
                  <label for="E-mail do usuário">E-mail</label>
                  <input type="email" class="form-control" name="email" placeholder="E-mail" required="">
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                  <label for="Usuário de acesso ao sistema">Usuário</label>
                  <input type="text" class="form-control" name="usuario" placeholder="Nome de usuário" required="" >
              </div>
              <div class="form-group col-md-4">
                  <label for="senha de acesso ao sistema">Senha</label>
                  <input type="password" class="form-control" name="senha" placeholder="Senha de acesso de no mínimo 6 caracteres" required="">
              </div>
              <div class="form-group col-md-4">
                  <label for="Status do usuário">Status</label>
                  <select name="status" class="form-control" required="">
                      <option value="">Selecione...</option>
                      <?php echo statusUsuario($conn) ?>  
                  </select>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="Local de trabalho do usuário">Unidade</label>
                <select name="unidade" class="form-control" required="">
                    <option value="">Selecione...</option>
                    <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                      <option value="<?php echo $row_unidade['id_uni']; ?>"><?php echo $row_unidade['nome_uni']; ?></option> 
                    <?php } ?>                                                           
                </select>
              </div>
              <div class="form-group col-4">
                <label for="Locação ou função do usuário">Cargo</label>
                <select name="cargo" class="form-control" required="">
                  <option value="">Selecione...</option>
                    <?php foreach (cargoUsuario($conn) as $row_cargo) { ?>
                      <option value="<?php echo $row_cargo['id_cargo']; ?>"><?php echo $row_cargo['nome_cargo']; ?></option> 
                    <?php } ?>                    
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="Perfil de acesso do usuário">Perfil de acesso</label>
                <select name="perfil_acesso" class="form-control" required="">
                  <option value="">Selecione...</option>
                  <?php echo perfilUsuario($_SESSION['usuarioNIVEL'], $_SESSION['usuarioORDEM'], $conn) ?>  
                </select>
              </div>                        
          </div>
          <div class="form-row">
            <div class="form-group col-12">
              <label for="Descrição">Descrição</label>
              <textarea name="anotacao" class="form-control" placeholder="Observação do usuário" rows="3"></textarea>
            </div>
          </div>
          <?php if (btnTrocarSenha) { ?>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="sendEmail" name="sendEmail">
              <label class="form-check-label" for="sendEmail">Enviar senha por e-mail</label>
            </div>
          <?php } ?>
          <hr>
          <?php if ($botao_proc_cad_user) { ?>
            <input type="submit" class="btn btn-primary" value="Salvar" name="sendCadastraUser">
          <?php }else{ ?>
            <button type="button" class="btn btn-secondary" disabled>Salvar</button>
          <?php } ?>
          
          <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
            <button type="button" class="btn btn-secondary"><i class="fa fa-chevron-left" aria-hidden="true"></i> Voltar</button>
          </a>
        </form>  
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->