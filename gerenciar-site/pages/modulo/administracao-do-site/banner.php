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
                        <a class="nav-link active" id="custom-content-below-add-tab" data-toggle="pill" href="#custom-content-below-add" role="tab" aria-controls="custom-content-below-add" aria-selected="true">Adicionar banner</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-img-tab" data-toggle="pill" href="#custom-content-below-img" role="tab" aria-controls="custom-content-below-img" aria-selected="false">Meus banners</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-ads-tab" data-toggle="pill" href="#custom-content-below-ads" role="tab" onclick="listarAds01()">Informativo</a>
                    </li>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-add" role="tabpanel" aria-labelledby="custom-content-below-add-tab">

                        <form method="POST" id="formDataBanner" enctype="multipart/form-data">

                            <h5>Dados do Banner <hr></h5>

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

                            <div class="form-row">

                                <div class="form-group col">
                                    <label for="Data inicio">Data inicio</label>
                                    <input type="date" class="form-control" name="dt_inicio" autocomplete="off">
                                </div>

                                <div class="form-group col">
                                    <label for="Data fim">Data fim</label>
                                    <input type="date" class="form-control" name="dt_fim" autocomplete="off">
                                </div>

                                <div class="form-group col">
                                    <label for="Unidade">Unidade</label>
                                    <select class="form-control select2" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                                            <option value="<?php echo $row_unidade['id_uni']; ?>"><?php echo $row_unidade['nome_uni']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="Link da página">Link da página</label>
                                <input type="text" class="form-control" name="link" autocomplete="off" placeholder="Página">
                            </div>

                            <div class="form-group">
                                <label for="Descrição">Descrição</label>
                                <textarea class="form-control" name="desc" id="desc" cols="10"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Arquivo">Arquivo</label>
                                <input type="file" class="form-control-file" name="arquivo" required>
                                <small class="text-muted">Dimensões minimas: 1220 x 270 (png, jpeg, jpg ou gif)</small>
                            </div>

                            <h5>Cards informativos<hr></h5>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="Titulo">Titulo</label>
                                    <input type="text" class="form-control textcase" name="tituloCardOne" autocomplete="off" placeholder="Titulo do card" onblur="formatanome(this.value)">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="Link">Link</label>
                                    <input type="text" class="form-control" name="linkCardOne" autocomplete="off" placeholder="Página">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Descrição">Descrição</label>
                                <textarea class="form-control" name="descCardOne" id="descCardOne" cols="10"></textarea>
                            </div>


                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="SendCadBanner" id="SendCadBanner" value="Salvar">
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-img" role="tabpanel" aria-labelledby="custom-content-below-img-tab">

                        <ul class="todo-list" data-widget="todo-list" id="list-banners">

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-ads" role="tabpanel" aria-labelledby="custom-content-below-ads-tab">

                        <div class="row">
                            <div class="col-3 col-sm-3">

                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-sec01-tab" data-toggle="pill" href="#vert-tabs-sec01" role="tab" onclick="listarAds01()">Info 1</a>
                                    <a class="nav-link" id="vert-tabs-sec02-tab" data-toggle="pill" href="#vert-tabs-sec02" role="tab" onclick="listarAds02()">Info 2</a>
                                    <a class="nav-link" id="vert-tabs-sec03-tab" data-toggle="pill" href="#vert-tabs-sec03" role="tab" onclick="listarAds03()">Info 3</a>
                                </div>

                            </div>
                            <div class="col-9 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">

                                    <div class="tab-pane fade show active" id="vert-tabs-sec01" role="tabpanel" aria-labelledby="vert-tabs-sec01-tab">

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdAds01">
                                            Adicionar
                                        </button>

                                        <table class="table table-striped mt-3 projects">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-ads01">

                                            </tbody>
                                        </table>

                                        <!-- Modal -->
                                        <div class="modal fade" id="mdAds01" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar <small class="text-muted">anúncio 01</small> </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form method="POST" id="formDataSec01" enctype="multipart/form-data">

                                                            <div class="form-row">
                                                                <div class="form-group col">
                                                                    <label for="Titulo">Titulo</label>
                                                                    <input type="text" class="form-control textcase" name="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Legenda">Legenda</label>
                                                                <textarea class="form-control" name="legenda" rows="3" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Link da página">Link da página</label>
                                                                <input type="text" class="form-control" name="link" autocomplete="off" placeholder="Página">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Arquivo">Arquivo</label>
                                                                <input type="file" class="form-control-file" name="arquivo">
                                                                <small class="text-muted">Dimensões: 750 x 92 (png, jpeg, jpg ou gif)</small>
                                                            </div>


                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-primary" name="SendCadSec01" id="SendCadSec01" value="Salvar">
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="vert-tabs-sec02" role="tabpanel" aria-labelledby="vert-tabs-sec02-tab">

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdAds02">
                                            Adicionar
                                        </button>

                                        <table class="table table-striped mt-3 projects">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-ads02">

                                            </tbody>
                                        </table>

                                        <!-- Modal -->
                                        <div class="modal fade" id="mdAds02" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar <small class="text-muted">anúncio 02</small> </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form method="POST" id="formDataSec02" enctype="multipart/form-data">

                                                            <div class="form-row">
                                                                <div class="form-group col">
                                                                    <label for="Titulo">Titulo</label>
                                                                    <input type="text" class="form-control textcase" name="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Legenda">Legenda</label>
                                                                <textarea class="form-control" name="legenda" rows="3" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Link da página">Link da página</label>
                                                                <input type="text" class="form-control" name="link" autocomplete="off" placeholder="Página">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Arquivo">Arquivo</label>
                                                                <input type="file" class="form-control-file" name="arquivo">
                                                                <small class="text-muted">Dimensões: 263 x 353 (png, jpeg, jpg ou gif)</small>
                                                            </div>


                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-primary" name="SendCadSec02" id="SendCadSec02" value="Salvar">
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="vert-tabs-sec03" role="tabpanel" aria-labelledby="vert-tabs-sec03-tab">

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdAds03">
                                            Adicionar
                                        </button>

                                        <table class="table table-striped mt-3 projects">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-ads03">

                                            </tbody>
                                        </table>

                                        <!-- Modal -->
                                        <div class="modal fade" id="mdAds03" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Adicionar <small class="text-muted">anúncio 03</small> </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form method="POST" id="formDataSec03" enctype="multipart/form-data">

                                                            <div class="form-row">
                                                                <div class="form-group col">
                                                                    <label for="Titulo">Titulo</label>
                                                                    <input type="text" class="form-control textcase" name="titulo" required autocomplete="off" autofocus placeholder="Titulo" onblur="formatanome(this.value)">
                                                                </div>

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Legenda">Legenda</label>
                                                                <textarea class="form-control" name="legenda" rows="3" required></textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Link da página">Link da página</label>
                                                                <input type="text" class="form-control" name="link" autocomplete="off" placeholder="Página">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Arquivo">Arquivo</label>
                                                                <input type="file" class="form-control-file" name="arquivo">
                                                                <small class="text-muted">Dimensões: 750 x 111 (png, jpeg, jpg ou gif)</small>
                                                            </div>


                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-primary" name="SendCadSec03" id="SendCadSec03" value="Salvar">
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

                    </div>

                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->