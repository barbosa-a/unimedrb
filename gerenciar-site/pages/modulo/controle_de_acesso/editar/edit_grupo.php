<?php
    if (!isset($seguranca)) {
        exit;
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    //recuperar dados vindo da url
    $grupo = filter_input(INPUT_GET, 'grupo', FILTER_SANITIZE_NUMBER_INT);
    //consultar grupos
    $cons_grupo = "SELECT * FROM grupo WHERE id_gru = '$grupo' LIMIT 1";
    $query_grupo = mysqli_query($conn, $cons_grupo);
    $rowGrupo = mysqli_fetch_array($query_grupo);
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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_grupo" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Nome do grupo">Nome</label>
                    <input type="text" class="form-control" name="nome_gru" required="" autofocus="" autocomplete="off" placeholder="Nome do grupo" value="<?php echo $rowGrupo['nome_gru']; ?>">
                </div>
                <div class="form-group">
                    <label for="descrição do grupo">Descrição</label>
                    <textarea class="form-control" name="descricao_gru" placeholder="Descrição" rows="3"><?php echo $rowGrupo['descricao_gru']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="pai">Grupo</label>
                    <select class="form-control" name="pai" required="">
                        <option value="">Selecione...</option>
                        <?php echo ListarGruposPaiEdit($rowGrupo['grupo_pai_id'], $conn); ?>
                    </select>
                </div>
                <input type="hidden" name="grupo" value="<?php echo $rowGrupo['id_gru']; ?>">
                <input type="submit" class="btn btn-primary" name="sendEditarGrupo" value="Salvar">
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
