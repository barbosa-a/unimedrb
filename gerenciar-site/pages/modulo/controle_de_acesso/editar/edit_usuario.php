<?php
if (!isset($seguranca)) {
    exit;
}
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
//recuperar dados vindo da url
$usuario = filter_input(INPUT_GET, 'usuario', FILTER_DEFAULT);
//Consultar usuario
$cons_usuario = "SELECT * FROM usuarios WHERE token = '$usuario' LIMIT 1 ";
$query_cons_usuario = mysqli_query($conn, $cons_usuario);
$row_usuario = mysqli_fetch_array($query_cons_usuario);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn); ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">Controle de acesso</a></li>
                    <li class="breadcrumb-item">Editar usuário</li>
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
                        <a class="nav-link active" id="custom-tabs-three-dados-tab" data-toggle="pill" href="#custom-tabs-three-dados" role="tab" aria-controls="custom-tabs-three-dados" aria-selected="true">Dados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-imagem-tab" data-toggle="pill" href="#custom-tabs-three-imagem" role="tab" aria-controls="custom-tabs-three-imagem" aria-selected="false">Imagem</a>
                    </li>
                    <?php if ($_SESSION['usuarioNIVEL'] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-contrato-tab" data-toggle="pill" href="#custom-tabs-three-contrato" role="tab" aria-controls="custom-tabs-three-contrato" aria-selected="false">Contrato</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-senha-tab" data-toggle="pill" href="#custom-tabs-three-senha" role="tab" aria-controls="custom-tabs-three-senha" aria-selected="false">Redefinir senha</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-historico-tab" data-toggle="pill" href="#custom-tabs-three-historico" role="tab" aria-controls="custom-tabs-three-historico" aria-selected="false">Histórico de senha</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-dados" role="tabpanel" aria-labelledby="custom-tabs-three-dados-tab">

                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_usuario" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Nome completo do usuário">Nome completo</label>
                                    <input type="text" class="form-control" name="nome_completo" placeholder="Nome completo" required="" autofocus="" value="<?php echo $row_usuario['nome_user']; ?>" oninput="upperCase(event)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="E-mail do usuário">E-mail</label>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" required="" value="<?php echo $row_usuario['email_user']; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="Usuário de acesso ao sistema">Usuário</label>
                                    <input type="text" class="form-control" name="login_user" placeholder="Nome de usuário" required="" value="<?php echo $row_usuario['login_user']; ?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="Locação ou função do usuário">Cargo</label>
                                    <select name="cargo" class="form-control" required="">
                                        <option value="">Selecione...</option>
                                        <?php echo ListarCargosUsuario($row_usuario['cargo_id'], $conn); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Local de trabalho do usuário">Unidade</label>
                                    <select name="unidade" class="form-control" required="">
                                        <option value="">Selecione...</option>
                                        <?php echo ListarUnidadesUsuario($row_usuario['unidade_id'], $conn); ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Status do usuário">Status</label>
                                    <select name="status" class="form-control" required="">
                                        <option value="">Selecione...</option>
                                        <?php echo ListarStatusUsuario($row_usuario['situacoes_usuario_id'], $conn); ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Perfil de acesso do usuário">Perfil de acesso</label>
                                    <select name="perfil_acesso" class="form-control" required="">
                                        <option value="">Selecione...</option>
                                        <?php echo ListarPerfilUsuario($_SESSION['usuarioORDEM'], $row_usuario['niveis_acesso_id'], $conn); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="Descrição">Descrição</label>
                                    <textarea name="anotacao" class="form-control" placeholder="Observação do usuário" rows="3"><?php echo $row_usuario['anotacao']; ?></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />
                            <input type="submit" class="btn btn-primary" value="Salvar" name="sendEditarUser">
                            <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
                                <button type="button" class="btn btn-secondary">Voltar</button>
                            </a>
                            <!--<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_senha_usuario?usuario=<?php echo $usuario; ?>">
                                <input type="button" class="btn btn-secondary" value="Redefinir senha" name="redefinir_senha" />
                            </a>-->
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-imagem" role="tabpanel" aria-labelledby="custom-tabs-three-imagem-tab">

                        <div class="media">
                            <img src="<?php echo empty($row_usuario['foto']) ? pg . '/dist/img/user-default-160x160.png' : pg . "/" . $row_usuario['foto']; ?>" class="mr-3 img-fluid profile-user-img" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">Foto do perfil</h5>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#imgPerfil"><b>Imagem</b></a>
                            </div>
                        </div>

                        <!-- Modal Alterar Imagem Perfil -->
                        <div class="modal fade" id="imgPerfil" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Alterar imagem</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formDataFotoPerfil" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Imagem</label>
                                                <input type="file" class="form-control-file" name="arquivo" require>
                                                <input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />
                                            </div>
                                            <button type="submit" class="btn btn-primary" id="btnSendCadAvatar">Salvar imagem</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-contrato" role="tabpanel" aria-labelledby="custom-tabs-three-contrato-tab">

                        <form action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_contrato" method="post">
                            <div class="form-group">
                                <label for="Contrato do usuário">Contrato atual</label>
                                <select name="contrato" class="form-control select2" required="">
                                    <option value="">Selecione...</option>
                                    <?php foreach (contratoSistemas($conn) as $ct) { ?>
                                        <option value="<?php echo $ct['idcontratosistema']; ?>" <?php echo $ct['idcontratosistema'] == $row_usuario['contrato_sistema_id'] ? "selected" : "" ?>>
                                            <?php echo $ct['razao_social']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <input type="hidden" class="form-control" name="usuario" value="<?php echo $usuario; ?>">

                            <input type="submit" class="btn btn-primary" value="Salvar" name="sendEditContrato">
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-senha" role="tabpanel" aria-labelledby="custom-tabs-three-senha-tab">

                        <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_senha_usuario" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="senha de acesso ao sistema">Nova senha</label>
                                <input type="password" class="form-control" name="nova_senha" placeholder="DIgite a nova senha" autofocus="" required="">
                            </div>
                            <div class="form-group">
                                <label for="senha de acesso ao sistema">Confirma nova senha</label>
                                <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar sua nova senha" required="">
                                <input type="hidden" class="form-control" name="usuario" value="<?php echo $usuario; ?>">
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary" value="Salvar" name="sendRedefinirSenha">
                            <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
                                <button type="button" class="btn btn-secondary">Voltar</button>
                            </a>
                            <?php if ($botao_hist_atualizacao) { ?>
                                <!--<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/listar/list_hist_atualizacao?usuario=<?php echo $usuario; ?>">
                                    <button type="button" class="btn btn-info">
                                        Histórico
                                    </button>
                                </a>-->
                            <?php } ?>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-historico" role="tabpanel" aria-labelledby="custom-tabs-three-historico-tab">

                        <div class="table-responsive">
                            <table class="table mb-0 table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Operador</th>
                                        <th scope="col">Evento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo ListarHistoricoSenhaUsuario($row_usuario['id_user'], $conn); ?>
                                </tbody>
                            </table>
                            <hr>
                            <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/controle_de_acesso">
                                <button type="button" class="btn btn-secondary">Voltar</button>
                            </a>
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