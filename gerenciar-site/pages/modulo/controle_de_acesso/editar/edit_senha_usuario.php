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
    //consultar usuário 
    $pesq_usuario = "SELECT * FROM usuarios us
        INNER JOIN unidade un ON un.id_uni = us.unidade_id 
        INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
        INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id WHERE us.token = '$usuario' LIMIT 1 ";
    $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
    $row_pesq_usuario = mysqli_fetch_assoc($query_pesq_usuario);
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
          <li class="breadcrumb-item">Página inicial</li>
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Inicio</a></li>
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
          <div class="card-header">
            <h5 class="m-0">Redefinir senha</h5>
          </div>
          <div class="card-body">
            <div>
                    <h5 class="card-title mb-0">Dados do usuário</h5> <br>
                    <strong class="text-uppercase"><?php echo $row_pesq_usuario['nome_user']; ?></strong>
                    <p>
                        Unidade: <?php echo $row_pesq_usuario['sigla_uni']; ?> /  
                        Login: <?php echo $row_pesq_usuario['login_user']; ?>  <hr>
                    </p>
                </div>
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/processa/proc_edit_senha_usuario" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="senha de acesso ao sistema">Nova senha</label>
                        <input type="password" class="form-control" name="nova_senha" placeholder="DIgite a nova senha" autofocus="" required="">
                    </div>
                    <div class="form-group">
                        <label for="senha de acesso ao sistema">Confirma nova senha</label>
                        <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar sua nova senha" required="">
                        <input type="hidden" class="form-control" name="usuario" value="<?php echo $row_pesq_usuario['id_user']; ?>">
                    </div>
                    <hr>
                    <input type="submit" class="btn btn-primary" value="Salvar" name="sendRedefinirSenha">
                    <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=<?php echo $usuario; ?>">
                        <button type="button" class="btn btn-secondary">Voltar</button>
                    </a>
                    <?php if ($botao_hist_atualizacao) { ?>
                        <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/listar/list_hist_atualizacao?usuario=<?php echo $usuario; ?>">
                            <button type="button" class="btn btn-info">
                                Histórico
                            </button>
                        </a>
                    <?php } ?> 
                </form>
            
          </div>
        </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->