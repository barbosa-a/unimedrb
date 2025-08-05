<?php
if (!isset($seguranca)) {
    exit;
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
        <div class="card card-primary card-outline">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#mdGaleria">
                    Criar galeria
                </button>

                <div class="row" id="list-galerias">

                </div>


            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<!-- Modal -->
<div class="modal fade" id="mdGaleria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Criar galeria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDataGaleria">
                    <div class="form-group">
                        <label for="Álbum">Álbum</label>
                        <input type="text" class="form-control" name="album" placeholder="Álbum de Fotos" require>
                    </div>

                    <div class="form-group">
                        <label for="Descrição">Descrição</label>
                        <textarea class="form-control" name="descricao" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="Fotos">Fotos</label>
                        <input type="file" class="form-control-file" name="arquivo[]" require multiple>
                    </div>

                    <div class="form-group">
                        <label for="Legenda">Legenda</label>
                        <input type="text" class="form-control" name="legenda" placeholder="Legenda">
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnCriarGaleria" name="btnCriarGaleria">Salvar</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="resultadoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Fotos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="product-image-thumbs" id="resultadoBody"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCadFoto">Adicionar fotos</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mdDel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Deseja excluir este registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" id="btnSendExcluirFoto">Excluir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addFotos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Adicionar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDataAddFotosAlbum">
                    <div class="form-group">
                        <label for="Fotos">Fotos</label>
                        <input type="file" class="form-control-file" name="arquivo[]" require multiple>
                    </div>

                    <div class="form-group">
                        <label for="Legenda">Legenda</label>
                        <input type="text" class="form-control" name="legenda" placeholder="Legenda" require>
                    </div>

                    <input type="hidden" name="album" id="album">

                    <button type="submit" class="btn btn-primary" id="btnSendGaleria">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>