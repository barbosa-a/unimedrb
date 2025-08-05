<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $seguranca = true;
    include_once '../../../../../config/config.php';
    include_once '../../../../../config/conexao.php';

    // Inicia a transação
    $conn->begin_transaction();

    try {

        $arquivo 	= $_FILES['arquivo']['name'];
		
		//Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = '../../../../../dist/img/';
		
		//Tamanho máximo do arquivo em Bytes
		$_UP['tamanho'] = 1024*1024*100; //5mb
		
		//Array com a extensões permitidas
		$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
		
		//Renomeiar
		$_UP['renomeia'] = true;
		
		//Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		//verificar as dimensões da imagem
		$size = getimagesize($_FILES['arquivo']['tmp_name']);
		
		//dimensões para imagens
		$width = 1426;
		$height = 690;
		
		//Verifica se houve algum erro com o upload. Sem sim, exibe a mensagem do erro
		if($_FILES['arquivo']['error'] != 0){
			$msg = array(
				'tipo' => 'error', 
				'titulo' => 'Erro de processamento', 
				'msg' => 'Não foi possivel fazer o upload <br> erro: '. $_UP['erros'][$_FILES['arquivo']['error']]
			);

			echo json_encode($msg);
			
		}
		
		//Faz a verificação da extensao do arquivo
		$extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
		if(array_search($extensao, $_UP['extensoes'])=== false){	
			$msg = array(
				'tipo' => 'error', 
				'titulo' => 'Erro de processamento', 
				'msg' => 'Arquivo com extesão inválida'
			);

			echo json_encode($msg);	
		}
		
		//Faz a verificação do tamanho do arquivo
		else if ($_UP['tamanho'] < $_FILES['arquivo']['size']){
			$msg = array(
				'tipo' => 'error', 
				'titulo' => 'Erro de processamento', 
				'msg' => 'Arquivo maior que 5mb'
			);

			echo json_encode($msg);	
		}
		
        else{
            //Cria um nome baseado no UNIX TIMESTAMP atual
            $nome_final = time().'.'.$extensao;
            //Verificar se é possivel mover o arquivo para a pasta escolhida
            if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta']. $nome_final)){

                //Caminho
                $dir = "/dist/img/" . $nome_final;

                $cad = "UPDATE quiz_config SET logo = '{$dir}', usuario_id = '{$_SESSION['usuarioID']}', modified = NOW()";
                $query_cad = mysqli_query($conn, $cad);
                
                // Commit da transação
                $conn->commit();

                $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro salvo com sucesso');
                echo json_encode($response);			
            }else{
                //Upload não efetuado com sucesso, exibe a mensagem
                $msg = array(
                    'tipo' => 'error', 
                    'titulo' => 'Erro de processamento', 
                    'msg' => 'Não foi possivel mover o arquivo para o diretório.'
                );
                echo json_encode($msg);	
            }
        }       
        

    } catch (Exception $e) {

        // Rollback em caso de erro
        $conn->rollback();

        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. $e->getMessage());
        echo json_encode($response);
    }
    