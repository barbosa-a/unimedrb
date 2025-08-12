<?php
if (!isset($seguranca)) {
    exit;
}
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
//recuperar dados vindo da url
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//consultar fluxos
$cons_fluxo = "SELECT * FROM apis_documentacao WHERE id = '$id' LIMIT 1";
$query_fluxo = mysqli_query($conn, $cons_fluxo);
$row = mysqli_fetch_assoc($query_fluxo);
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
                    <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Inicio</a></li>
                    <li class="breadcrumb-item">Editar documentação</li>
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
            <div class="card-header">
                <h5 class="m-0">Formulario editar documentação</h5>
            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_doc">
                    <div class="form-group">
                        <label for="Assunto">Assunto</label>
                        <input type="text" class="form-control" name="assunto" placeholder="Titulo" require value="<?php echo $row['assunto']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Documentar">Documentar</label>
                        <textarea class="form-control summernote" name="documentar" rows="3" require><?php echo $row['documentacao']; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->