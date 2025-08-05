<?php
if (!isset($seguranca)) {
    exit;
}
//msg
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
        <h1 class="m-0"><?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING), $conn); ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">Página inicial</li>
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Inicio</a></li>
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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/cadastrar/processa/proc_cad_unidade" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-3">
                        <label class="form-label">Sigla</label>
                        <input type="text" class="form-control" name="sigla_uni" placeholder="Digite ate 3 letras para referenciar esta unidade" required autofocus=""/>
                    </div>
                    <div class="form-group col-9">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome_uni" placeholder="Nome da unidade" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" name="descrico_uni" placeholder="Descrição" rows="3"></textarea>
                </div>
                    <div class="form-group">
                    <label for="pai">Grupo</label>
                    <select class="form-control" name="pai" required="">
                        <option value="">Selecione...</option>
                        <?php echo ListarGruposPai($conn); ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Salvar" name="sendCadastraUnidade">
                <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
                    <button type="button" class="btn btn-secondary">Voltar</button>
                </a>
            </form>
            
          </div>
        </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
