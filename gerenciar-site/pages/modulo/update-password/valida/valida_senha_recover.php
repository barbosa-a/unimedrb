<?php
    //inicializar sessão
    session_start();
    $sendRedefinirSenha = filter_input(INPUT_POST, 'sendRedefinirSenha', FILTER_DEFAULT);
    //Verificar se a variavel possui um valor
    if ($sendRedefinirSenha) {
        $seguranca = true;
        include_once("../../../../config/conexao.php");
        $usuario                = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
        $senha_atual            = filter_input(INPUT_POST, 'senha_atual', FILTER_DEFAULT);
        $senha_atual_crip       = password_hash($senha_atual, PASSWORD_DEFAULT);
        $nova_senha             = filter_input(INPUT_POST, 'nova_senha', FILTER_DEFAULT);
        $nova_senha_crip        = password_hash($nova_senha, PASSWORD_DEFAULT);
        $confirmar_senha        = filter_input(INPUT_POST, 'confirmar_senha', FILTER_DEFAULT);
        $confirmar_senha_crip   = password_hash($confirmar_senha, PASSWORD_DEFAULT);
        $token                  = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);
        if((empty($usuario)) AND (empty($senha_atual)) AND (empty($nova_senha)) AND (empty($confirmar_senha))){
            $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <small><i class="icon fas fa-info"></i> Necessario preencher todos os campos.</small>
                                </div>';
            header("Location: ../../../../login.php");
        } else {
            //comparar dados do usuário
            $pesq_usuario = "SELECT * FROM usuarios WHERE login_user= '$usuario' LIMIT 1 ";
            $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
            if($query_pesq_usuario){
                $row_usuario = mysqli_fetch_array($query_pesq_usuario);
                if ($row_usuario['usuarios_autenticacao_id'] == 1) {

                    //$msg = array('tipo' => 'info', 'titulo' => 'Não autorizado', 'msg' => 'Usuário vinculado API');
                    //echo json_encode($msg);
                    $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <small><i class="icon fas fa-ban"></i> Não autorizado! Usuário vinculado API: '.$usuario.'</small>
                                        </div>';
                    header("Location: ../../../../login.php");
        
                } elseif($usuario == $row_usuario['login_user'] AND $token == $row_usuario['token']){
                    if(password_verify($senha_atual, $row_usuario['senha_user'])){
                        if($nova_senha == $confirmar_senha){
                            //token de acesso
                            $bytes = random_bytes(32);
                            $token_up = hash('sha256', $bytes);
                            //update para alterar a senha do usuário
                            $up_senha = "UPDATE usuarios SET senha_user = '$confirmar_senha_crip', token='$token_up', situacoes_usuario_id='5', modificado_user = NOW(), ult_token = NOW() WHERE id_user = '".$row_usuario['id_user']."' LIMIT 1 ";
                            $query_up_senha = mysqli_query($conn, $up_senha);
                            if(mysqli_affected_rows($conn) != 0){
                                //salvar o historico de alteração de senha
                                $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('".$row_usuario['id_user']."', '".$row_usuario['id_user']."', '1', NOW())";
                                $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
                                //mensagem
                                if(mysqli_insert_id($conn)){
                                    $_SESSION['msg'] = '<div class="alert alert-success alert-dismissible">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                          <small><i class="icon fas fa-check"></i> Senha redefinida com sucesso</small>
                                                        </div>';
                                    header("Location: ../../../../login.php");
                                }else{
                                    $_SESSION['msg'] = '<div class="alert alert-warning alert-dismissible">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                          <small><i class="icon fas fa-exclamation-triangle"></i> Senha redefinida com sucesso com erro na geração do histórico.</small>
                                                        </div>';
                                    header("Location: ../../../../login.php");
                                }
                            } else {
                                $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                      <small><i class="icon fas fa-ban"></i> Erro ao alterar a senha do usuário: '.$usuario.'</small>
                                                    </div>';
                                header("Location: ../../../../login.php");
                            }
                        }else{
                            $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <small><i class="icon fas fa-info"></i> Nova senha diferente da senha de confirmação.</small>
                                                </div>';
                            header("Location: ../../../../login.php");
                        }
                    } else {
                        $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <small><i class="icon fas fa-info"></i> Senha atual não confere</small>
                                            </div>';
                        header("Location: ../../../../login.php");
                    }
                } else {
                    $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <small><i class="icon fas fa-info"></i> Token inválido para o usuário: '.$usuario.'</small>
                                        </div>';
                    header("Location: ../../../../login.php");
                }
            } else {
                $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <small><i class="icon fas fa-info"></i> Usuário não encontrado.</small>
                                    </div>';
                header("Location: ../../../../login.php");
            }
        }        
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <small><i class="icon fas fa-ban"></i> Erro ao processar solicitação</small>
                            </div>';
        header("Location: ../../../../login.php");
    }
?>
