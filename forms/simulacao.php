<?php 
	
	//Biblioteca auxiliares
 	$seguranca = true; 
  	include_once "../gerenciar-site/config/config.php";
  	include_once "../gerenciar-site/config/conexao.php";

	$form = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {

	    $email = $form['email'];

	    $msg = array(
            'tipo' => 'error', 
            'titulo' => 'E-mail inválido', 
            'msg' => "O endereço de e-mail $email é considerado inválido."
        );

        echo json_encode($msg);	

        exit();
	}

	try {

		$query = "INSERT INTO site_simulacao (cidade, ass_medica, sexo, faixaEtaria, qtd, nomeEmpresa, cnpj, email, nomeContato, telefone, status, created) 
			VALUES ('{$form['city']}', '{$form['assMed']}', '{$form['sexo']}', '{$form['faixaEtaria']}', '{$form['qtd']}', '{$form['nomeEmpresa']}', '{$form['cnpj']}', '{$form['email']}', '{$form['nomeContato']}', '{$form['tel']}', 'Aguardando', NOW())
		";
		$result = $conn->query($query);

		$msg = array(
            'tipo' => 'success', 
            'titulo' => 'Sucesso', 
            'msg' => "Solicitação de simulação registrada com sucesso"
        );

        echo json_encode($msg);	

	} catch (Exception $e) {

		$msg = array(
            'tipo' => 'error', 
            'titulo' => 'Ops...', 
            'msg' => "Erro: " . $e->getMessage()
        );

        echo json_encode($msg);	
		
	}
 ?>