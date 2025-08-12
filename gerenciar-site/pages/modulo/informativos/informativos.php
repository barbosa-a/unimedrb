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
                <h1 class="m-0">
                    <?php echo $Pagina_Atual; ?>
                    <a href="<?php echo pg; ?>/pages/modulo/informativos/painel/painel_informativo">
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                        </button>
                    </a>
                </h1>

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

    <div class="row">

        <div class="col">
            <div class="container-fluid">

                <div class="row" id="loadInfos">

                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.col-->
        <div class="col-4">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">

                        <div class="input-group" style="width: 100%;">
                            <input type="text" id="search_infos" class="form-control float-right" placeholder="Pesquisar" autofocus oninput="buscarInfos(this.value)">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fa fa-tags" aria-hidden="true"></i> Categorias
                        </h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <ul class="list-unstyled" id="loadCatInfos"></ul>

                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.col-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.content -->