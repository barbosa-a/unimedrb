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
        <h1 class="m-0"><?php echo NomePagina($_SESSION['usuarioNIVEL'], filter_input(INPUT_GET, 'url', FILTER_DEFAULT), $conn); ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">          
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item">Meu perfil</li>
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
      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="<?php echo pg; ?><?php if (empty(Usuarios("foto", $conn))) { ?>
                /dist/img/user-default-160x160.png
              <?php }else{ 
               echo "/".Usuarios("foto", $conn); 
              } ?>" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?php echo Usuarios("nome_user", $conn); ?></h3>

            <p class="text-muted text-center"><?php echo Usuarios("nome_cargo", $conn); ?></p>

            <!--<ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Followers</b> <a class="float-right">1,322</a>
              </li>
              <li class="list-group-item">
                <b>Following</b> <a class="float-right">543</a>
              </li>
              <li class="list-group-item">
                <b>Friends</b> <a class="float-right">13,287</a>
              </li>
            </ul>-->

            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#imgPerfil"><b>Imagem</b></a>
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
                    <form id="formDataAvatarPerfil" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Imagem</label>
                        <input type="file" class="form-control-file" name="arquivo" require>
                      </div>
                      <button type="submit" class="btn btn-primary" id="btnSendCadAvatar">Salvar imagem</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Sobre mim</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fa fa-university" aria-hidden="true"></i> Empresa</strong>

            <p class="text-muted">
              <?php echo Usuarios("razao_social", $conn); ?>
            </p>

            <hr>

            <strong><i class="fa fa-map-marker mr-1"></i> Unidade</strong>

            <p class="text-muted"><?php echo Usuarios("nome_uni", $conn); ?></p>

            <hr>

            <strong><i class="fa fa-briefcase" aria-hidden="true"></i> Departamento</strong>

            <p class="text-muted">
              <?php echo Usuarios("nome_depar", $conn); ?>
            </p>

            <hr>

            <strong><i class="fa fa-id-card" aria-hidden="true"></i> Perfil de acesso</strong>

            <p class="text-muted"><?php echo Usuarios("nome_nvl", $conn); ?></p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#atividade" data-toggle="tab">Atividade</a></li>
              <li class="nav-item"><a class="nav-link" href="#meus_dados" data-toggle="tab">Meus dados</a></li>
              <li class="nav-item"><a class="nav-link" href="#redefinir_senha" data-toggle="tab">Redefinir senha</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="atividade">

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="meus_dados">
                <form method="POST" action="<?php echo pg; ?>/pages/modulo/meu_perfil/processa/proc_altera_usuario" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="Nome completo">Nome completo</label>
                    <input type="text" class="form-control" name="nome_completo" autocomplete="off" placeholder="Meu nome" required oninput="upperCase(event)" value="<?php echo Usuarios("nome_user", $conn); ?>" />
                  </div>
                  <div class="form-group">
                    <label for="E-mail">E-mail</label>
                    <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Meu e-mail" required value="<?php echo Usuarios("email_user", $conn); ?>">
                  </div>
                  <div class="form-group">
                    <?php if ($btn_altera_usuario_perfil) { ?>
                      <input type="submit" class="btn btn-primary" name="SendUpPerfil" value="Salvar">
                    <?php } else { ?>
                      <input type="button" class="btn btn-primary" name="SendUpPerfil" value="Salvar" disabled="">
                    <?php } ?>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="redefinir_senha">
                <form method="POST" action="<?php echo pg; ?>/pages/modulo/meu_perfil/processa/proc_altera_senha" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="form-label">Senha atual</label>
                    <input type="password" class="form-control" name="senha_atual" placeholder="Digite a senha atual" required="" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Nova senha</label>
                    <input type="password" class="form-control" name="nova_senha" placeholder="Digite a nova senha" required="" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Confirmar senha</label>
                    <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar sua nova senha" required="" autocomplete="off">
                  </div>
                  <?php if ($btn_altera_senha_perfil) { ?>
                    <input type="submit" name="SendUpSenha" class="btn btn-primary" value="Alterar">
                  <?php } else { ?>
                    <input type="button" name="SendUpSenha" class="btn btn-primary" value="Alterar" disabled="" />
                  <?php } ?>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->