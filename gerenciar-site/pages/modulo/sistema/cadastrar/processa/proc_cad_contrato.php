<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadContrato = filter_input(INPUT_POST, 'SendCadContrato', FILTER_DEFAULT);

if($SendCadContrato){
    $razao_social       = filter_input(INPUT_POST, 'razao_social', FILTER_DEFAULT);
    $nomeFantasia       = filter_input(INPUT_POST, 'nomeFantasia', FILTER_DEFAULT);
    $cnpj               = filter_input(INPUT_POST, 'cnpj', FILTER_DEFAULT);
    $email         		= filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $resp_financeiro   	= filter_input(INPUT_POST, 'resp_financeiro', FILTER_DEFAULT);
    $telefone          	= filter_input(INPUT_POST, 'telefone', FILTER_DEFAULT);

    $cep          = filter_input(INPUT_POST, 'cep', FILTER_DEFAULT);
    $endereco     = filter_input(INPUT_POST, 'endereco', FILTER_DEFAULT);
    $numero       = filter_input(INPUT_POST, 'numero', FILTER_DEFAULT);
    $bairro       = filter_input(INPUT_POST, 'bairro', FILTER_DEFAULT);
    $cidade       = filter_input(INPUT_POST, 'cidade', FILTER_DEFAULT);
    $estado          	= filter_input(INPUT_POST, 'estado', FILTER_DEFAULT);

    $telefone1           = filter_input(INPUT_POST, 'telefone1', FILTER_DEFAULT);
    $telefone2           = filter_input(INPUT_POST, 'telefone2', FILTER_DEFAULT);
    $telefone3           = filter_input(INPUT_POST, 'telefone3', FILTER_DEFAULT);
    $telefone4           = filter_input(INPUT_POST, 'telefone4', FILTER_DEFAULT);

    $plano              = filter_input(INPUT_POST, 'plano', FILTER_DEFAULT);
    $modelo_plano       = filter_input(INPUT_POST, 'modelo_plano', FILTER_DEFAULT);
    $vencimento_mensal  = filter_input(INPUT_POST, 'vencimento_mensal', FILTER_DEFAULT);
    $valor              = filter_input(INPUT_POST, 'valor', FILTER_DEFAULT);

    $inicio_contrato    = filter_input(INPUT_POST, 'inicio_contrato', FILTER_DEFAULT);
    $fim_contrato       = filter_input(INPUT_POST, 'fim_contrato', FILTER_DEFAULT);
    $qtd_user_liberados = filter_input(INPUT_POST, 'qtd_user_liberados', FILTER_SANITIZE_NUMBER_INT);

    //dados de acesso
    $nome_completo      = filter_input(INPUT_POST, 'nome_completo', FILTER_DEFAULT);
    $email_user         = filter_input(INPUT_POST, 'email_user', FILTER_DEFAULT);
    $usuario            = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $senha              = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $senha_crip 		= password_hash($senha, PASSWORD_DEFAULT);
    $status         	= filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $unidade            = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_NUMBER_INT);
    $cargo              = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);
    $perfil_acesso      = filter_input(INPUT_POST, 'perfil_acesso', FILTER_SANITIZE_NUMBER_INT);
    $anotacao         	= filter_input(INPUT_POST, 'anotacao', FILTER_DEFAULT);

    //consultar plano
    $consPlano = "SELECT p.nome_plano, m.nome_mod_plano FROM planos p INNER JOIN modelos_plano m ON m.plano_id = p.idplano WHERE p.idplano = '$plano' AND m.idmodeloplano = '$modelo_plano' ";
    $query_consPlano = mysqli_query($conn, $consPlano);
    $dadoPlano = mysqli_fetch_assoc($query_consPlano);

    //consultar cnpj
    $cons_contrato = "SELECT cnpj, email FROM contrato_sistema WHERE (cnpj = '$cnpj' OR email = '$email') ";
    $query_cons_contrato = mysqli_query($conn, $cons_contrato);
    if(($query_cons_contrato) AND ($query_cons_contrato->num_rows > 0)){
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
                      <p class="text-center">Dados já cadastrado, tente novamente.</p>
                      <code>'.mysqli_error($conn).'</code>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/sistema";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }else{    	
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
                    $cad = "
			    		INSERT INTO contrato_sistema 
			    			(razao_social, nome_fantasia, cnpj, email, resp_financeiro, telefone, telefone1, telefone2, telefone3, telefone4, cep, rua, numero, bairro, cidade, estado, plano, modelo_plano, vencimento, valor_contrato, inicio_contrato, fim_contrato, anexo_contrato, qtd_usuarios_liberados, situacao_contrato_id, usuario_id, created_contrato) 
			    		VALUES 
			    			('$razao_social', '$nomeFantasia', '$cnpj','$email','$resp_financeiro','$telefone', '$telefone1', '$telefone2', '$telefone3', '$telefone4', '$cep','$endereco','$numero','$bairro','$cidade','$estado','".$dadoPlano['nome_plano']."','".$dadoPlano['nome_mod_plano']."','$vencimento_mensal','$valor','$inicio_contrato','$fim_contrato','$novoNome','$qtd_user_liberados', '1','".$_SESSION['usuarioID']."', NOW())
			    	";
			    	$query_cad = mysqli_query($conn, $cad);
                    if(mysqli_insert_id($conn)){
                    	$ultID = mysqli_insert_id($conn);
                        //Validar campo senha e retirar os espaços em branco
					    $senha_sem_espaco = str_replace(" ", "", $senha_crip);
					    //Verificar se o usuário esta cadastrado no banco de dados
					    $verifica_registro_user = "SELECT login_user FROM usuarios WHERE login_user = '$usuario' ";
					    $query_verifica_registro_user = mysqli_query($conn, $verifica_registro_user);
					    //Verificar se o email esta cadastrado no banco de dados
					    $verifica_registro_email = "SELECT email_user FROM usuarios WHERE email_user = '$email' ";
					    $query_verifica_registro_email = mysqli_query($conn, $verifica_registro_email);
					    //Validar a quantidade de caracteres no campo senha    
					    if((strlen($senha_sem_espaco)) < 6){
					    	//excluir contrato
					        $del_contrato = "DELETE FROM contrato_sistema WHERE idcontratosistema = '$ultID' ";
					        $query_del_contrato = mysqli_query($conn, $del_contrato);
					        $_SESSION['msg'] = '
					            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					                <div class="modal-dialog modal-dialog-centered modal-sm">
					                  <div class="modal-content">
					                    <div class="modal-header">
					                      <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
					                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                        <span aria-hidden="true">&times;</span>
					                      </button>
					                    </div>
					                    <div class="modal-body">
					                      <p class="text-center">Senha deve ter no minimo 6 caracteres.</p>
					                    </div>
					                    <div class="modal-footer">
					                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                    </div>
					                  </div>
					                </div>
					            </div>
					        ';
					    $url_destino = pg."/pages/modulo/sistema/sistema";
					    echo '<script> location.replace("'.$url_destino.'"); </script>';
					    }elseif(($query_verifica_registro_user) AND ($query_verifica_registro_user->num_rows !=0)){
					    	//excluir contrato
					        $del_contrato = "DELETE FROM contrato_sistema WHERE idcontratosistema = '$ultID' ";
					        $query_del_contrato = mysqli_query($conn, $del_contrato);
					        $_SESSION['msg'] = '
					            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					                <div class="modal-dialog modal-dialog-centered modal-sm">
					                  <div class="modal-content">
					                    <div class="modal-header">
					                      <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
					                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                        <span aria-hidden="true">&times;</span>
					                      </button>
					                    </div>
					                    <div class="modal-body">
					                      <p class="text-center">Usuário já cadastrado.</p>
					                    </div>
					                    <div class="modal-footer">
					                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                    </div>
					                  </div>
					                </div>
					            </div>
					        ';
					        $url_destino = pg."/pages/modulo/sistema/sistema";
					        echo '<script> location.replace("'.$url_destino.'"); </script>';
					    }elseif(($query_verifica_registro_email) AND ($query_verifica_registro_email->num_rows !=0)){
					    	//excluir contrato
					        $del_contrato = "DELETE FROM contrato_sistema WHERE idcontratosistema = '$ultID' ";
					        $query_del_contrato = mysqli_query($conn, $del_contrato);
					        $_SESSION['msg'] = '
					            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					                <div class="modal-dialog modal-dialog-centered modal-sm">
					                  <div class="modal-content">
					                    <div class="modal-header">
					                      <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
					                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                        <span aria-hidden="true">&times;</span>
					                      </button>
					                    </div>
					                    <div class="modal-body">
					                      <p class="text-center">E-mail já cadastrado.</p>
					                    </div>
					                    <div class="modal-footer">
					                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                    </div>
					                  </div>
					                </div>
					            </div>
					        ';
					        $url_destino = pg."/pages/modulo/sistema/sistema";
					        echo '<script> location.replace("'.$url_destino.'"); </script>';
					    }else{
					        //token de acesso
					        $bytes = random_bytes(32);
					        $token = hash('sha256', $bytes);
					        //Instrução para salvar no banco de dados
							$cad_user = "INSERT INTO usuarios 
							(nome_user, email_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, usuario_id, contrato_sistema_id, anotacao, criado_user, ult_token) 
							VALUES 
							('$nome_completo', '$email_user', '$usuario', '$senha_crip', '$token', '$perfil_acesso', '$status', '$cargo', '$unidade', '".$_SESSION['usuarioID']."', '$ultID', '$anotacao', NOW(), NOW())";
					        $query_cad_user = mysqli_query($conn, $cad_user);
					        //verificar se foi salvo no banco de dados
					        if(mysqli_insert_id($conn)){
					            //pegar o id do usuario cadastrado
					            $ult_id_usuario = mysqli_insert_id($conn);
					            //salvar o historico de alteração de senha
					            $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('$ult_id_usuario', '".$_SESSION['usuarioID']."', '3', NOW())";
					            $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
					            //mensagem
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
					                              <p class="text-center">Contrato cadastrado com sucesso e conta do usuário criada</p>
					                              <p class="text-left">
					                                Login de acesso: '.$usuario.' <br />
					                                Senha de acesso: '.$senha.'
					                              </p>
					                              <p class="text-left">
					                                Solicitar ao usuário que altere a senha no próximo login.
					                              </p>
					                            </div>
					                            <div class="modal-footer">
					                              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                            </div>
					                          </div>
					                        </div>
					                    </div>
					                ';
					                $url_destino = pg."/pages/modulo/sistema/sistema";
					                echo '<script> location.replace("'.$url_destino.'"); </script>';
					            }else{
					                $_SESSION['msg'] = '
					                    <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					                        <div class="modal-dialog modal-dialog-centered modal-sm">
					                          <div class="modal-content">
					                            <div class="modal-header">
					                              <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
					                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                                <span aria-hidden="true">&times;</span>
					                              </button>
					                            </div>
					                            <div class="modal-body">
					                              <p class="text-center">Historico de criação de senha não registrado.</p>
					                              <code>'.mysqli_error($conn).'</code>
					                            </div>
					                            <div class="modal-footer">
					                              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                            </div>
					                          </div>
					                        </div>
					                    </div>
					                ';
					                $url_destino = pg."/pages/modulo/sistema/sistema";
					                echo '<script> location.replace("'.$url_destino.'"); </script>';
					            }            
					        }else{
					        	//excluir contrato
						        $del_contrato = "DELETE FROM contrato_sistema WHERE idcontratosistema = '$ultID' ";
						        $query_del_contrato = mysqli_query($conn, $del_contrato);
					            $_SESSION['msg'] = '
					                <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					                    <div class="modal-dialog modal-dialog-centered modal-sm">
					                      <div class="modal-content">
					                        <div class="modal-header">
					                          <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
					                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                            <span aria-hidden="true">&times;</span>
					                          </button>
					                        </div>
					                        <div class="modal-body">
					                          <p class="text-center">Conta de usuário não registrada</p>
					                          <code>'.mysqli_error($conn).'</code>
					                        </div>
					                        <div class="modal-footer">
					                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					                        </div>
					                      </div>
					                    </div>
					                </div>
					            ';
					            $url_destino = pg."/pages/modulo/sistema/sistema";
					            echo '<script> location.replace("'.$url_destino.'"); </script>';
					        }
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
                    $url_destino = pg."/pages/modulo/sistema/sistema";
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
                    $url_destino = pg."/pages/modulo/sistema/sistema";
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
                $url_destino = pg."/pages/modulo/sistema/sistema";
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
            $url_destino = pg."/pages/modulo/sistema/sistema";
            echo '<script> location.replace("'.$url_destino.'"); </script>';	
        }
    }       
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}