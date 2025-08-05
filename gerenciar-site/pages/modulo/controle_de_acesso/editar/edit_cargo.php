<?php
if (!isset($seguranca)) {
    exit;
}
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
//recuperar dados vindo da url
$cargo = filter_input(INPUT_GET, 'cargo', FILTER_SANITIZE_NUMBER_INT);
//consultar cargo
$cons_cargo = "SELECT * FROM cargo WHERE id_cargo = '$cargo' ORDER BY id_cargo ASC ";
$query_cons_cargo = mysqli_query($conn, $cons_cargo);
$row_cons_cargo = mysqli_fetch_array($query_cons_cargo);

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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_cargo" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Nome do grupo">Nome</label>
                    <input type="text" class="form-control" name="nome_cargo" required="" autofocus="" autocomplete="off" placeholder="Nome do cargo" value="<?php echo $row_cons_cargo['nome_cargo']; ?>">
                </div>
                <div class="form-group">
                    <label for="Nome do grupo">Departamento</label>
                    <select class="form-control" name="departamento" required="">
                        <option value="">Selecione</option>
                        <?php echo ListarDepartamentoEdit($row_cons_cargo['departamento'], $conn); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descrição do grupo">Descrição</label>
                    <textarea class="form-control" name="descricao_cargo" placeholder="Descrição" rows="3" ><?php echo $row_cons_cargo['descricao_cargo']; ?></textarea>
                </div>
                <input type="hidden" name="cargo" value="<?php echo $row_cons_cargo['id_cargo']; ?>" >
                <input type="submit" class="btn btn-primary" name="sendEditarCargo" value="Salvar">
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



