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

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdFaq">
                    Nova Faq
                </button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pergunta</th>
                            <th scope="col">Resposta</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="load-faq"></tbody>
                </table>

            </div>
        </div>
        <!-- /.row -->
        <div class="modal fade" id="mdFaq" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nova FAQ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="formDataFaq">

                            <div class="form-group">
                                <label for="Pergunta">Pergunta</label>
                                <input class="form-control" name="pergunta" required placeholder="Pergunta" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="Resposta">Resposta</label>
                                <textarea class="form-control" name="resposta" required rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btnSendContato">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->