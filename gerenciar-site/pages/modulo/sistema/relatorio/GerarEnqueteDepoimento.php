<?php 
	//segurança do ADM
	$seguranca = true;
	$dataInicioEnquete = filter_input(INPUT_GET, 'dtinicio', FILTER_DEFAULT);
	$dataFimEnquete 	 = filter_input(INPUT_GET, 'dtfim', FILTER_DEFAULT);
	$contrato 				 = filter_input(INPUT_GET, 'contrato', FILTER_SANITIZE_NUMBER_INT);
	include_once("../../../../config/conexao.php");
	include_once("../../../../lib/lib_funcoes.php");

	$dadosContrato = ListarDadosContrato($contrato, $conn);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Relatório de avaliação do sistema">
    <meta name="author" content="Kalleb Alves Barbosa">
    <meta name="generator" content="Company Cloud">
    <title><?php echo dados_sistema("nome_sistema", $conn); ?> · Relatório da enquete</title>
    <style type="text/css">
    	.enquete{
    		position: fixed;
    		bottom: 0;
    		
    		font-weight: bold;
    		width: 100%;
    	}

    	.enquete, .left{
    		left: 0px;
    		text-align: left;
    	}

    	.enquete, .right{
    		right: 0px;
    		text-align: right;
    	}

    	.img{
    		bottom: 50px;
    		position: relative;
    	}
    </style>
    <!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<meta name="theme-color" content="#7952b3">
  </head>
  <body>
    
	<div class="col-lg-8 mx-auto p-3 py-md-5">

	  <main>
	    <table class="table table-bordered mb-5">
			  <thead>
			  	<tr>
			  		<td rowspan="4" class="">
					    <img class="img" src="../../../../dist/img/AdminLTELogo.png" alt="Logo" width="90">
			  		</td>
			  	</tr>
			    <tr>
			      <td colspan="2" class="fs-4">Relatorio de avaliação do sistema</td>
			    </tr>
			    <tr>
			      <td colspan="2"><?php echo $dadosContrato['nome_fantasia'] ?></td>
			    </tr>
			    <tr>
			      <td >Periodo: <br> <?php echo date("d/m/Y", strtotime($dataInicioEnquete)) ." à ". date("d/m/Y", strtotime($dataFimEnquete)) ?></td>
			      <td class="">Gerado: <br> <?php echo date("d/m/Y H:i:s") ?></td>
			    </tr>
			  </thead>
			</table>
		<h3 class="text-center mb-5">Resultado da avaliação <br><small class="text-muted">FeedBack</small></h3>
	    <table class="table table-striped">
	    	<thead>
			    <tr>
			      <th scope="col">FeedBack</th>
			      <th scope="col">Data</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach (PesquisarEnqueteDepoimento($conn, $contrato, $dataInicioEnquete, $dataFimEnquete, 1) as $msg) { ?>
			  		<tr>
				      <th scope="row"><?php echo $msg['obs']; ?></th>
				      <td><?php echo $msg['dt']; ?></td>
				    </tr>
			  	<?php } ?>		    
			  </tbody>
		</table>
	  </main>
	 	<footer class="enquete">
	  	<div class="row">
	  		<div class="col-6 left">
	  			<?php echo dados_sistema("nome_empresa", $conn); ?>	
	  		</div>
	  		<div class="col-6 right">
	  			<?php echo dados_sistema("nome_sistema", $conn); ?>	v<?php echo dados_sistema("versao", $conn); ?>	
	  		</div>
	  	</div>
	  </footer> 
	</div>
	<script src="js/bootstrap.bundle.min.js"></script>      
  </body>
</html>
