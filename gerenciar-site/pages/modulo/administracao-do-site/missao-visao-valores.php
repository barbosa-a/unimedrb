<?php
if (!isset($seguranca)) {
    exit;
}

$dado = missaoVisaoValores($conn);
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

                <form id="formDataMissaVisaoValores">
                    <div class="form-group">
                        <label for="Missão">Missão</label>
                        <textarea class="form-control" name="missao" rows="3" required><?php echo !empty($dado['missao']) ? $dado['missao'] : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Visão">Visão</label>
                        <textarea class="form-control" name="visao" rows="3" required><?php echo !empty($dado['visao']) ? $dado['visao'] : "" ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Valores">Valores</label>
                        <textarea class="form-control" name="valores" rows="3" required><?php echo !empty($dado['valores']) ? $dado['valores'] : "" ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSend">Salvar</button>
                </form>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->