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
            <div class="card-body">

                <ul class="nav nav-tabs mb-3" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-novo-ceo-tab" data-toggle="pill" href="#custom-content-below-novo-ceo" role="tab">Novo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-ceos-tab" data-toggle="pill" href="#custom-content-below-ceos" role="tab" onclick="listarCeo()">Todos</a>
                    </li>
                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-novo-ceo" role="tabpanel" aria-labelledby="custom-content-below-novo-ceo-tab">

                        <form id="formDataCeo">
                            <div class="form-group">
                                <label for="Nome">Nome</label>
                                <input type="text" class="form-control" name="nome" placeholder="Nome completo" require>
                            </div>

                            <div class="form-group">
                                <label for="descrição">Descrição</label>
                                <input type="text" class="form-control" name="descricao" placeholder="Descrição">
                            </div>

                            <div class="form-group">
                                <label for="Biografia">Biografia</label>
                                <textarea class="form-control trumbowyg-pub" name="biografia" rows="3" require></textarea>
                            </div>

                            <h5>Virgência
                                <hr>
                            </h5>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="Data inicio">Data inicio</label>
                                        <input type="date" class="form-control" name="data_inicio" placeholder="Descrição" require>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="Data fim">Data fim</label>
                                        <input type="date" class="form-control" name="data_fim" placeholder="Descrição">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Foto">Foto</label>
                                <input type="file" class="form-control-file" name="arquivo" require>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendCeo">Salvar</button>

                        </form>

                    </div>

                    <div class="tab-pane fade" id="custom-content-below-ceos" role="tabpanel" aria-labelledby="custom-content-below-ceos-tab">

                        <div class="row" id="list-ceo">
                            
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->