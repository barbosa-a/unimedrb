<?php
	session_start();
    //segurança do ADM
    $seguranca = true;
    //conexão
    include_once ("../../../../../config/config.php");
    include_once ("../../../../../config/conexao.php");

    if (!btnCadastro) {
        die("Impossivel conectar a url");
    }

    $dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (empty($dado['nomeCompleto']) OR empty($dado['documento']) OR empty($dado['email']) OR empty($dado['numero']) OR empty($dado['senha'])) {

        $msg = array(
            'tipo' => 'info', 
            'titulo' => 'Atenção', 
            'msg' => 'Preencha todos os campos'
        );

        echo json_encode($msg);	
    }else{

        //Verificar se ja existe cadastro
        $cons = "SELECT 
                cs.idcontratosistema 
            FROM 
                contrato_sistema cs
            INNER JOIN usuarios us ON us.email_user = cs.email
            WHERE 
                cs.cnpj = '{$dado['documento']}' OR 
                cs.email = '{$dado['email']}' OR
                us.login_user = '{$dado['email']}'
            LIMIT 1
        ";
        $query = mysqli_query($conn, $cons);
        if (($query) AND ($query->num_rows == 0)) {
            
            try {

                $conn->begin_transaction();

                // Obtém a data atual
                $dataAtual = new DateTime();
        
                // Adiciona 7 dias à data atual
                $dataAtual->modify('+7 days');
        
                // Obtém a data formatada
                $validade = $dataAtual->format('Y-m-d');

                //token de acesso
                $bytes = random_bytes(32);
                $token = hash('sha256', $bytes);

                // Senha criptografada
                $senha = password_hash($dado['senha'], PASSWORD_DEFAULT);
                
                // Cadastrar contrato
                $cad = "INSERT INTO contrato_sistema 
                    (razao_social, cnpj, email, telefone, situacao_contrato_id, inicio_contrato, fim_contrato, qtd_usuarios_liberados, created_contrato) 
                        VALUES 
                    ('{$dado['nomeCompleto']}', '{$dado['documento']}', '{$dado['email']}', '{$dado['numero']}', 4, NOW(), '{$validade}', 1, NOW())";
                $query_cad = mysqli_query($conn, $cad);

                $contratoID = mysqli_insert_id($conn);

                if (mysqli_insert_id($conn)) {

                    // Cadastrar usuário
                    $cad_user = "INSERT INTO usuarios 
                    (nome_user, email_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, contrato_sistema_id, usuarios_autenticacao_id, criado_user, ult_token) 
                    VALUES 
                    ('{$dado['nomeCompleto']}', '{$dado['email']}', '{$dado['email']}', '{$senha}', '{$token}', 3, 5, 2, 1, '{$contratoID}', 2, NOW(), NOW())";
                    $query_cad_user = mysqli_query($conn, $cad_user);

                }

                $conn->commit();
        
                $msg = array(
                    'tipo' => 'success', 
                    'titulo' => 'Sucesso', 
                    'msg' => 'Registro cadastrado com sucesso. Acesse com seu e-mail e senha de cadastro.'
                );
        
                echo json_encode($msg);	

            } catch (Exception $err) {

                $conn->rollback();
                
                $msg = array(
                    'tipo' => 'error', 
                    'titulo' => 'Erro de processamento', 
                    'msg' => 'Erro ao salvar registro, tente novamente! ' . $err->getMessage()
                );
        
                echo json_encode($msg);	
            }

        } else {

            $msg = array(
                'tipo' => 'error', 
                'titulo' => 'Ops...', 
                'msg' => 'Cadastro não autorizado'
            );

            echo json_encode($msg);	
        }
    }