<?php
session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['cep']) AND !empty($dados['rua']) AND !empty($dados['numero']) AND !empty($dados['bairro']) AND !empty($dados['cidade']) AND !empty($dados['uf'])) {
    $seguranca = true;
    include_once '../../../../../config/config.php';
    include_once '../../../../../config/conexao.php';

    try {

        $conn->begin_transaction();

        $cons = "SELECT idcontratosistema FROM contrato_sistema WHERE idcontratosistema = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
        $query = $conn->query($cons);
        if (($query) and ($query->num_rows > 0)) {

            //Atualizar endereço do contrato
            $upContrato = "UPDATE 
                    contrato_sistema 
                SET 
                    cep = '{$dados['cep']}', 
                    rua = '{$dados['rua']}', 
                    numero = '{$dados['numero']}', 
                    bairro = '{$dados['bairro']}', 
                    cidade = '{$dados['cidade']}', 
                    estado = '{$dados['uf']}',                         
                    modifield_contrato = NOW()
                WHERE
                    idcontratosistema = '{$_SESSION['contratoUSER']}'
            ";
            $query_upContrato = $conn->query($upContrato);

            $conn->commit();

            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Endereço de cobrança salvo com sucesso');
            echo json_encode($response);
        } else {

            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Seu contrato não foi localizado, atualize a página e tente novamente.');
            echo json_encode($response);
        }
    } catch (Exception $e) {

        $conn->rollback();

        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: ' . $e->getMessage());
        echo json_encode($response);
    }
} else {

    // Retorna uma resposta em JSON para o JavaScript
    $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos os dados necessários');
    echo json_encode($response);
}
