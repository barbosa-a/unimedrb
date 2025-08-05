<?php
if (!isset($seguranca)) {
    exit;
}
$sendAtualizarAnexo = filter_input(INPUT_POST, 'sendAtualizarAnexo', FILTER_DEFAULT);

if($sendAtualizarAnexo){
    $contrato      = filter_input(INPUT_POST, 'contrato', FILTER_SANITIZE_NUMBER_INT);

    // verifica se foi enviado um arquivo
        if (isset($_FILES['arquivo']['name']) && $_FILES['arquivo']['error'] == 0) {        
            //echo 'Você enviou o arquivo: <strong>' . $_FILES['arquivo']['name'] . '</strong><br />';
            //echo 'Este arquivo é do tipo: <strong > ' . $_FILES['arquivo']['type'] . ' </strong ><br />';
            //echo 'Temporáriamente foi salvo em: <strong>' . $_FILES['arquivo']['tmp_name'] . '</strong><br />';
            //echo 'Seu tamanho é: <strong>' . $_FILES['arquivo']['size'] . '</strong> Bytes<br /><br />';

            $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
            $nome = $_FILES['arquivo']['name'];

            // Pega a extensão
            $extensao_arquivo = pathinfo($nome, PATHINFO_EXTENSION);

            // Converte a extensão para minúsculo
            $extensao = strtolower($extensao_arquivo);

            // Somente imagens, .jpg;.jpeg;.gif;.png
            // Aqui eu enfileiro as extensões permitidas e separo por ';'
            // Isso serve apenas para eu poder pesquisar dentro desta String
            if (strstr('.pdf', $extensao)) {
                // Cria um nome único para esta imagem
                // Evita que duplique as imagens no servidor.
                // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                $novoNome = uniqid(time()) . '.' . $extensao;

                // Concatena a pasta com o nome
                $destino = 'pages/modulo/sistema/contratos/' . $novoNome;

                // tenta mover o arquivo para o destino
                if (move_uploaded_file($arquivo_tmp, $destino)) {
                    //salvar no banco
                    $up = "
			    		UPDATE contrato_sistema SET anexo_contrato = '$novoNome', modifield_contrato = NOW() WHERE idcontratosistema = '$contrato'
			    	";
			    	$query_cad = mysqli_query($conn, $up);
                    if(mysqli_affected_rows($conn) != 0){                    	
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
	                                  <p class="text-center">Contrato atualizado com sucesso.</p>
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
                    } else {
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
	                                  <p class="text-center">Erro ao cadastrar, tente novamente.</p>
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
                                  <p class="text-center">Erro de escrita, contate o administrador.</p>
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
                              <p class="text-center">Extensões permitidas:</p>
                              <p class="text-center">
                                <code>
                                    *.pdf
                                </code>
                              </p>
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
                          <p class="text-center">Necessário anexar o contrato para continuar.</p>
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