<?php
if (!isset($seguranca)) {
  exit;
}
if (isset($_SESSION['msg'])) {
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
}
//recuperar dados vindo da url
$operacao = filter_input(INPUT_GET, 'operacao', FILTER_SANITIZE_NUMBER_INT);
//consultar fluxos
$cons_fluxo = "SELECT * FROM paginas WHERE id_pg = '$operacao' LIMIT 1";
$query_fluxo = mysqli_query($conn, $cons_fluxo);
$row_fluxo = mysqli_fetch_assoc($query_fluxo);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $Pagina_Atual; ?></h1>
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
        <h5 class="m-0">Formulario editar operação</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_fluxo" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-sm-6">
              <label class="form-label">Nome da operação</label>
              <input type="text" class="form-control" name="nome_processo" placeholder="Fluxo" required autofocus="" value="<?php echo $row_fluxo['nome_pg']; ?>" />
            </div>
            <div class="form-group col-sm-3">
              <label class="form-label">Modulo</label>
              <select class="form-control" name="modulo">
                <option value="">Selecione o modulo</option>
                <?php echo ListarModulosEdit($row_fluxo['modulo_id'], $conn); ?>
              </select>
            </div>
            <div class="form-group col-sm-3">
                <label class="form-label">Icone</label>
                <input type="text" class="form-control" name="icone" placeholder="Icone" autocomplete="off" value="<?php echo $row_fluxo['icon']; ?>"/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-12">
              <label class="form-label">Operação</label>
              <input type="text" class="form-control" name="endereco_fluxo" placeholder="Processo" required="" value="<?php echo $row_fluxo['endereco_pg']; ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-6">
              <label class="form-label">Menu</label>
              <select class="form-control" name="menu">
                <option value="">Selecione o menu</option>
                <?php echo ListarMenuEdit($row_fluxo['menu_lateral'], $conn); ?>
              </select>
            </div>
            <div class="form-group col-sm-6">
              <label class="form-label">Objeto</label>
              <select class="form-control" name="objeto">
                <option value="">Selecione</option>
                <?php echo ListarObjPaginasEdit($row_fluxo['objeto_id'], $conn); ?>
              </select>
            </div>
          </div>
          <input type="hidden" name="fluxo" value="<?php echo $row_fluxo['id_pg']; ?>" />
          <input type="submit" class="btn btn-primary" value="Salvar" name="sendEditFluxo">
          <a href="<?php echo pg; ?>/pages/modulo/sistema/sistema">
            <button type="button" class="btn btn-secondary">Voltar</button>
          </a>
        </form>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->