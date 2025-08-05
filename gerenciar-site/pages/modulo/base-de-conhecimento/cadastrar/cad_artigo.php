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
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-inserir-tab" data-toggle="pill" href="#custom-tabs-three-inserir" role="tab" aria-controls="custom-tabs-three-inserir" aria-selected="true">Inserir artigo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-artigos-tab" data-toggle="pill" href="#custom-tabs-three-artigos" role="tab" aria-controls="custom-tabs-three-artigos" onclick="listArtigos();">Artigos</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-inserir" role="tabpanel" aria-labelledby="custom-tabs-three-inserir-tab">
                        <form id="formDataArtigoBC" method="POST">
                            <div class="form-group">
                                <label for="Titulo do artigo">Titulo do artigo</label>
                                <input type="text" class="form-control" name="titulo" require placeholder="Titulo">
                            </div>
                            <div class="form-group">
                                <label for="Texto">Texto</label>
                                <textarea class="form-control artigo-bc" name="texto" rows="3" require></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSendCadArtigo">Salvar artigo</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-artigos" role="tabpanel" aria-labelledby="custom-tabs-three-artigos-tab">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Data</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="listArtigos">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->