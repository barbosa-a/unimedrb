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
        <div class="jumbotron">
          <div class="row">
            <div class="col-10">
              <h1 class="display-4">Bem-vindo, <?php echo $_SESSION['usuarioLOGIN'] ?>!</h1>
            </div>
            <div class="col">
              
            </div>
          </div>
          <hr class="my-4">
          <a class="btn btn-primary btn-lg" href="#" role="button">Leia mais sobre</a>
        </div> 
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->