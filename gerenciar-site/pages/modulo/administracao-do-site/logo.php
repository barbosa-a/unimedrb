<?php
if (!isset($seguranca)) {
    exit;
}

$logo1 = logo($conn, "Cabeçalho");
$logo2 = logo($conn, "Rodapé");
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
        <div class="row">
            <div class="col-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">

                        <img src="<?php echo pg . $logo1['arquivo'] ?>" class="rounded img-fluid mx-auto d-block" alt="<?php echo $logo1['logo'] ?>" width="200">

                        <form id="formDataLogoCabecalho">
                            <div class="form-group">
                                <label for="Cabeçalho">Cabeçalho</label>
                                <input type="file" class="form-control-file" name="arquivo" require>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendLogoCabecalho">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">

                        <img src="<?php echo pg . $logo2['arquivo'] ?>" class="rounded img-fluid mx-auto d-block" alt="<?php echo $logo2['logo'] ?>" width="150">

                        <form id="formDataLogoRodape">
                            <div class="form-group">
                                <label for="Cabeçalho">Rodapé</label>
                                <input type="file" class="form-control-file" name="arquivo" require>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendLogoRodape">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->