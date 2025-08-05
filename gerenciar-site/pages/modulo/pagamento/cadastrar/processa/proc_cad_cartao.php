<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['titular']) AND !empty($dados['cpf']) AND !empty($dados['ncartao']) AND !empty($dados['mes']) AND !empty($dados['ano']) AND !empty($dados['cod']) AND !empty($dados['funcao']) AND !empty($_SESSION['contratoUSER'])) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';        

        try {

            $conn->begin_transaction();

            $cons = "SELECT id FROM usuarios_cartao WHERE contrato_sistema_id = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
            $query = $conn->query($cons);
            if (($query) AND ($query->num_rows > 0)) {
                
                //Atualizar dados do cartão
                $upCartao = "UPDATE 
                    usuarios_cartao 
                    SET 
                        titular = '{$dados['titular']}', 
                        cpf = '{$dados['cpf']}', 
                        emailTitular = '{$dados['email']}', 
                        ncartao = '{$dados['ncartao']}', 
                        mes = '{$dados['mes']}', 
                        ano = '{$dados['ano']}', 
                        cod = '{$dados['cod']}', 
                        usuarios_cartao_funcao_id = '{$dados['funcao']}',                        
                        created = NOW()
                    WHERE
                        contrato_sistema_id = '{$_SESSION['contratoUSER']}'
                ";
                $query_upCartao = $conn->query($upCartao);                

            } else {
                
                $cadCartao = "INSERT INTO usuarios_cartao 
                    (titular, cpf, emailTitular, ncartao, mes, ano, cod, usuarios_cartao_funcao_id, contrato_sistema_id, created) 
                    VALUES 
                    ('{$dados['titular']}', '{$dados['cpf']}', '{$dados['email']}', '{$dados['ncartao']}', '{$dados['mes']}', '{$dados['ano']}', '{$dados['cod']}', '{$dados['funcao']}', '{$_SESSION['contratoUSER']}', NOW())
                ";
                $query_cadCartao = $conn->query($cadCartao);               

            }            

            $conn->commit();

            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Cartão registrado com sucesso');
            echo json_encode($response);

        } catch (Exception $e) {

            $conn->rollback();
            
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. $e->getMessage());
            echo json_encode($response);
        }
               
    }else {

        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos os dados necessários');
        echo json_encode($response);
    }
    