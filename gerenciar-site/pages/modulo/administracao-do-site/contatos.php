<?php
if (!isset($seguranca)) {
    exit;
}

$end = listarDadosContato($conn);
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

                <form id="formDataContato">

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="E-mail">E-mail</label>
                                <textarea class="form-control" name="enderecoEmail" rows="3"><?php echo isset($end['enderecoEmail']) ? $end['enderecoEmail'] : "" ?></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="WhatsApp">WhatsApp</label>
                                <textarea class="form-control" name="numeroWpp" rows="3"><?php echo isset($end['numeroWpp']) ? $end['numeroWpp'] : "" ?></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="col">
                            <div class="form-group">
                                <label for="Telefone">Telefone Fixo</label>
                                <textarea class="form-control" name="telefoneFixo" rows="3"><?php echo isset($end['telefoneFixo']) ? $end['telefoneFixo'] : "" ?></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="Telefone">Telefone Celular</label>
                                <textarea class="form-control" name="telefoneCelular" rows="3"><?php echo isset($end['telefoneCelular']) ? $end['telefoneCelular'] : "" ?></textarea>
                            </div>
                        </div>
                        
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSendContato">Salvar</button>
                </form>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->