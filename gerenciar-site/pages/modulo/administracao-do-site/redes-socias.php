<?php
if (!isset($seguranca)) {
    exit;
}

$arr_status = ['Ativo', 'Inativo'];

$rede = listarDadosRedeSocial($conn);

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

                <form id="formDataRedeSocial">

                    <div class="form-group">
                        <label for="Facebook">Facebook</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="facebook" placeholder="Endereço" value="<?php echo $rede['facebook'] ?>">
                            <div class="input-group-append">
                                <select class="form-control" name="status_facebook">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($arr_status as $st) { ?>
                                        <option value="<?php echo $st ?>" <?php echo $rede['status_facebook'] == $st ? "selected" : "" ?>>
                                            <?php echo $st ?>
                                        </option>
                                    <?php } ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Instagram">Instagram</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="instagram" placeholder="Endereço" value="<?php echo $rede['instagram'] ?>">
                            <div class="input-group-append">
                                <select class="form-control" name="status_instagram">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($arr_status as $st) { ?>
                                        <option value="<?php echo $st ?>" <?php echo $rede['status_instagram'] == $st ? "selected" : "" ?>>
                                            <?php echo $st ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Youtube">Youtube</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="youtube" placeholder="Endereço" value="<?php echo $rede['youtube'] ?>">
                            <div class="input-group-append">
                                <select class="form-control" name="status_youtube">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($arr_status as $st) { ?>
                                        <option value="<?php echo $st ?>" <?php echo $rede['status_youtube'] == $st ? "selected" : "" ?>>
                                            <?php echo $st ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Linkedin">Linkedin</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="linkedin" placeholder="Endereço" value="<?php echo $rede['linkedin'] ?>">
                            <div class="input-group-append">
                                <select class="form-control" name="status_linkedin">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($arr_status as $st) { ?>
                                        <option value="<?php echo $st ?>" <?php echo $rede['status_linkedin'] == $st ? "selected" : "" ?>>
                                            <?php echo $st ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btnSendRedeSocial">Salvar</button>

                </form>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->