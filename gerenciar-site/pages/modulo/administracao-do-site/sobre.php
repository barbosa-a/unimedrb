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
                        <a class="nav-link active" id="custom-content-below-add-tab" data-toggle="pill" href="#custom-content-below-add" role="tab">Adicionar</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-sobre-img-tab" data-toggle="pill" href="#custom-content-below-sobre-img" role="tab" onclick="listarBannerSobre()">Imagens</a>
                    </li>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-add" role="tabpanel" aria-labelledby="custom-content-below-add-tab">

                        <form method="POST" id="formDataSobre" enctype="multipart/form-data">

                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="Titulo">Titulo</label>
                                    <input type="text" class="form-control textcase" name="titulo" id="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="Sobre">Sobre</label>
                                <textarea class="form-control pub-destaque" name="sobre" id="sobre" rows="10"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Resumo">Resumo</label>
                                <textarea class="form-control" name="resumo" id="resumo" rows="5"></textarea>
                            </div>


                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="SendCadSobre" id="SendCadSobre" value="Salvar">
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-sobre-img" role="tabpanel" aria-labelledby="custom-content-below-sobre-img-tab">

                        <div class="row">
                            <div class="col-6 jumbotron">
                                <h3 class="">Cadastrar imagem</h3>
                                <hr class="my-4">
                                <form method="POST" id="formDataBannerSobre" enctype="multipart/form-data">

                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="Titulo">Titulo</label>
                                            <input type="text" class="form-control textcase" name="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="Transição">Transição</label>
                                            <input type="time" step="2" class="form-control" name="transicao" required autocomplete="off" autofocus placeholder="Tempo de Transição">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="Descrição">Descrição</label>
                                        <textarea class="form-control" name="desc" id="desc" cols="10"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="Arquivo">Arquivo</label>
                                        <input type="file" class="form-control-file" name="arquivo" required>
                                        <small class="text-muted">Dimensões minimas: 1920 x 1080 (png, jpeg, jpg ou gif)</small>
                                    </div>


                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="SendCadBannerSobre" id="SendCadBannerSobre" value="Salvar">
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <ul class="todo-list" data-widget="todo-list" id="list-sobre-img">
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