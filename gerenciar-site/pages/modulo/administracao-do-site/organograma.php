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

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newOrganograma">Upload</button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Organograma</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="list-organograma">

                        

                    </tbody>
                </table>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="newOrganograma" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Organograma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="formDataOrganograma">
                    <div class="form-group">
                        <label for="Imagem">Imagem</label>
                        <input type="file" class="form-control-file" name="arquivo" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnSendOrgan">Salvar</button>
                </form>

            </div>
        </div>
    </div>
</div>