<?php
if (!isset($seguranca)) {
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$dado = listarDadosDepoimento($conn, $id);

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
            <div class="card-body">

                <form id="formDataEditDepoimento">

                    <div class="form-group">
                        <label for="Nome">Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="" require value="<?php echo $dado['nome'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="Cargo/função">Cargo/função</label>
                        <input type="text" class="form-control" name="cargoFuncao" placeholder="" require value="<?php echo $dado['cargoFuncao'] ?>">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control trumbowyg-pub" name="texto" rows="3" require><?php echo $dado['texto'] ?></textarea>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id ?>">

                    <button type="submit" class="btn btn-primary" id="sendCadDep">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#altFoto">Alterar foto</button>

                </form>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="altFoto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Alterar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <img src="<?php echo pg . $dado['foto'] ?>" class="rounded mx-auto d-block" alt="..." width="300">

                <form id="formDataEditFotoDepoimento">

                    <div class="form-group">
                        <label for="Foto">Foto</label>
                        <input type="file" class="form-control-file" name="arquivo" require>
                    </div>

                    <input type="hidden" name="fotoid" value="<?php echo $id ?>">
                    <input type="hidden" class="form-control" name="nomeDepo" value="<?php echo $dado['nome'] ?>">

                    <button type="submit" class="btn btn-primary" id="sendEditDep">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </form>

            </div>
        </div>
    </div>
</div>