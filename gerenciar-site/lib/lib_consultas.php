<?php 
	session_start();
	//segurança do ADM
    $seguranca = true; 
    include_once("../config/config.php"); 
	include_once("../config/conexao.php");
	include_once("lib_funcoes.php");
	include_once("lib_botoes.php"); 

	if (!empty($_GET['planoa'])) {
		$plano = $_GET['planoa'];
		$cons_modelo_plano = "SELECT idmodeloplano, nome_mod_plano, valor_plano FROM modelos_plano WHERE plano_id = '".$plano."' ";
		$query_cons_modelo_plano = mysqli_query($conn, $cons_modelo_plano);
		while ($mdPlano = mysqli_fetch_assoc($query_cons_modelo_plano)) {
		    $modelo[] = array_map('utf8_encode', $mdPlano); 
		}
		echo json_encode($modelo);
	}

?> 