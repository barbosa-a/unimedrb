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
$cons_fluxo = "SELECT * FROM apis WHERE id = '$id' LIMIT 1";
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
                    <li class="breadcrumb-item">Editar Api</li>
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
                <h5 class="m-0">Formulario editar Api</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_api">
                    <div class="form-group">
                        <label for="cURL">cURL</label>
                        <input type="text" class="form-control" name="curl" require placeholder="Link cURL" value="<?php echo $row['curl']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Requisição">Requisição</label>
                        <input type="text" class="form-control" name="requisicao" require placeholder="POST/GET" value="<?php echo $row['requisicao']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Tipo">Tipo</label>
                        <input type="text" class="form-control" name="tipo" require placeholder="WhatsApp" value="<?php echo $row['tipo']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Biblioteca">Biblioteca</label>
                        <input type="text" class="form-control" name="biblioteca" require placeholder="Nome do pacote" value="<?php echo $row['biblioteca']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="GitHub">GitHub</label>
                        <input type="text" class="form-control" name="github" require placeholder="Link" value="<?php echo $row['github']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Iframe">Iframe</label>
                        <input type="text" class="form-control" name="iframe" require placeholder="Link" value="<?php echo $row['iframe']; ?>">
                        <small class="text-muted">Link para abrir aplicação dentro do sistema</small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="status" <?php if ($row['status'] == 1) {
                            echo "checked";
                        } ?>>
                        <label class="form-check-label" for="exampleCheck1">Ativo</label>
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