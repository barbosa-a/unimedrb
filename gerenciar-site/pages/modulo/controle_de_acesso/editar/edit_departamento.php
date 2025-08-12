<?php
    if (!isset($seguranca)) {
        exit;
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    //recuperar dados vindo da url
    $departamento = filter_input(INPUT_GET, 'departamento', FILTER_SANITIZE_NUMBER_INT);
    //consultar departamento
    $cons_departamento = "SELECT * FROM departamento WHERE id_depar = '$departamento' LIMIT 1 ";
    $query_depar = mysqli_query($conn, $cons_departamento);
    $row_depar = mysqli_fetch_array($query_depar);
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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_departamento" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Nome do departamento">Nome</label>
                    <input type="text" class="form-control" name="nome_depar" required="" autofocus="" autocomplete="off" placeholder="Nome do departamento" value="<?php echo $row_depar['nome_depar']; ?>">
                </div>
                <div class="form-group">
                    <label for="descrição do departamento">Descrição</label>
                    <textarea class="form-control" name="descricao_depar" placeholder="Descrição" rows="3"><?php echo $row_depar['descricao_depar']; ?></textarea>
                </div>
                <input type="hidden" class="form-control" name="departamento" value="<?php echo $row_depar['id_depar']; ?>">
                <input type="submit" class="btn btn-primary" name="sendEditaDepartamento" value="Salvar">
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

