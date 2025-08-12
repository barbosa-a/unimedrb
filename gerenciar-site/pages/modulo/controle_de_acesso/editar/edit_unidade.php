<?php
if (!isset($seguranca)) {
  exit;
}
if (isset($_SESSION['msg'])) {
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
}
//recuperar dados vindo da url
$unidade = filter_input(INPUT_GET, 'unidade', FILTER_SANITIZE_NUMBER_INT);
//consultar unidades
$cons_unidade = "SELECT * FROM unidade WHERE id_uni = '$unidade' LIMIT 1 ";
$query_unidade = mysqli_query($conn, $cons_unidade);
$row_unidade = mysqli_fetch_array($query_unidade);
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
        <h5 class="m-0">Formulario editar cadastro</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_unidade" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-3">
              <label class="form-label">Sigla</label>
              <input type="text" class="form-control" name="sigla_uni" placeholder="Digite ate 3 letras para referenciar esta unidade" required autofocus="" value="<?php echo $row_unidade['sigla_uni']; ?>">
            </div>
            <div class="form-group col-9">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" name="nome_uni" placeholder="Nome da unidade" required="" value="<?php echo $row_unidade['nome_uni']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descrico_uni" placeholder="Descrição" rows="3"><?php echo $row_unidade['descricao_uni']; ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Endereço</label>
            <textarea class="form-control" name="endereco" placeholder="Logradouro" rows="2"><?php echo $row_unidade['endereco']; ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Horário de funcionamento</label>
            <textarea class="form-control" name="horario" placeholder="Horário" rows="2"><?php echo $row_unidade['horario']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="pai">Grupo</label>
            <select class="form-control" name="pai" required="">
              <option value="">Selecione...</option>
              <?php echo ListarGruposPaiEdit($row_unidade['grupo_id'], $conn); ?>
            </select>
          </div>
          <input type="hidden" name="unidade" value="<?php echo $row_unidade['id_uni']; ?>">
          <input type="submit" class="btn btn-primary" value="Salvar" name="sendEditarUnidade">
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