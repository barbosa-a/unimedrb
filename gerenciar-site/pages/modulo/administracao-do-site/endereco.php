<?php
if (!isset($seguranca)) {
    exit;
}

$end = listarDadosEndereco($conn);
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

                <form id="formDataEndereco">

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="Endereço">Endereço</label>
                                <textarea class="form-control" name="endereco" rows="3"><?php echo isset($end['endereco']) ? $end['endereco'] : "" ?></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="Horários">Horários</label>
                                <textarea class="form-control" name="horario" rows="3"><?php echo isset($end['horario']) ? $end['horario'] : "" ?></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="col">
                            <div class="form-group">
                                <label for="Telefone">Telefone principal</label>
                                <textarea class="form-control" name="telefone1" rows="3"><?php echo isset($end['telefone_principal']) ? $end['telefone_principal'] : "" ?></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="Telefone">Telefone secundário</label>
                                <textarea class="form-control" name="telefone2" rows="3"><?php echo isset($end['telefone_secundario']) ? $end['telefone_secundario'] : "" ?></textarea>
                            </div>
                        </div>
                        
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSendEnd">Salvar</button>
                </form>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->