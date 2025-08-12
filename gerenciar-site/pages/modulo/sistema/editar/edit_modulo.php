<?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    //id
    $modulo = filter_input(INPUT_GET, 'modulo', FILTER_SANITIZE_NUMBER_INT);
    //consultar modulo
    $cons_mod = "SELECT * FROM modulos WHERE id_mod = '$modulo' ";
    $query_cons_mod = mysqli_query($conn, $cons_mod);
    $rowMod = mysqli_fetch_array($query_cons_mod);       
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
            <h5 class="m-0">Formulario editar modulo</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_modulo" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" placeholder="Nome do modulo" required="" autocomplete="off" value="<?php echo $rowMod['nome_mod']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Chave</label>
                    <input type="text" class="form-control" name="chave" placeholder="Ex: modulo/cadastro" required="" autocomplete="off" value="<?php echo $rowMod['chave_mod']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" name="descricao" rows="3" placeholder="Descrição do modulo" required="" autocomplete="off"><?php echo $rowMod['descricao_mod']; ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Situação</label>
                    <select class="form-control" name="status" required="">
                        <option value="">Selecione...</option>
                        <?php echo ListarStatusMenu($rowMod['permissao_mod'], $conn); ?>
                    </select>
                </div>
                <input type="hidden" name="modulo" value="<?php echo $modulo; ?>" />
                <input type="submit" name="SendEditModulo" class="btn btn-primary" value="Salvar">      
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