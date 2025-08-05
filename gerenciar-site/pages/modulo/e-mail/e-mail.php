<?php
if (!isset($seguranca)) {
    exit;
}
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
$dadosEmail = listEmail($conn);
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
                        <a class="nav-link active" id="custom-tabs-three-servidor-tab" data-toggle="pill" href="#custom-tabs-three-servidor" role="tab" aria-controls="custom-tabs-three-servidor" aria-selected="true">Servidor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-modelos-tab" data-toggle="pill" href="#custom-tabs-three-modelos" role="tab" aria-controls="custom-tabs-three-modelos" aria-selected="false">Modelos</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-servidor" role="tabpanel" aria-labelledby="custom-tabs-three-servidor-tab">
                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/e-mail/cadastrar/processa/proc_cad_servidor" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="Servidor SMTP">Servidor SMTP</label>
                                    <input type="text" class="form-control" name="host" require placeholder="Host" autocomplete="off" autofocus value="<?php echo $dadosEmail['host'] ?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="Porta">Porta</label>
                                    <input type="number" class="form-control" name="porta" require placeholder="Porta" autocomplete="off" value="<?php echo $dadosEmail['porta'] ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Nome destinatário">Nome destinatário</label>
                                    <input type="text" class="form-control" name="nome" require placeholder="Destinatário" autocomplete="off" value="<?php echo $dadosEmail['nome_usuario'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Usuário SMTP">Usuário SMTP</label>
                                    <input type="text" class="form-control" name="usuario" require placeholder="Usuário" autocomplete="off" value="<?php echo $dadosEmail['usuario'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Senha SMTP">Senha SMTP</label>
                                    <input type="password" class="form-control" name="senha" require placeholder="Senha" autocomplete="off" value="<?php echo $dadosEmail['senha'] ?>">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" name="SendCadSrvEmail" value="Salvar">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-form-envio">Testar servidor</button>
                        </form>
                        <!-- Modal -->
                        <div class="modal fade" id="modal-form-envio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Formulário</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" id="formDataEmailTeste">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">E-mail</label>
                                                <input type="email" class="form-control" name="email" require placeholder="E-mail">
                                            </div>
                                            <div class="form-group">
                                                <label for="Nome">Nome</label>
                                                <input type="text" class="form-control" name="nome" require placeholder="Destinatário">
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="testarSrvEmail">Testar</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-modelos" role="tabpanel" aria-labelledby="custom-tabs-three-modelos-tab">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (listModelosEmails($conn) as $modelo) { ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><?php echo $modelo['nome_mod'] ?></td>
                                        <td><?php echo $modelo['titulo'] ?></td>
                                        <td><?php echo $modelo['data'] ?></td>
                                        <td>
                                            <!-- Default dropleft button -->
                                            <div class="btn-group dropleft">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false" id="<?php echo $modelo['id'] ?>">
                                                    Menu
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEditModelo<?php echo $modelo['id'] ?>">Editar</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDelModelo<?php echo $modelo['id'] ?>">Apagar</a>
                                                    <a class="dropdown-item" href="#" onclick="sendEmailModeloTeste(<?php echo $modelo['id'] ?>, <?php echo $modelo['id_mod'] ?>)">Testar e-mail</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Editar Modelo-->
                                    <div class="modal fade" id="modalEditModelo<?php echo $modelo['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Editar</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="<?php echo pg; ?>/pages/modulo/e-mail/editar/processa/proc_edit_modelo">
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-8">
                                                                <label for="Titulo">Titulo</label>
                                                                <input type="text" class="form-control" name="titulo" placeholder="Titulo" require autocomplete="off" value="<?php echo $modelo['titulo'] ?>">
                                                            </div>
                                                            <div class="form-group col-sm-4">
                                                                <label class="form-label">Modulo</label>
                                                                <select class="form-control" name="modulo" required="">
                                                                    <option value="">Selecione o modulo</option>
                                                                    <?php foreach (ListModulos($conn) as $mod) { ?>
                                                                        <option value="<?php echo $mod['id_mod']; ?>" <?php if ($mod['id_mod'] == $modelo['modulo_id']) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>>
                                                                            <?php echo $mod['nome_mod']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Texto">Texto</label>
                                                            <textarea class="form-control summernote" name="texto" rows="3" require><?php echo $modelo['texto'] ?></textarea>
                                                        </div>
                                                        <ul class="list-unstyled">
                                                            <li><b>Tags de preenchimento:</b>
                                                                <ul>
                                                                    <li>#nome_completo</li>
                                                                    <li>#email</li>
                                                                    <li>#login</li>
                                                                    <li>#senha</li>
                                                                    <li>#empresa</li>
                                                                    <li>#usuario_logado</li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                        <input type="hidden" name="id" value="<?php echo $modelo['id'] ?>">
                                                        <input type="submit" class="btn btn-primary" name="SendEditModeloEmail" value="Salvar">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Deletar modelo-->
                                    <div class="modal fade" id="modalDelModelo<?php echo $modelo['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
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
                                                    <a href="<?php echo pg; ?>/pages/modulo/e-mail/apagar/proc_del_modelo?id=<?php echo $modelo['id'] ?>">
                                                        <button type="button" class="btn btn-danger">Excluir</button>
                                                    </a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </tbody>
                        </table>
                        <hr>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalModelo">Novo modelo</button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalModelo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Modelo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/e-mail/cadastrar/processa/proc_cad_modelo">
                                            <div class="form-row">
                                                <div class="form-group col-sm-8">
                                                    <label for="Titulo">Titulo</label>
                                                    <input type="text" class="form-control" name="titulo" placeholder="Titulo" require autocomplete="off">
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="form-label">Modulo</label>
                                                    <select class="form-control" name="modulo" required="">
                                                        <option value="">Selecione o modulo</option>
                                                        <?php echo ListarModulos($conn); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Texto">Texto</label>
                                                <textarea class="form-control summernote" name="texto" rows="3" require></textarea>
                                            </div>
                                            <ul class="list-unstyled">
                                                <li><b>Tags de preenchimento:</b>
                                                    <ul>
                                                        <li>#nome_completo</li>
                                                        <li>#email</li>
                                                        <li>#login</li>
                                                        <li>#senha</li>
                                                        <li>#empresa</li>
                                                        <li>#usuario_logado</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <input type="submit" class="btn btn-primary" name="SendCadModeloEmail" value="Salvar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->