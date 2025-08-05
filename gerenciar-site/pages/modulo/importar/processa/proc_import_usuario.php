<?php
if (!isset($seguranca)) {
    exit;
}
$SendImportUsuario = filter_input(INPUT_POST, 'SendImportUsuario', FILTER_SANITIZE_STRING);

if($SendImportUsuario){
    $contrato   = filter_input(INPUT_POST, 'contrato', FILTER_SANITIZE_NUMBER_INT);
    $cargo      = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);
    $unidade    = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($_FILES['arquivo']['tmp_name'])) {
        //extensão
        $ext = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        if ($ext == 'xml') {
            $arquivo = new DomDocument();
            $arquivo->load($_FILES['arquivo']['tmp_name']);
            $linhas = $arquivo->getElementsByTagName("Row");
            foreach ($linhas as $linha) {
                //token de acesso
                $bytes = random_bytes(32);
                $token = hash('sha256', $bytes);
                //Dados
                $nome  = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
                $email = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
                $login = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
                $senha = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
                $senha_crip = password_hash($senha, PASSWORD_DEFAULT);
                //Query
                $cad_user = "INSERT INTO usuarios 
                (nome_user, email_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, usuario_id, contrato_sistema_id, anotacao, criado_user, ult_token) 
                VALUES 
                ('$nome', '$email', '$login', '$senha_crip', '$token', '$perfil_acesso', '1', '$cargo', '$unidade', '{$_SESSION['usuarioID']}', '$contrato', null, NOW(), NOW())";
                $query_cad_user = mysqli_query($conn, $cad_user);
                //pegar o id do usuario cadastrado
                $ult_id_usuario = mysqli_insert_id($conn);
                //salvar o historico de alteração de senha
                $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('$ult_id_usuario', '{$_SESSION['usuarioID']}', '3', NOW())";
                $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
            }
            if (mysqli_insert_id($conn)) {
                $_SESSION['msg'] = '
                    <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-sm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sucesso</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body m-3">
                                    <p class="mb-0 text-center">Usuários importados com sucesso.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    '
                ;
                $url_destino = pg . "/pages/modulo/importar/importar";
                echo '<script> location.replace("' . $url_destino . '"); </script>';
            }else{
                $_SESSION['msg'] = '
                    <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-sm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Erro</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body m-3">
                                    <p class="mb-0 text-center">Erro ao importar usuários 
                                        <br>'.mysqli_error($conn).'
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    '
                ;
                $url_destino = pg . "/pages/modulo/importar/importar";
                echo '<script> location.replace("' . $url_destino . '"); </script>';
            }

        } else {
            $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Erro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-3">
                                <p class="mb-0 text-center">Extensão inválida.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                '
            ;
            $url_destino = pg . "/pages/modulo/importar/importar";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }
    }
}else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>'; 
}

?>