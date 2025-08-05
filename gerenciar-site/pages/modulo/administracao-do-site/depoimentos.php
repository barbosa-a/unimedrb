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
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Depoimentos</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdAdd">
            <i class="fa fa-plus"></i> Adicionar
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>
                #
              </th>
              <th>
                Nome
              </th>
              <th class="text-center">
                Data
              </th>
              <th>
              </th>
            </tr>
          </thead>
          <tbody id="listar-depoimentos">

          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="mdAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Adicionar depoimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="formDataDepoimento">

          <div class="form-group">
            <label for="Nome">Nome</label>
            <input type="text" class="form-control" name="nome" placeholder="" require>
          </div>

          <div class="form-group">
            <label for="Cargo/função">Cargo/função</label>
            <input type="text" class="form-control" name="cargoFuncao" placeholder="" require>
          </div>

          <div class="form-group">
            <textarea class="form-control trumbowyg-pub" name="texto" rows="3" require></textarea>
          </div>

          <div class="form-group">
            <label for="Foto">Foto</label>
            <input type="file" class="form-control-file" name="arquivo" require>
          </div>

          <button type="submit" class="btn btn-primary" id="sendCadDep">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

        </form>

      </div>
    </div>
  </div>
</div>