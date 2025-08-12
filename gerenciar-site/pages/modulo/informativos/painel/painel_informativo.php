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
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-adicionar-tab" data-toggle="pill" href="#custom-tabs-three-adicionar" role="tab" aria-controls="custom-tabs-three-adicionar" aria-selected="true">Adicionar</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-postados-tab" data-toggle="pill" href="#custom-tabs-three-postados" role="tab" aria-selected="false">Postados</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-relatorios-tab" data-toggle="pill" href="#custom-tabs-three-relatorios" role="tab" aria-controls="custom-tabs-three-relatorios" aria-selected="false">Relatórios</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-adicionar" role="tabpanel" aria-labelledby="custom-tabs-three-adicionar-tab">

                        <form id="formDataInformativo" method="POST">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="Assunto">Assunto</label>
                                    <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Digite aqui..." require autocomplete="off">
                                </div>
                                <div class="form-group col-3">
                                    <label for="Unidade">Unidade</label>
                                    <select class="form-control select2" id="unidade" name="unidade" require>
                                        <option value="">Selecione...</option>
                                        <?php foreach (unidadeUsuario($conn) as $un) { ?>
                                            <option value="<?php echo $un['id_uni'] ?>"><?php echo $un['nome_uni'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-3">
                                    <label for="Categoria">Categoria</label>
                                    <div class="input-group mb-">
                                        <select class="form-control select2" id="categoria" name="categoria" require>

                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="btnNovaCategoria">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#mdListCategorias" onclick="list_categorias_modal()">
                                                <i class="fa fa-list-ol" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Descrição">Descrição</label>
                                <textarea class="form-control informativo" id="descricao" name="descricao" rows="3" require></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendInformativo">Salvar</button>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-postados" role="tabpanel" aria-labelledby="custom-tabs-three-postados-tab">

                        <div class="float-right mb-3">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="table_search_postados" class="form-control float-right" placeholder="Digite aqui...">

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Assunto</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Data</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbPostados">

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-relatorios" role="tabpanel" aria-labelledby="custom-tabs-three-relatorios-tab">

                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="mdListCategorias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Categorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="listCategorias"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>