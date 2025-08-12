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
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalprint">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>
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
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">

                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Contato</th>
                            <th scope="col">Data</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="load-simulacao"></tbody>
                </table>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalprint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Impressão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formPrint">
                            <div class="row">
                                <div class="col">
                                    <label for="Inicio">Inicio</label>
                                    <input type="date" class="form-control" id="dtinicio" required>
                                </div>
                                <div class="col">
                                    <label for="Fim">Fim</label>
                                    <input type="date" class="form-control" id="dtfim" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="printSimulacao()">Imprimir</button>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->