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

                <div class="row mb-5">
                    <div class="col-md-8 offset-md-2">
                        <form action="#">
                            <div class="input-group">
                                <input type="search" class="form-control form-control-lg" placeholder="Digite para pesquisar artigo" oninput="pesquisarArtigos(this.value)" autofocus>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <?php if ($btn_cad_artigo) { ?>
                                        <a href="<?php echo pg; ?>/pages/modulo/base-de-conhecimento/cadastrar/cad_artigo">
                                            <button type="button" class="btn btn-lg btn-default">
                                                <i class="fa fa-plus"></i> Artigo
                                            </button>
                                        </a>
                                    <?php } ?>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="resulArtigos"></div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->