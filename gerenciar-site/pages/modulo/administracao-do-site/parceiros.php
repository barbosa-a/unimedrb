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
        <div class="row">

            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-body">

                        <form id="formDataParceiros">

                            <div class="form-group">
                                <label for="Nome">Nome</label>
                                <input type="text" class="form-control" name="nome" require autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="Link">Link</label>
                                <input type="text" class="form-control" name="link" require autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="Imagem">Imagem</label>
                                <input type="file" class="form-control-file" name="arquivo" require>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendParceiros">Salvar</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col">

                <div class="card card-primary card-outline">
                    <div class="card-body">

                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Imagem
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="list-parceiros">

                                
                                
                                
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->