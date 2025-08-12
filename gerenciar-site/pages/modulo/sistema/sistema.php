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
                    <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
                    <li class="breadcrumb-item">Sistema</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">Administração do sistema</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-modulo-tab" data-toggle="pill" href="#v-pills-modulo" role="tab" aria-controls="v-pills-modulo" aria-selected="true">Modulo</a>
                            <a class="nav-link" id="v-pills-operacoes-tab" data-toggle="pill" href="#v-pills-operacoes" role="tab" aria-controls="v-pills-operacoes" aria-selected="false">Operações</a>
                            <a class="nav-link" id="v-pills-personalizacao-tab" data-toggle="pill" href="#v-pills-personalizacao" role="tab" aria-controls="v-pills-personalizacao" aria-selected="false">Personalização</a>
                            <a class="nav-link" id="v-pills-changelog-tab" data-toggle="pill" href="#v-pills-changelog" role="tab" aria-controls="v-pills-changelog" aria-selected="false">Changelog</a>
                            <a class="nav-link" id="v-pills-contrato-tab" data-toggle="pill" href="#v-pills-contrato" role="tab" aria-controls="v-pills-contrato" aria-selected="false">Contrato</a>
                            <a class="nav-link" id="v-pills-planosPrecos-tab" data-toggle="pill" href="#v-pills-planosPrecos" role="tab" aria-controls="v-pills-planosPrecos" aria-selected="false">Planos e Preços</a>
                            <a class="nav-link" id="v-pills-enquete-tab" data-toggle="pill" href="#v-pills-enquete " onclick="graficoEnquete();">Enquete</a>
                            <a class="nav-link" id="v-pills-bkp-tab" data-toggle="pill" href="#v-pills-bkp" onclick="listBkpBd();">Backup</a>
                            <a class="nav-link" id="v-pills-api-tab" data-toggle="pill" href="#v-pills-api" onclick="listApis()">APIs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-modulo" role="tabpanel" aria-labelledby="v-pills-modulo-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Modulos do sistema</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="moduloSys" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Modulo</th>
                                                <th scope="col">Chave</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo ListarModulosSistema($botao_edit_mod, $botao_del_mod, $conn); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="cadModulo" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cadastrar novo modulo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body m-3">
                                                <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_modulo" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label class="form-label">Nome</label>
                                                        <input type="text" class="form-control" name="nome" placeholder="Nome do modulo" required="" autocomplete="off" autofocus>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Chave</label>
                                                        <input type="text" class="form-control" name="chave" placeholder="Ex: modulo/cadastro" required="" autocomplete="off" value="pages/modulo/">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Descrição</label>
                                                        <textarea class="form-control" name="descricao" rows="3" placeholder="Descrição do modulo" required="" autocomplete="off"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Situação</label>
                                                        <select class="form-control" name="status" required="">
                                                            <option value="">Selecione...</option>
                                                            <option value="1">Ativo</option>
                                                            <option value="2">Inativo</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" name="SendCadModulo" class="btn btn-primary" value="Salvar">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-operacoes" role="tabpanel" aria-labelledby="v-pills-operacoes-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-three-pg-tab" data-toggle="pill" href="#custom-tabs-three-pg" role="tab" aria-controls="custom-tabs-three-pg" aria-selected="true">Páginas</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-ordem-tab" data-toggle="pill" href="#custom-tabs-three-ordem" role="tab" aria-controls="custom-tabs-three-ordem" aria-selected="false">Ordenar menu</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="tab-content" id="custom-tabs-three-tabContent">

                                    <div class="tab-pane fade show active" id="custom-tabs-three-pg" role="tabpanel" aria-labelledby="custom-tabs-three-pg-tab">
                                        <div class="table-responsive">
                                            <table id="operacoesSys" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Objeto</th>
                                                        <th>Modulo</th>
                                                        <th>Nome</th>
                                                        <th>Operação</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo ListarOperacoesSistema($botao_edit_fluxo, $conn); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal fade" id="cadOperacao" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Nova operação</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_fluxo" enctype="multipart/form-data">
                                                            <div class="form-row">
                                                                <div class="form-group col-sm-9">
                                                                    <label class="form-label">Nome da operação</label>
                                                                    <input type="text" class="form-control" name="nome_processo" placeholder="Nome da operação" required autofocus="" autocomplete="off" />
                                                                </div>
                                                                
                                                                <div class="form-group col-sm-3">
                                                                    <label class="form-label">Icone</label>
                                                                    <input type="text" class="form-control" name="icone" placeholder="Icone" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-sm-4">
                                                                    <label class="form-label">Modulo</label>
                                                                    <select class="form-control select2" name="modulo" required="">
                                                                        <option value="">Selecione o modulo</option>
                                                                        <?php echo ListarModulos($conn); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-8">
                                                                    <label class="form-label">Operação</label>
                                                                    <input type="text" class="form-control" name="endereco_fluxo" placeholder="Processo" required="" autocomplete="off" value="pages/modulo/" />
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-sm-4">
                                                                    <label class="form-label">Menu</label>
                                                                    <select class="form-control" name="menu" required="">
                                                                        <option value="">Selecione...</option>
                                                                        <?php echo ListarOpcoesMenu($conn); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label class="form-label">Objeto</label>
                                                                    <select class="form-control" name="objeto" required="">
                                                                        <option value="">Selecione...</option>
                                                                        <?php echo ListarObjPaginas($conn); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-4">
                                                                    <label class="form-label">Ordem</label>
                                                                    <input type="text" class="form-control" name="ordem" required autocomplete="off" onkeypress="return somenteNumeros(event)" placeholder="Ordem no menu" />
                                                                </div>
                                                            </div>
                                                            <div class="form-row">

                                                                <div class="form-group col">
                                                                    <label class="form-label">Página</label>
                                                                    <select class="form-control select2" name="pagina">
                                                                        <option value="">Selecione...</option>
                                                                        <?php foreach (paginasSubmenu($conn) as $sub) { ?>
                                                                            <option value="<?php echo $sub['id_pg'] ?>"><?php echo $sub['nome_pg'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <input type="submit" class="btn btn-primary" name="SendCadOperacao" value="Salvar" />
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-three-ordem" role="tabpanel" aria-labelledby="custom-tabs-three-ordem-tab">
                                        <ul class="todo-list ui-sortable ui-pg" id="listPgMenu" data-widget="todo-list"></ul>   
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-personalizacao" role="tabpanel" aria-labelledby="v-pills-personalizacao-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Personalização do sistema</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo pg;  ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_personalizacao" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Nome do sistema">Nome do sistema</label>
                                            <input type="text" class="form-control" name="nome_sistema" autocomplete="off" required autofocus placeholder="Nome" value="<?php echo dados_sistema("nome_sistema", $conn); ?>" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Site">Site</label>
                                            <input type="text" class="form-control" name="site" required autocomplete="off" value="<?php echo dados_sistema("site_sistema", $conn); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Empresa contratante">Empresa</label>
                                        <input type="text" class="form-control" name="empresa" placeholder="Nome da empresa" autocomplete="off" required value="<?php echo dados_sistema("nome_empresa", $conn); ?>" />
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="Logo">Logo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="arquivo">
                                                <label class="custom-file-label" for="customFile">Selecione uma logo</label>
                                                <small class="text-muted">Tamanho: 128 x 128 pixel | Extensão: .png</small>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Versão do sistema">Versão</label>
                                            <select class="form-control" required name="versao">
                                                <option value="">Selecione...</option>
                                                <?php echo listarVersoes(dados_sistema("versao_atual_sistema", $conn), $conn); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="SendCadPersonalizacao" value="Salvar" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-changelog" role="tabpanel" aria-labelledby="v-pills-changelog-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Changelog</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovaVersao" data-card-widget="">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovoChange" data-card-widget="">
                                        <i class="fa fa-plus-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <?php echo changelog($conn); ?>
                                </div> <!-- End timeline -->
                                <!-- Modal Cadastrar novo changelog-->
                                <div class="modal fade" id="CadNovaVersao" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Nova versão</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_versao" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="descrição do Versão">Versão</label>
                                                        <input type="text" name="versao" class="form-control" required autocomplete="off" placeholder="Ex 0.0.0" />
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" name="sendCadVersao" value="Salvar">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Cadastrar novo changelog-->
                                <!-- Modal Cadastrar novo changelog-->
                                <div class="modal fade" id="CadNovoChange" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Cadastrar changelog</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_changelog" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="descrição do Versão">Versão</label>
                                                        <select class="form-control" required name="versao">
                                                            <option value="">Selecione...</option>
                                                            <?php echo listarVersoes($id = null, $conn); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descrição do categoria">Categoria</label>
                                                        <select class="form-control" required name="categoria">
                                                            <option value="">Selecione...</option>
                                                            <?php echo listarCategoria($conn); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descrição do Descrição">Descrição</label>
                                                        <textarea class="form-control" name="descricao" id="summernote" rows="5" required></textarea>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" name="sendCadastrarChangelog" value="Salvar">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Cadastrar novo changelog-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-contrato" role="tabpanel" aria-labelledby="v-pills-contrato-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Contrato</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="contratos" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Empresa</th>
                                            <th scope="col">Plano</th>
                                            <th scope="col">Pacote</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Virgência</th>
                                            <th scope="col">Situação</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo ListarContratos($conn); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-planosPrecos" role="tabpanel" aria-labelledby="v-pills-planosPrecos-tab">
                        <div class="row">
                            <div class="col-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title">Planos</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovoPlano" data-card-widget="">
                                                <i class="fa fa-plus-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <?php echo ListarPlanos($PlanoNome = null, "opcao_ul", $conn); ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title">Preços</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovoPreco" data-card-widget="">
                                                <i class="fa fa-plus-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <?php echo ListarModeloPlano("preco", $conn); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title">Planos e preços</h5>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php echo ListarModeloPlano("pacote", $conn); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Cadastrar novo plano-->
                        <div class="modal fade" id="CadNovoPlano" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Novo plano</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_plano" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="descrição do Plano">Plano</label>
                                                <input type="text" name="nome_plano" class="form-control" required placeholder="Nome" autocomplete="off" />
                                            </div>
                                            <input type="submit" class="btn btn-primary" name="sendCadastrarPlano" value="Salvar">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Cadastrar novo plano-->
                        <!-- Modal Cadastrar novo preço-->
                        <div class="modal fade" id="CadNovoPreco" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Novo preço</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_preco" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="descrição do Pacote">Pacote</label>
                                                <input type="text" name="nome_pacote" class="form-control" required placeholder="Nome do pacote" autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                                <label for="Plano">Plano</label>
                                                <select class="form-control" name="plano" required>
                                                    <option value="">Selecione o plano</option>
                                                    <?php echo ListarPlanos($PlanoNome, "opcao_select", $conn); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="descrição do preço">Preço</label>
                                                <input type="text" name="valor_preco" id="money" class="form-control text-right" required placeholder="R$ 0,00" autocomplete="off" />
                                            </div>
                                            <input type="submit" class="btn btn-primary" name="sendCadastrarPreco" value="Salvar">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Cadastrar novo preço-->
                    </div>
                    <div class="tab-pane fade" id="v-pills-enquete" role="tabpanel" aria-labelledby="v-pills-enquete-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <ul class="row nav nav-pills">
                                    <li class="nav-item col-auto">
                                        <a class="nav-link active" href="#graf" data-toggle="tab">
                                            Gráfico
                                        </a>
                                    </li>
                                    <li class="nav-item col-auto">
                                        <a class="nav-link" href="#relat" data-toggle="tab">
                                            Relatório
                                        </a>
                                    </li>
                                    <li class="nav-item col-2 mr-4"></li>
                                    <li class="nav-item col-auto">
                                        <form id="dashPesEmquete" method="GET">
                                            <div class="form-row align-items-center mt-1">
                                                <div class="col-auto">
                                                    <input type="date" class="form-control form-control-sm" id="dtinicio" required>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="date" class="form-control form-control-sm" id="dtfim" required>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="graf">
                                        <div id="grafEnquete"></div>
                                    </div>
                                    <div class="tab-pane" id="relat">
                                        <form>
                                            <div class="form-group">
                                                <label for="Contrato">Contrato</label>
                                                <select class="form-control" id="contrato">
                                                    <option value="">Selecione...</option>
                                                    <?php foreach (listContratoEmpresa($conn) as $key => $contrato) { ?>
                                                        <option value="<?php echo $contrato['idcontratosistema'] ?>"><?php echo $contrato['razao_social'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Modelo">Modelo</label>
                                                <select class="form-control" id="modelo">
                                                    <option value="">Selecione...</option>
                                                    <option value="1">Pontuação</option>
                                                    <option value="2">Depoimento</option>
                                                </select>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="Periodo">Data inicio</label>
                                                    <input type="date" class="form-control" id="dataInicioEnquete" required>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="Periodo">Data fim</label>
                                                    <input type="date" class="form-control" id="dataFimEnquete" required>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="gerarRelatorio('Enquete');">Gerar relatório</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-bkp" role="tabpanel" aria-labelledby="v-pills-bkp-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <ul class="row nav nav-pills">
                                    <li class="nav-item col-auto">
                                        <a class="nav-link active" href="#bd" data-toggle="tab" onclick="listBkpBd();">
                                            <i class="fa fa-database" aria-hidden="true"></i> Banco de dados
                                        </a>
                                    </li>
                                    <li class="nav-item col-auto">
                                        <a class="nav-link" href="#sys" data-toggle="tab" onclick="listBkpSys();">
                                            <i class="fa fa-code" aria-hidden="true"></i> Sistema
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="bd">

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="4" class="text-center">Arquivos de backup</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Arquivo de backup</th>
                                                    <th scope="col">Tamanho</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listbkps"></tbody>
                                        </table>

                                        <hr>
                                        <button type="button" class="btn btn-primary" onclick="bkpdb()" id="bkpbd">Backup local</button>

                                    </div>
                                    <div class="tab-pane" id="sys">

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="4" class="text-center">Arquivos de backup</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Pasta de backup</th>
                                                    <th scope="col">Tamanho</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listbkpSys"></tbody>
                                        </table>

                                        <hr>
                                        <button type="button" class="btn btn-primary" onclick="bkpSys()" id="bkpSys">Backup local</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-api" role="tabpanel" aria-labelledby="v-pills-api-tab">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <ul class="row nav nav-pills">
                                    <li class="nav-item col-auto">
                                        <a class="nav-link active" href="#integra" data-toggle="tab" onclick="listApis()">
                                            <i class="fa fa-exchange" aria-hidden="true"></i> Integração
                                        </a>
                                    </li>
                                    <li class="nav-item col-auto">
                                        <a class="nav-link" href="#doc" data-toggle="tab" onclick="listDocsApis()">
                                            <i class="fa fa-file" aria-hidden="true"></i> Documentação
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="integra">

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">URL</th>
                                                    <th scope="col">Requisição</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Biblioteca</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listApis">

                                            </tbody>
                                        </table>
                                        <hr>
                                        <button type="button" class="btn btn-primary" id="novaIntegra" data-toggle="modal" data-target="#modalNovaIntegracao">Nova integração</button>
                                        <!-- Modal Nova Integração-->
                                        <div class="modal fade" id="modalNovaIntegracao" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Integração</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formDataApi" method="POST">
                                                            <div class="form-group">
                                                                <label for="cURL">cURL</label>
                                                                <input type="text" class="form-control" name="curl" require placeholder="Link cURL">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Requisição">Requisição</label>
                                                                <input type="text" class="form-control" name="requisicao" require placeholder="POST/GET">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Tipo">Tipo</label>
                                                                <input type="text" class="form-control" name="tipo" require placeholder="WhatsApp">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Biblioteca">Biblioteca</label>
                                                                <input type="text" class="form-control" name="biblioteca" require placeholder="Nome do pacote">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="GitHub">GitHub</label>
                                                                <input type="text" class="form-control" name="github" require placeholder="Link">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Iframe">Iframe</label>
                                                                <input type="text" class="form-control" name="iframe" require placeholder="Link">
                                                                <small class="text-muted">Link para abrir aplicação dentro do sistema</small>
                                                            </div>
                                                            <div class="form-group form-check">
                                                                <input type="checkbox" class="form-check-input" name="status">
                                                                <label class="form-check-label" for="exampleCheck1">Ativo</label>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary" id="btnSendCadApi">Salvar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Nova Visualizar-->
                                        <div class="modal fade" id="modalIframe" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Visualizar</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe frameborder="0" id="previewIframe" width="100%" height="500px"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Testar API-->
                                        <div class="modal fade" id="testApi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Enviar mensagem</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formDataSendWpp">
                                                            <div class="form-group">
                                                                <label for="Número">Número</label>
                                                                <input type="number" class="form-control" name="numero" placeholder="Whatsapp" require>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Mensagem">Mensagem</label>
                                                                <textarea class="form-control" name="msg" rows="3" placeholder="Mensagem" require></textarea>
                                                            </div>

                                                            <input type="hidden" name="linkCurl" id="linkCurl">
                                                            <button type="submit" class="btn btn-primary" id="btnSendWpp">Enviar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="doc">

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Assunto</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listDocsApis">

                                            </tbody>
                                        </table>

                                        <hr>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novaDoc">Nova documentação</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="novaDoc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Escrever</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="formDataDoc">
                                                            <div class="form-group">
                                                                <label for="Assunto">Assunto</label>
                                                                <input type="text" class="form-control" name="assunto" placeholder="Titulo" require>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Documentar">Documentar</label>
                                                                <textarea class="form-control summernote" name="documentar" rows="3" require></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" id="btnSendCadDoc">Salvar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->