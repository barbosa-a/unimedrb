<?php
if (!isset($seguranca)) {
    exit;
}
$SendUpContrato = filter_input(INPUT_POST, 'SendUpContrato', FILTER_DEFAULT);

if($SendUpContrato){
    $razao_social       = filter_input(INPUT_POST, 'razao_social', FILTER_DEFAULT);
    $nomeFantasia       = filter_input(INPUT_POST, 'nomeFantasia', FILTER_DEFAULT);
    $cnpj               = filter_input(INPUT_POST, 'cnpj', FILTER_DEFAULT);
    $email         		  = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $resp_financeiro   	= filter_input(INPUT_POST, 'resp_financeiro', FILTER_DEFAULT);
    $telefone          	= filter_input(INPUT_POST, 'telefone', FILTER_DEFAULT);

    $cep          = filter_input(INPUT_POST, 'cep', FILTER_DEFAULT);
    $endereco     = filter_input(INPUT_POST, 'endereco', FILTER_DEFAULT);
    $numero       = filter_input(INPUT_POST, 'numero', FILTER_DEFAULT);
    $bairro       = filter_input(INPUT_POST, 'bairro', FILTER_DEFAULT);
    $cidade       = filter_input(INPUT_POST, 'cidade', FILTER_DEFAULT);

    $telefone1           = filter_input(INPUT_POST, 'telefone1', FILTER_DEFAULT);
    $telefone2           = filter_input(INPUT_POST, 'telefone2', FILTER_DEFAULT);
    $telefone3           = filter_input(INPUT_POST, 'telefone3', FILTER_DEFAULT);
    $telefone4           = filter_input(INPUT_POST, 'telefone4', FILTER_DEFAULT);

    $estado          	= filter_input(INPUT_POST, 'estado', FILTER_DEFAULT);
    $plano              = filter_input(INPUT_POST, 'plano', FILTER_DEFAULT);
    $modelo_plano       = filter_input(INPUT_POST, 'modelo_plano', FILTER_DEFAULT);
    $vencimento_mensal  = filter_input(INPUT_POST, 'vencimento_mensal', FILTER_DEFAULT);
    $valor              = filter_input(INPUT_POST, 'valor', FILTER_DEFAULT);

    $inicio_contrato    = filter_input(INPUT_POST, 'inicio_contrato', FILTER_DEFAULT);
    $fim_contrato       = filter_input(INPUT_POST, 'fim_contrato', FILTER_DEFAULT);
    $qtd_usuarios       = filter_input(INPUT_POST, 'qtd_user_liberados', FILTER_SANITIZE_NUMBER_INT);
    $situacao       = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_NUMBER_INT);
    $contrato 			= filter_input(INPUT_POST, 'contrato', FILTER_SANITIZE_NUMBER_INT);

    //consultar plano
    $consPlano = "SELECT p.nome_plano, m.nome_mod_plano FROM planos p INNER JOIN modelos_plano m ON m.plano_id = p.idplano WHERE p.idplano = '$plano' AND m.idmodeloplano = '$modelo_plano' ";
    $query_consPlano = mysqli_query($conn, $consPlano);
    $dadoPlano = mysqli_fetch_assoc($query_consPlano);

    //salvar no banco
    $cad = "
		UPDATE contrato_sistema SET
			razao_social = '$razao_social',
      nome_fantasia = '$nomeFantasia',
			cnpj = '$cnpj', 
			email = '$email', 
			resp_financeiro = '$resp_financeiro', 
			telefone = '$telefone', 
      telefone1 = '$telefone1', 
      telefone2 = '$telefone2', 
      telefone3 = '$telefone3', 
      telefone4 = '$telefone4', 
			cep = '$cep', 
			rua = '$endereco', 
			numero = '$numero', 
			bairro = '$bairro', 
			cidade = '$cidade', 
			estado = '$estado', 
			plano = '".$dadoPlano['nome_plano']."', 
			modelo_plano = '".$dadoPlano['nome_mod_plano']."', 
			vencimento = '$vencimento_mensal', 
			valor_contrato = '$valor', 
			inicio_contrato = '$inicio_contrato', 
			fim_contrato = '$fim_contrato',
      qtd_usuarios_liberados = '$qtd_usuarios', 
      situacao_contrato_id = '$situacao',
			modifield_contrato = NOW()
		WHERE idcontratosistema = '$contrato';
	";
	$query_cad = mysqli_query($conn, $cad);  
	if (mysqli_affected_rows($conn) > 0) {
		$_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Sucesso!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Contrato atualizado com sucesso</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg."/pages/modulo/sistema/editar/edit_contrato?contrato=$contrato";
        echo '<script> location.replace("'.$url_destino.'"); </script>';
	}else{
		$_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Erro!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Erro ao atualizar contrato</p>
                      <code>'.mysqli_error($conn).'</code>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg."/pages/modulo/sistema/editar/edit_contrato?contrato=$contrato";
        echo '<script> location.replace("'.$url_destino.'"); </script>';
	}
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}