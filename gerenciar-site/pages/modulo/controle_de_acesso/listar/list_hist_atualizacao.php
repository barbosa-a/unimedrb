<?php
    if (!isset($seguranca)) {
        exit;
    }
    //recuperar dados vindo da url
    $usuario = filter_input(INPUT_GET, 'usuario', FILTER_DEFAULT);
    //consultar usuário 
    $pesq_usuario = "SELECT us.id_user, us.nome_user, un.sigla_uni, us.login_user, us.criado_user FROM usuarios us
        INNER JOIN unidade un ON un.id_uni = us.unidade_id 
        INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
        INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id WHERE us.token= '$usuario' LIMIT 1 ";
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
            <h5 class="m-0">Histórico de atualizações</h5>
          </div>
          <div class="card-body">
            <div class="">
                <h5 class="text-uppercase mb-0 "><?php echo $row_pesq_usuario['nome_user']; ?></h5>
                <p>
                    Unidade: <?php echo $row_pesq_usuario['sigla_uni']; ?> /  
                    Login: <?php echo $row_pesq_usuario['login_user']; ?> <br>
                    Cadastro: <?php echo date('d/m/Y H:i:s', strtotime($row_pesq_usuario['criado_user'])); ?>
                </p>
            </div>
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
                            <?php echo ListarHistoricoSenhaUsuario($row_pesq_usuario['id_user'], $conn); ?> 
                        </tbody>
                    </table>
                    <hr>
                    <a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_senha_usuario?usuario=<?php echo $usuario; ?>">
                        <button type="button" class="btn btn-secondary">Voltar</button>
                    </a>
                </div>
          </div>
        </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->