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

                <ul class="nav nav-tabs mb-3" id="custom-content-below-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-add-tab" data-toggle="pill" href="#custom-content-below-add" role="tab">Adicionar publicação</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-noticias-tab" data-toggle="pill" href="#custom-content-below-noticias" role="tab">Publicações</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-pub-destaque-tab" data-toggle="pill" href="#custom-content-below-pub-destaque" role="tab">Adicionar Destaque</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-meus-destaque-tab" data-toggle="pill" href="#custom-content-below-meus-destaque" role="tab">Meus destaques</a>
                    </li>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-add" role="tabpanel" aria-labelledby="custom-content-below-add-tab">

                        <form method="POST" id="formDataPub" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-3 d-flex justify-content-center align-items-center">

                                    <div class="form-group">
                                        <label for="Arquivo">Capa</label>
                                        <input type="file" class="form-control-file" name="arquivo" required>
                                        <small class="text-muted">Dimensões minimas: 1920 x 1080 (png, jpeg, jpg ou gif)</small>
                                    </div>

                                </div>

                                <div class="col">

                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="Titulo">Titulo</label>
                                            <input type="text" class="form-control" name="titulo" required autocomplete="off" autofocus placeholder="Postagem">
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="Categoria">Editoria</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control select2" id="categoriaPub" name="categoriaPub" required>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novaCategoriaPub">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#listCategoriaPub" id="mdShowCategoria">
                                                        <i class="fa fa-list" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="Unidade">Unidade</label>
                                            <select class="form-control select2" id="unidade" name="unidade" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                                                    <option value="<?php echo $row_unidade['id_uni']; ?>"><?php echo $row_unidade['nome_uni']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col">
                                            <label for="Subtitulo">Subtitulo</label>
                                            <input type="text" class="form-control" name="subtitulo" autocomplete="off" placeholder="Postagem">
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="Página">Página</label>
                                            <select class="form-control" name="pagina" required>
                                                <option value="">Selecione</option>
                                                <option value="Artigos">Artigos</option>
                                                <option value="Geral">Geral</option>
                                                <option value="Policial">Policial</option>
                                                <option value="Projetos sociais">Projetos sociais</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-3">
                                            <label for="Destacar">Destacar</label>
                                            <select class="form-control" name="destacar" required>
                                                <option value="">Selecione</option>
                                                <option value="Sim">Sim</option>
                                                <option value="Não">Não</option>
                                            </select>
                                        </div>
                                        

                                    </div>

                                </div>

                            </div>

                            <div class="form-group">
                                <textarea class="form-control trumbowyg-pub" name="noticia" id="noticia" rows="10" required></textarea>
                            </div>

                            <h5><i class="fa fa-sellsy" aria-hidden="true"></i> Opções SEO</h5>
                            <hr>

                            <div class="form-group">
                                <label for="Descrição meta">Descrição meta</label>
                                <textarea class="form-control" name="resumo" id="resumo" rows="5" required></textarea>
                                <small class="text-muted">Digite um breve resumo sobre a noticia</small>
                            </div>

                            <div class="form-group">
                                <label for="Palavras-chave">Palavras-chave</label>
                                <input class="form-control" name="palavras_chave" id="palavras-chave" required autocomplete="off" />
                                <small class="text-muted">Digite as palavras-chaves separadas por virgulas. Ex: palavra-chave 1, palavra-chave 2, palavra-chave 3.</small>
                            </div>

                            <h5></h5>
                            <hr>
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <i class="fa fa-picture-o" aria-hidden="true"></i> Criar galeria
                                </div>
                                <div class="card-body">

                                    <div id="actions-foto" class="row">
                                        <div class="col-lg-6">
                                            <div class="btn-group w-100">
                                                <span class="btn btn-success col fileinput-button">
                                                    <i class="fa fa-plus"></i>
                                                    <span>Adicionar midias</span>
                                                </span>
                                                <!--<button type="submit" class="btn btn-primary col start">
                                            <i class="fa fa-upload"></i>
                                            <span>Start upload</span>
                                        </button>
                                        <button type="reset" class="btn btn-warning col cancel">
                                            <i class="fa fa-times-circle"></i>
                                            <span>Cancelar</span>
                                        </button> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <div class="fileupload-process w-100">
                                                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table table-striped files" id="previews">
                                        <div id="template-foto" class="row mt-2">
                                            <div class="col-auto">
                                                <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <p class="mb-0">
                                                    <span class="lead" data-dz-name></span>
                                                    (<span data-dz-size></span>)
                                                </p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <div class="col-4 d-flex align-items-center">
                                                <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                </div>
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary start">
                                                        <i class="fa fa-upload"></i>
                                                        <span>Upload</span>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-warning cancel">
                                                        <i class="fa fa-times-circle"></i>
                                                        <span>Cancelar</span>
                                                    </button>
                                                    <button data-dz-remove class="btn btn-danger delete">
                                                        <i class="fa fa-trash"></i>
                                                        <span>Deletar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="Lengenda">Lengenda</label>
                                        <input class="form-control" name="legenda" id="legenda" require autocomplete="off" />
                                        <small class="text-muted">A legenda digitada será exibida em todas as imagens da galeria</small>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Status">Status</label>
                                <select class="form-control select2" id="status" name="status" required>
                                    <option value="">Selecione...</option>
                                    <option value="Rascunho">Rascunho</option>
                                    <option value="Publicar">Publicar</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="SendPublicar" id="SendPublicar" value="Publicar">
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-noticias" role="tabpanel" aria-labelledby="custom-content-below-noticias-tab">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Publicados</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 350px;">
                                        <input type="text" id="search_pub" class="form-control float-right" placeholder="Buscar" autocomplete="off" onkeyup="listarPublicados()">

                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%">
                                                Capa
                                            </th>
                                            <th style="width: 30%">
                                                Titulo
                                            </th>
                                            <th style="width: 20%">
                                                Autor
                                            </th>
                                            <th>
                                                Categoria
                                            </th>
                                            <th style="width: 8%" class="text-center">
                                                Status
                                            </th>
                                            <th style="width: 20%">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="listar-publicacoes">



                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-pub-destaque" role="tabpanel" aria-labelledby="custom-content-below-pub-destaque-tab">

                        <form method="POST" id="formDataPubDestaque" enctype="multipart/form-data">

                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="Titulo">Titulo</label>
                                    <input type="text" class="form-control textcase" name="titulo" id="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Data inicio">Data inicio</label>
                                    <input type="date" class="form-control" name="dt_inicio" id="dt_inicio" autocomplete="off">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Data fim">Data fim</label>
                                    <input type="date" class="form-control" name="dt_fim" id="dt_fim" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="Descrição">Descrição</label>
                                <textarea class="form-control pub-destaque" name="desc" cols="10"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Arquivo">Arquivo</label>
                                <input type="file" class="form-control-file" name="arquivo" required>
                                <small class="text-muted">Dimensões minimas: 1920 x 1080 (png, jpeg, jpg ou gif)</small>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="SendCadPubDestaque" id="SendCadPubDestaque" value="Salvar">
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-meus-destaque" role="tabpanel" aria-labelledby="custom-content-below-meus-destaque-tab">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Data inicio</th>
                                    <th scope="col">Data fim</th>
                                    <th scope="col">Cadastrado</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="list-destaques">

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="mdEditarDestaque" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Alterar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formDataEditPubDestaque" enctype="multipart/form-data">

                    <div class="form-row">

                        <div class="form-group col">
                            <label for="Titulo">Titulo</label>
                            <input type="text" class="form-control textcase" name="edit_titulo" id="edit_titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                        </div>
                        <!--
                        <div class="form-group col-3">
                            <label for="Data inicio">Data inicio</label>
                            <input type="date" class="form-control" name="edit_dt_inicio" id="edit_dt_inicio" autocomplete="off">
                        </div>

                        <div class="form-group col-3">
                            <label for="Data fim">Data fim</label>
                            <input type="date" class="form-control" name="edit_dt_fim" id="edit_dt_fim" autocomplete="off">
                        </div> -->

                    </div>

                    <div class="form-group">
                        <label for="Descrição">Descrição</label>
                        <textarea class="form-control pub-destaque" name="edit_desc" id="edit_desc" cols="10"></textarea>
                    </div>

                    <input type="hidden" name="idpubdestaque" id="idpubdestaque">

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="SendEditPubDestaque" id="SendEditPubDestaque" value="Salvar">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="mdApagarDestaque" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-danger" id="btnDelDestaque">Excluir</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="novaCategoriaPub" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nova categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="formDataCategoriaPub">

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
<div class="modal fade" id="delPub" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Deseja excluir essa publicação?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" id="btnDelPub">Apagar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="listCategoriaPub" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Categorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">

                <form id="list-categorias"></form>

            </div>
        </div>
    </div>
</div>