<?php
    if (!isset($seguranca)) {
        exit;
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    //recuperar dados vindo da url
    $perfil = filter_input(INPUT_GET, 'perfil', FILTER_SANITIZE_NUMBER_INT);
    //consultar perfil
    $nvl = "SELECT * FROM niveis_acessos WHERE id_nvl = '$perfil' LIMIT 1 ";
    $query_nvl = mysqli_query($conn, $nvl);
    $row_nvl = mysqli_fetch_assoc($query_nvl);
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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_perfil" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Nome do perfil de acesso">Nome</label>
                    <input type="text" class="form-control" name="nome_nvl" required="" autofocus="" autocomplete="off" placeholder="Nome do novo perfil" value="<?php echo $row_nvl['nome_nvl']; ?>">
                </div>
                <input type="hidden" name="perfil" value="<?php echo $row_nvl['id_nvl']; ?>" />
                <input type="submit" class="btn btn-primary" name="sendEditarNvl" value="Salvar">
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