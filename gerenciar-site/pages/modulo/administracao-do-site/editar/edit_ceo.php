<?php
if (!isset($seguranca)) {
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$dado = listarDadosCeo($conn, $id);
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

                <form id="formDataEditCeo">
                    <div class="form-group">
                        <label for="Nome">Nome</label>
                        <input type="text" class="form-control" name="nome" placeholder="Nome completo" require value="<?php echo $dado['nome'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="descrição">Descrição</label>
                        <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $dado['descricao'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="Biografia">Biografia</label>
                        <textarea class="form-control trumbowyg-pub" name="biografia" rows="3" require><?php echo $dado['biografia'] ?></textarea>
                    </div>

                    <h5>Virgência
                        <hr>
                    </h5>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="Data inicio">Data inicio</label>
                                <input type="date" class="form-control" name="data_inicio" placeholder="Descrição" require value="<?php echo $dado['data_inicio'] ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="Data fim">Data fim</label>
                                <input type="date" class="form-control" name="data_fim" placeholder="Descrição" value="<?php echo $dado['data_fim'] ?>">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id ?>">

                    <button type="submit" class="btn btn-primary" id="btnSendEditCeo">Salvar</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#altFoto">
                        Foto
                    </button>

                    <div class="float-right">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delCeo">
                            Apagar dados
                        </button>
                    </div>

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
                <h5 class="modal-title" id="staticBackdropLabel">Alterar foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <img src="<?php echo pg . $dado['foto'] ?>" class="rounded mx-auto d-block img-fluid" alt="<?php echo $dado['nome'] ?>">

                <form id="formDataEditFoto">
                    <div class="form-group">
                        <label for="Foto">Foto</label>
                        <input type="file" class="form-control-file" name="arquivo" require>
                    </div>

                    <input type="hidden" name="ceoNome" value="<?php echo $dado['nome'] ?>">

                    <input type="hidden" name="ceoId" value="<?php echo $id ?>">

                    <button type="submit" class="btn btn-primary" id="btnEditFoto">Salvar</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delCeo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Apagar registros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <img src="<?php echo pg . $dado['foto'] ?>" class="rounded mx-auto d-block img-fluid" alt="<?php echo $dado['nome'] ?>">
                <p class="text-center"><?php echo $dado['nome'] ?></p>

                <form id="formDataDelCeo">

                    <input type="hidden" name="ceoDelId" value="<?php echo $id ?>">

                    <button type="submit" class="btn btn-danger btn-block" id="btnDelCeo">Apagar</button>
                </form>

            </div>
        </div>
    </div>
</div>