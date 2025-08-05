<?php
if (!isset($seguranca)) {
    exit;
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$dado = listarArtigo($id, $conn);
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
                    <li class="breadcrumb-item active">
                        <a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a>
                    </li>
                    <li class="breadcrumb-item"><?php echo $Pagina_Atual; ?></li>
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
            <!--<div class="card-header">
        <h5 class="card-title">Home</h5>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fa fa-times"></i>
            </button>
          </div>
      </div> -->
            <div class="card-body">
                <form method="POST" action="<?php echo pg ?>/pages/modulo/base-de-conhecimento/editar/processa/proc_edit_artigo">
                    <div class="form-group">
                        <label for="Titulo do artigo">Titulo do artigo</label>
                        <input type="text" class="form-control" name="titulo" require placeholder="Titulo" value="<?php echo $dado['titulo'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="Texto">Texto</label>
                        <textarea class="form-control artigo-bc" name="texto" rows="3" require><?php echo $dado['conteudo'] ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $dado['id'] ?>">
                    <button type="submit" class="btn btn-primary" id="btnSendCadArtigo">Salvar artigo</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->