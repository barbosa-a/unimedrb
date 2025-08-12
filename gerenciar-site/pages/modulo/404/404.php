<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>404 ‎Página de erro‎</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item active">Página de erro‎</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="error-page">
    <h2 class="headline text-warning"> 404</h2>
    <div class="error-content">
      <h3>
        <i class="fas fa-exclamation-triangle text-warning"></i> 
        Oops! Página não encontrada.
      </h3>

      <p>
        Talvez seu nivel de acesso não permite acessar esta página.
        <br><br>
        Permissão necessária: 
        <br>
        <code><?php echo $url; ?></code>
        <br>
        <a href="<?php echo pg; ?>/pages/modulo/home/home">Retorna a página inicial</a>
      </p>
    </div>
    <!-- /.error-content -->
  </div>
  <!-- /.error-page -->
</section>
<!-- /.content -->