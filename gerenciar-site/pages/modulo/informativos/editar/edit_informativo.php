<?php
if (!isset($seguranca)) {
    exit;
}
$id = filter_input(INPUT_GET, 'info', FILTER_DEFAULT);
$inf = editInformativo($conn, $id);
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
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-info-tab" data-toggle="pill" href="#custom-tabs-three-info" role="tab" aria-controls="custom-tabs-three-info" aria-selected="true">Informativo</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-anexos-tab" data-toggle="pill" href="#custom-tabs-three-anexos" role="tab" onclick="loadAnexos(<?php echo $id ?>)">Anexos</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">

                    <div class="tab-pane fade active show" id="custom-tabs-three-info" role="tabpanel" aria-labelledby="custom-tabs-three-info-tab">
                        <form id="formDataEditInformativo" method="POST">
                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="Assunto">Assunto</label>
                                    <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Digite aqui..." require autocomplete="off" value="<?php echo $inf['assunto'] ?>">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Categoria">Categoria</label>
                                    <select class="form-control select2" id="categoriaInfo" name="categoriaInfo" require>
                                        <option value="">Selecione...</option>
                                        <?php foreach (categoriasInfo($conn) as $cat) { ?>
                                            <option value="<?php echo $cat['id'] ?>" <?php echo $cat['id'] == $inf['informativo_categoria_id'] ? "selected" : "" ?>>
                                                <?php echo $cat['categoria'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="Unidade">Unidade</label>
                                    <select class="form-control select2" id="unidadeInfo" name="unidadeInfo" require>
                                        <option value="">Selecione...</option>
                                        <?php foreach (unidadeUsuario($conn) as $un) { ?>
                                            <option value="<?php echo $un['id_uni'] ?>" <?php echo $un['id_uni'] == $inf['unidade_id'] ? "selected" : "" ?>>
                                                <?php echo $un['nome_uni'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="Descrição">Descrição</label>
                                <textarea class="form-control informativo" id="descricao" name="descricao" rows="3" require><?php echo $inf['conteudo'] ?></textarea>
                            </div>

                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">

                            <button type="submit" class="btn btn-primary" id="btnSendInformativo">Salvar</button>

                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delPostado">Excluir</button>
                        </form>

                        <div class="modal fade" id="delPostado" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center text-bold">Atenção <br> Deseja excluir este registro?</p>

                                        <button type="button" class="btn btn-danger btn-block btn-lg" onclick="delPostado(<?php echo $id; ?>)">Excluir arquivo</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-anexos" role="tabpanel" aria-labelledby="custom-tabs-three-anexos-tab">

                        <div class="float-right mb-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novoAnexo">Novo anexo</button>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listAnexos">

                            </tbody>
                        </table>

                        <!-- Modal -->
                        <div class="modal fade" id="novoAnexo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar anexo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formDataAnexo">
                                            <div class="form-group">
                                                <label for="Titulo">Titulo</label>
                                                <input type="text" class="form-control" name="titulo" require autocomplete="off">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Arquivo</label>
                                                <input type="file" class="form-control-file" id="arquivo" name="arquivo" require>
                                            </div>

                                            <input type="hidden" name="info" value="<?php echo $id ?>">

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="btnAnexo">Salvar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->