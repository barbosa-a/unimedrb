<?php
if (!isset($seguranca)) {
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$dado = viewPub($conn, $id);

$paginas = ['Artigos', 'Geral', 'Policial', 'Projetos sociais'];
$destacar = ['Sim', 'Não'];

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

                <ul class="nav nav-tabs mb-3" id="custom-content-below-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab">Postagem</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-capa-tab" data-toggle="pill" href="#custom-content-below-capa" role="tab">Capas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-galeria-tab" data-toggle="pill" href="#custom-content-below-galeria" role="tab" onclick="listarGaleria(<?php echo $id ?>)">Galeria</a>
                    </li>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">

                        <div class="callout callout-info">
                            <h5><i class="fa fa-link"></i> Visualizar:</h5>
                            <a href="<?php echo site ?>materia/<?php echo $dado['slug'] ?>/<?php echo $dado['status'] == "Rascunho" ? "rascunho" : "" ?>" target="_blank">
                                <?php echo site ?>materia/<?php echo $dado['slug'] ?>/<?php echo $dado['status'] == "Rascunho" ? "rascunho" : "" ?>
                            </a>
                        </div>

                        <form id="formDataEditPub" enctype="multipart/form-data">

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="Titulo">Titulo</label>
                                    <input type="text" class="form-control" name="titulo" required autocomplete="off" autofocus placeholder="Titulo" value="<?php echo $dado['titulo'] ?>">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Categoria">Editoria</label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="categoriaPub" require>
                                            <option value="">Selecione...</option>
                                            <?php foreach (listCategorias($conn) as $cat) { ?>
                                                <option value="<?php echo $cat['id'] ?>" <?php echo $dado['site_publicacoes_categoria_id'] == $cat['id'] ? "selected" : "" ?>>
                                                    <?php echo $cat['categoria'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novaEditCategoriaPub">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label for="Unidade">Unidade</label>
                                    <select class="form-control select2" id="unidade" name="unidade" require>
                                        <option value="">Selecione...</option>
                                        <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                                            <option value="<?php echo $row_unidade['id_uni']; ?>" <?php echo $dado['unidade_id'] == $row_unidade['id_uni'] ? "selected" : "" ?>>
                                                <?php echo $row_unidade['nome_uni']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="Subtitulo">Subtitulo</label>
                                    <input type="text" class="form-control" name="subtitulo" autocomplete="off" placeholder="Subtitulo" value="<?php echo $dado['subtitulo'] ?>">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Página">Página</label>
                                    <select class="form-control" name="pagina" require>
                                        <option value="">Selecione</option>
                                        <?php foreach ($paginas as $pgs) { ?>
                                            <option value="<?php echo $pgs ?>" <?php echo $pgs == $dado['pagina'] ? "selected" : "" ?>>
                                                <?php echo $pgs ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="Destacar">Destacar</label>
                                    <select class="form-control" name="destacar" require>
                                        <option value="">Selecione</option>
                                        <?php foreach ($destacar as $des) { ?>
                                            <option value="<?php echo $des ?>" <?php echo $des == $dado['destacar'] ? "selected" : "" ?>>
                                                <?php echo $des ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <textarea class="form-control trumbowyg-pub" name="noticia" id="noticia" rows="10" require><?php echo $dado['texto'] ?></textarea>
                            </div>

                            <h5>Opções SEO</h5>
                            <hr>

                            <div class="form-group">
                                <label for="Descrição meta">Descrição meta</label>
                                <textarea class="form-control" name="resumo" id="resumo" rows="5" require><?php echo $dado['descricao_meta'] ?></textarea>
                                <small class="text-muted">Digite um breve resumo sobre a noticia</small>
                            </div>

                            <div class="form-group">
                                <label for="Palavras-chave">Palavras-chave</label>
                                <input class="form-control" name="palavras_chave" id="palavras-chave" require autocomplete="off" value="<?php echo $dado['palavras_chave'] ?>" />
                                <small class="text-muted">Digite as palavras-chaves separadas por virgulas. Ex: palavra-chave 1, palavra-chave 2, palavra-chave 3.</small>
                            </div>

                            <?php
                            $arr = ['Rascunho', 'Publicar'];
                            ?>

                            <div class="form-group">
                                <label for="Status">Status</label>
                                <select class="form-control select2" id="status" name="status" require>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($arr as $value) { ?>
                                        <option value="<?php echo $value ?>" <?php echo $value == $dado['status'] ? "selected" : "" ?>>
                                            <?php echo $value ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="SendPublicar" id="SendPublicar" value="Publicar">
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-capa" role="tabpanel" aria-labelledby="custom-content-below-capa-tab">

                        <div class="row">
                            <div class="col-6">

                                <div style="max-width: 750px">
                                    <img src="<?php echo pg . $dado['capa_princial'] ?>" class="rounded mx-auto d-block img-fluid" alt="...">
                                </div>                                

                                <form id="formDataCapaPrincipal">
                                    <div class="form-group">
                                        <label for="Capa principal">Capa principal</label>
                                        <input type="file" class="form-control-file" name="capaPrincipal" required>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id ?>">

                                    <button type="submit" class="btn btn-primary" id="btnCapa1">Salvar</button>
                                </form>

                            </div>
                            <div class="col-6">

                                <div style="max-width: 350px">
                                    <img src="<?php echo pg . $dado['capa_pub'] ?>" class="rounded mx-auto d-block img-fluid" alt="...">
                                </div>

                                <form id="formDataCapaPub">
                                    <div class="form-group">
                                        <label for="Capa publicação">Capa publicação</label>
                                        <input type="file" class="form-control-file" name="capaPub" required>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id ?>">

                                    <button type="submit" class="btn btn-primary" id="btnCapa2">Salvar</button>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-galeria" role="tabpanel" aria-labelledby="custom-content-below-galeria-tab">

                        <div class="row" id="list-galeria">

                        </div>
                    </div>

                </div>


            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="novaEditCategoriaPub" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nova categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="formDataEditCategoriaPub">

                    <div class="form-group">
                        <label for="Categoria">Categoria</label>
                        <input type="text" class="form-control" id="newCategoriaPub" name="newCategoriaPub" require autocomplete="off" placeholder="Nome">
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSendCategoriaPub">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="excluirImgGaleria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-danger" id="btnDelImgGaleria">Apagar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>