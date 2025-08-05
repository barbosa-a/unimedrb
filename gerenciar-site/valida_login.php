<?php
//inicializar sessão
session_start();

$usuario_login = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
$senha_login   = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

//Verificar se o usuário digitou nos campos
if ($usuario_login and $senha_login) {

    // URL da API e credenciais de autenticação (exemplo)
    //$api_url = 'https://esfinge.pm.ac.gov.br/auth';
    $api_url = 'https://esfinge.acre.seg.br/auth';

    $token_jwt = "MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAwQgwqappGDdEo840rH4B
            FNe2l7FbuTv9xo7VsW1hPeY+PKxW17Od4JiCmMfo3ViGP9N20eqxsF9VCQUmvCdS
            5f3K9W4i3CMEpQHvo3aaKhJxFPEIVfbqshTXNlnEL6pcEKnlicYwsbS1qc0QILsn
            l+2yfg6aO2w3De0LowJ9xig2o2fTgx254YQJjlFK2AxhAItBWnRxDqlcVWON+xTo
            F8OxBYEVrOeDvwGsg1kA54EQ6DR5LiqEZcxkp0V3ubulb/p12dKhOVQVjA4S5Nx0
            vxh6Ng/QHkZ2WmOJAh2keVib70ATrvDUgnOL6wNuYo1xxU/Kf9WmGHtrUvOYhD93
            w1+mJNElRnEHBYuPwsAC6VE0iHDFva0DbP91QUKrMEiAnGZuq/nz1sc7djpmFL3V
            rKAOx3wCqPzpkTUuxVJWDl8Zzo5JZcQLmcde0K8Abw0nvF1Cqi7k1q5LISS3Kjfo
            1P7MuYljQBI+JiU/r/xru3ri9W8w1jXc/hr9gaodaDWjcXe1d0YmUUG2xuu6MKmN
            T4s2T4eMhBl+/uCQNplY0c02gDCogpHnWwkI7Jx+UvsssphjPXMkd1wTJ725lr+b
            sWedQZ2pTQtJcbkij7bUYj1SVqGEWFGEL2xEgmbbEjcWu5rpJT6mSX0Y0FG3qZCR
            69386EVZnQDwD/Dp2lpmkzUCAwEAAQ==
    ";

    $seguranca = true;
    include_once("config/config.php");
    include_once("config/conexao.php");
    include_once("lib/lib_valida.php");

    $usuario = limparSenha($usuario_login);
    $senha   = limparSenha($senha_login);
    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);
    //verificar se os campos estão vindo vazio ou não
    if ((!empty($usuario)) and (!empty($senha))) {
        //echo password_hash($senha, PASSWORD_DEFAULT);
        $pesq_usuario = "SELECT 
                *,
                TIMESTAMPDIFF(HOUR, ult_token, NOW()) AS tmp_token
            FROM usuarios us
            INNER JOIN unidade un ON un.id_uni = us.unidade_id 
            INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
            INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id 
            LEFT JOIN contrato_sistema c ON c.idcontratosistema = us.contrato_sistema_id
            WHERE us.login_user = '$usuario' LIMIT 1 
        ";

        $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
        if (($query_pesq_usuario) and ($query_pesq_usuario->num_rows > 0)) {
            $row_usuario = mysqli_fetch_array($query_pesq_usuario);
            //verificar a situação do contrato
            if ($row_usuario['fim_contrato'] < date('Y-m-d') and $row_usuario['situacao_contrato_id'] == 4) {

                $url_destino = pg . "/pages/modulo/pagamento/checkout.php?token={$row_usuario['token']}";

                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Pagamento pendente',
                    'msg' => 'Considere realizar o pagamento',
                    'url' => $url_destino
                );

                echo json_encode($msg);
            } elseif ($row_usuario['fim_contrato'] < date('Y-m-d')) {

                $msg = array(
                    'tipo' => 'info',
                    'titulo' => 'Contrato vencido',
                    'msg' => 'Entre em contato com o administrador'
                );

                echo json_encode($msg);
            } elseif ($row_usuario['id_nvl'] == 1 or $row_usuario['id_user'] == 1 or $row_usuario['situacao_contrato_id'] == 1) {
                //verificar a situação da conta do usuário
                if ($row_usuario['situacoes_usuario_id'] == 1) {
                    //usuário ativo e senha precisa ser alterada
                    $url_destino = pg . "/pages/modulo/update-password/update-password.php?token={$row_usuario['token']}";
                    
                    if ($row_usuario['tmp_token'] > 1) {

                        $msg = array(
                            'tipo' => 'info',
                            'titulo' => 'Token expirado'
                        );

                    } else {
                        
                        $msg = array(
                            'tipo' => 'info',
                            'titulo' => 'Redirecionar usuário',
                            'msg' => 'senha do usuário precisa ser alterada',
                            'url' => $url_destino
                        );

                    }                   

                    echo json_encode($msg);
                } elseif ($row_usuario['situacoes_usuario_id'] == 2) {

                    $msg = array(
                        'tipo' => 'info',
                        'titulo' => 'Atenção',
                        'msg' => 'Usuário inativo!'
                    );

                    echo json_encode($msg);
                } elseif ($row_usuario['situacoes_usuario_id'] == 3) {
                    //usuario com senha RESETADA
                    $url_destino = pg . "/pages/modulo/update-password/update-password.php?token={$row_usuario['token']}";

                    if ($row_usuario['tmp_token'] > 1) {
                        $msg = array(
                            'tipo' => 'info',
                            'titulo' => 'Token de acesso inválido',
                            'msg' => 'Caso tenha feito o resete da senha, solicite uma nova senha.'
                        );
                    } else {
                        $msg = array(
                            'tipo' => 'info',
                            'titulo' => 'Redirecionar usuário',
                            'msg' => 'Redirecionar usuario para resetar senha',
                            'url' => $url_destino
                        );
                    }

                    echo json_encode($msg);
                } elseif ($row_usuario['situacoes_usuario_id'] == 4) {

                    $msg = array(
                        'tipo' => 'info',
                        'titulo' => 'Atenção',
                        'msg' => 'Sua senha expirou e precisa ser alterada!'
                    );

                    echo json_encode($msg);
                } elseif ($row_usuario['situacoes_usuario_id'] == 5 and $row_usuario['usuarios_autenticacao_id'] == 2) {
                    //consultar validade da senha atual
                    $senha_atual_user = "SELECT 
                                30 - TIMESTAMPDIFF(DAY, created_hist_senha, NOW()) AS dias
                            FROM 
                                hist_senha 
                            WHERE 
                                usuario_id = '{$row_usuario['id_user']}' 
                            AND
                                evento_senha_id = 1 
                            ORDER BY created_hist_senha DESC LIMIT 1 
                        ";
                    $query_senha_atual_user = mysqli_query($conn, $senha_atual_user);
                    $userSenha = mysqli_fetch_assoc($query_senha_atual_user);
                    if ($userSenha['dias'] < 1) {
                        //Redirecionar usuario para alterar senha
                        $url_destino = pg . "/pages/modulo/update-password/update.php";
                        //echo '<script> location.replace("' . $url_destino . '"); </script>';
                        $msg = array(
                            'tipo' => 'info',
                            'titulo' => 'Redirecionar usuário',
                            'msg' => 'Redirecionar usuario para alterar senha',
                            'url' => $url_destino
                        );

                        echo json_encode($msg);
                    } else {
                        //usuario ATIVO e senha foi alterada no primeiro login do sistema
                        if (password_verify($senha, $row_usuario['senha_user'])) {
                            $ordem = "SELECT ordem_nvl FROM niveis_acessos WHERE id_nvl = '{$row_usuario['niveis_acesso_id']}' ";
                            $query_ordem = mysqli_query($conn, $ordem);
                            $ro_ordem = mysqli_fetch_assoc($query_ordem);

                            $_SESSION['usuarioID']    = $row_usuario['id_user'];
                            $_SESSION['usuarioFOTO']  = $row_usuario['foto'];
                            $_SESSION['usuarioNOME']  = $row_usuario['nome_user'];
                            $_SESSION['usuarioEMAIL'] = $row_usuario['email_user'];
                            $_SESSION['usuarioLOGIN'] = $row_usuario['login_user'];
                            $_SESSION['usuarioNIVEL'] = $row_usuario['niveis_acesso_id'];
                            $_SESSION['usuarioORDEM'] = $ro_ordem['ordem_nvl'];
                            $_SESSION['usuarioUNIDADEID']       = $row_usuario['unidade_id'];
                            $_SESSION['usuarioUNIDADE']         = $row_usuario['nome_uni'];
                            $_SESSION['usuarioUNIDADESIGLA']    = $row_usuario['sigla_uni'];
                            $_SESSION['usuarioCARGO']           = $row_usuario['nome_cargo'];
                            $_SESSION['usuarioPERFIL']          = $row_usuario['nome_nvl'];
                            $_SESSION['contratoID']             = $row_usuario['idcontratosistema'];
                            $_SESSION['contratoUSER']           = $row_usuario['contrato_sistema_id'];
                            $_SESSION['empresaNOME']           = $row_usuario['nome_fantasia'];

                            include_once("config/seguranca.php");

                            $url_destino = pg . "/";
                            //echo '<script> location.replace("' . $url_destino . '"); </script>';
                            $msg = array(
                                'tipo' => 'success',
                                'titulo' => 'Usuário logado',
                                'msg' => 'Redirecionar...',
                                'url' => $url_destino
                            );

                            echo json_encode($msg);
                        } else {

                            $msg = array(
                                'tipo' => 'error',
                                'titulo' => 'Senha inválida',
                                'msg' => 'A senha digitada não esta correta'
                            );

                            echo json_encode($msg);
                        }
                    }
                } elseif ($row_usuario['situacoes_usuario_id'] == 5 and $row_usuario['usuarios_autenticacao_id'] == 1) {
                    //Consultar usuário da API registrado na base local

                    // Acessar via API 
                    $username = $usuario;
                    $password = $senha;

                    // Realizar solicitação de login para obter o token JWT
                    $ch = curl_init($api_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['username' => $username, 'password' => $password]));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $data = json_decode($response, true);

                    // Incluir o token JWT no cabeçalho da solicitação
                    $headers = array(
                        'Authorization: Bearer ' . $token_jwt,
                    );

                    // Processar a resposta da API
                    if ($response) {

                        $data = json_decode($response, true);
                        if (isset($data)) {
                            //print_r($data);

                            if ((!empty($username)) and (!empty($password))) {

                                //var_dump($data);
                                if (isset($data['message'])) {

                                    $msg = array(
                                        'tipo' => 'error',
                                        'titulo' => 'Ops...',
                                        'msg' => 'Informações de login não encontrada!'
                                    );

                                    echo json_encode($msg);
                                } else {
                                    //Autenticar usuário da API cadastrado na base local
                                    $ordem = "SELECT ordem_nvl FROM niveis_acessos WHERE id_nvl = '{$row_usuario['niveis_acesso_id']}' ";
                                    $query_ordem = mysqli_query($conn, $ordem);
                                    $ro_ordem = mysqli_fetch_assoc($query_ordem);

                                    $_SESSION['usuarioID']    = $row_usuario['id_user'];
                                    $_SESSION['usuarioFOTO']  = $row_usuario['foto'];
                                    $_SESSION['usuarioNOME']  = $row_usuario['nome_user'];
                                    $_SESSION['usuarioEMAIL'] = $row_usuario['email_user'];
                                    $_SESSION['usuarioLOGIN'] = $row_usuario['login_user'];
                                    $_SESSION['usuarioNIVEL'] = $row_usuario['niveis_acesso_id'];
                                    $_SESSION['usuarioORDEM'] = $ro_ordem['ordem_nvl'];
                                    $_SESSION['usuarioUNIDADEID']       = $row_usuario['unidade_id'];
                                    $_SESSION['usuarioUNIDADE']         = $row_usuario['nome_uni'];
                                    $_SESSION['usuarioUNIDADESIGLA']    = $row_usuario['sigla_uni'];
                                    $_SESSION['usuarioCARGO']           = $row_usuario['nome_cargo'];
                                    $_SESSION['usuarioPERFIL']          = $row_usuario['nome_nvl'];
                                    $_SESSION['contratoID']             = $row_usuario['idcontratosistema'];
                                    $_SESSION['contratoUSER']           = $row_usuario['contrato_sistema_id'];
                                    $_SESSION['empresaNOME']           = $row_usuario['nome_fantasia'];

                                    include_once("config/seguranca.php");

                                    $url_destino = pg . "/";
                                    //echo '<script> location.replace("' . $url_destino . '"); </script>';
                                    $msg = array(
                                        'tipo' => 'success',
                                        'titulo' => 'Usuário logado',
                                        'msg' => 'Redirecionar...',
                                        'url' => $url_destino
                                    );

                                    echo json_encode($msg);
                                }
                            } else {

                                $msg = array(
                                    'tipo' => 'error',
                                    'titulo' => 'Ops...',
                                    'msg' => 'Digite seu usuário e senha corretamente!'
                                );

                                echo json_encode($msg);
                            }
                        } else {

                            $msg = array(
                                'tipo' => 'error',
                                'titulo' => 'Off-line',
                                'msg' => 'Autenticação ao servidor está indisponivel!'
                            );

                            echo json_encode($msg);
                        }
                    } else {

                        $msg = array(
                            'tipo' => 'error',
                            'titulo' => 'Erro de processamento',
                            'msg' => 'Falha ao consultar servidor!'
                        );

                        echo json_encode($msg);
                    }
                } else {
                    $msg = array(
                        'tipo' => 'error',
                        'titulo' => 'Ops...',
                        'msg' => 'Erro ao verificar situação do usuário, tente novamente!'
                    );

                    echo json_encode($msg);
                } //verificar a situação da conta do usuário
            } elseif ($row_usuario['situacao_contrato_id'] == 2) {
                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Ops...',
                    'msg' => 'Contrato inativo!'
                );

                echo json_encode($msg);
            } elseif ($row_usuario['situacao_contrato_id'] == 3) {
                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Ops...',
                    'msg' => 'Contrato cancelado!'
                );

                echo json_encode($msg);
            } elseif (empty($row_usuario['idcontratosistema'])) {
                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Ops...',
                    'msg' => 'Não há contrato vinculado ao seu usuário, contate o administrador!'
                );

                echo json_encode($msg);
            } else {
                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Ops...',
                    'msg' => 'Erro ao processar dados do usuário!'
                );

                echo json_encode($msg);
            } //verificar a situação do contrato           
        } else {

            //Verificar se a consulta API esta ativa
            if (authAPI) {
                // Acessar via API pela primeira vez e capturar os dados
                $username = $usuario;
                $password = $senha;

                // Realizar solicitação de login para obter o token JWT
                $ch = curl_init($api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['username' => $username, 'password' => $password]));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                // Incluir o token JWT no cabeçalho da solicitação
                $headers = array(
                    'Authorization: Bearer ' . $token_jwt,
                );

                // Processar a resposta da API
                if ($response) {

                    $data = json_decode($response, true);
                    if (isset($data)) {
                        //print_r($data);

                        if ((!empty($username)) and (!empty($password))) {

                            //var_dump($data);
                            if (isset($data['message'])) {

                                $msg = array(
                                    'tipo' => 'error',
                                    'titulo' => 'Ops...',
                                    'msg' => 'Informações de login não encontrada!'
                                );

                                echo json_encode($msg);
                            } else {

                                //print_r($data);

                                //Consultar cargo
                                $cargo = "SELECT id_cargo FROM cargo WHERE nome_cargo = '{$data['position']}' LIMIT 1 ";
                                $query_cargo = mysqli_query($conn, $cargo);
                                if (($query_cargo) and ($query_cargo->num_rows > 0)) {
                                    $dadosCargo = mysqli_fetch_assoc($query_cargo);

                                    //Selecionar perfil de acesso DEFAULT
                                    $ordem = "SELECT ordem_nvl FROM niveis_acessos WHERE id_nvl = 3 ";
                                    $query_ordem = mysqli_query($conn, $ordem);
                                    if (($query_ordem) and ($query_ordem->num_rows > 0)) {
                                        $ro_ordem = mysqli_fetch_assoc($query_ordem);

                                        // Salvar dados do usuário de retorno da API na base local
                                        $cad_user = "INSERT INTO usuarios 
                                        (nome_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, contrato_sistema_id, usuarios_autenticacao_id, criado_user, ult_token) 
                                        VALUES 
                                        ('{$data['name']}', '{$data['username']}', '$senha_crip', '{$data['token']}', 3, 5, '{$dadosCargo['id_cargo']}', 1, 1, 1, NOW(), NOW())";
                                        $query_cad_user = mysqli_query($conn, $cad_user);
                                        //verificar se foi salvo no banco de dados
                                        if (mysqli_insert_id($conn)) {
                                            $id = mysqli_insert_id($conn);

                                            //Consultar usuario inserido
                                            $pesq_usuario = "SELECT * FROM usuarios us
                                            INNER JOIN unidade un ON un.id_uni = us.unidade_id 
                                            INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
                                            INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id 
                                            LEFT JOIN contrato_sistema c ON c.idcontratosistema = us.contrato_sistema_id
                                            WHERE us.id_user = '$id' LIMIT 1 
                                        ";
                                            $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
                                            $row_usuario = mysqli_fetch_assoc($query_pesq_usuario);

                                            $_SESSION['usuarioID']    = $row_usuario['id_user'];
                                            $_SESSION['usuarioFOTO']  = $row_usuario['foto'];
                                            $_SESSION['usuarioNOME']  = $row_usuario['nome_user'];
                                            $_SESSION['usuarioEMAIL'] = $row_usuario['email_user'];
                                            $_SESSION['usuarioLOGIN'] = $row_usuario['login_user'];
                                            $_SESSION['usuarioNIVEL'] = $row_usuario['niveis_acesso_id'];
                                            $_SESSION['usuarioORDEM'] = $ro_ordem['ordem_nvl'];
                                            $_SESSION['usuarioUNIDADEID']       = $row_usuario['unidade_id'];
                                            $_SESSION['usuarioUNIDADE']         = $row_usuario['nome_uni'];
                                            $_SESSION['usuarioUNIDADESIGLA']    = $row_usuario['sigla_uni'];
                                            $_SESSION['usuarioCARGO']           = $row_usuario['nome_cargo'];
                                            $_SESSION['usuarioPERFIL']          = $row_usuario['nome_nvl'];
                                            $_SESSION['contratoID']             = $row_usuario['idcontratosistema'];
                                            $_SESSION['contratoUSER']           = $row_usuario['contrato_sistema_id'];
                                            $_SESSION['empresaNOME']            = $row_usuario['nome_fantasia'];

                                            include_once("config/seguranca.php");

                                            $url_destino = pg . "/";

                                            $msg = array(
                                                'tipo' => 'success',
                                                'titulo' => 'Usuário logado',
                                                'msg' => 'Redirecionar...',
                                                'url' => $url_destino
                                            );

                                            echo json_encode($msg);
                                        } else {
                                            $msg = array(
                                                'tipo' => 'error',
                                                'titulo' => 'Ops...',
                                                'msg' => 'Erro ao registrar usuário da API'
                                            );

                                            echo json_encode($msg);
                                        }
                                    } else {
                                        $msg = array(
                                            'tipo' => 'error',
                                            'titulo' => 'Ops...',
                                            'msg' => 'Perfil de acesso não localizado, contate o desenvolvedor!'
                                        );

                                        echo json_encode($msg);
                                    }
                                } else {

                                    //Cadastrar cargo e registrar usuário
                                    $cad_cargo = "INSERT INTO cargo 
                                    (nome_cargo, criado_cargo) 
                                    VALUES 
                                    ('{$data['position']}', NOW())";
                                    $query_cad_cargo = mysqli_query($conn, $cad_cargo);
                                    if (mysqli_insert_id($conn)) {
                                        $cargo = mysqli_insert_id($conn);

                                        //Selecionar perfil de acesso DEFAULT
                                        $ordem = "SELECT ordem_nvl FROM niveis_acessos WHERE id_nvl = 3 ";
                                        $query_ordem = mysqli_query($conn, $ordem);
                                        if (($query_ordem) and ($query_ordem->num_rows > 0)) {
                                            $ro_ordem = mysqli_fetch_assoc($query_ordem);

                                            // Salvar dados do usuário de retorno da API na base local
                                            $cad_user = "INSERT INTO usuarios 
                                        (nome_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, contrato_sistema_id, usuarios_autenticacao_id, criado_user, ult_token) 
                                        VALUES 
                                        ('{$data['name']}', '{$data['username']}', '$senha_crip', '{$data['token']}', 3, 5, '{$cargo}', 1, 1, 1, NOW(), NOW())";
                                            $query_cad_user = mysqli_query($conn, $cad_user);
                                            //verificar se foi salvo no banco de dados
                                            if (mysqli_insert_id($conn)) {
                                                $id = mysqli_insert_id($conn);

                                                //Consultar usuario inserido
                                                $pesq_usuario = "SELECT * FROM usuarios us
                                            INNER JOIN unidade un ON un.id_uni = us.unidade_id 
                                            INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
                                            INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id 
                                            LEFT JOIN contrato_sistema c ON c.idcontratosistema = us.contrato_sistema_id
                                            WHERE us.id_user = '$id' LIMIT 1 
                                            ";
                                                $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
                                                $row_usuario = mysqli_fetch_assoc($query_pesq_usuario);

                                                $_SESSION['usuarioID']    = $row_usuario['id_user'];
                                                $_SESSION['usuarioFOTO']  = $row_usuario['foto'];
                                                $_SESSION['usuarioNOME']  = $row_usuario['nome_user'];
                                                $_SESSION['usuarioEMAIL'] = $row_usuario['email_user'];
                                                $_SESSION['usuarioLOGIN'] = $row_usuario['login_user'];
                                                $_SESSION['usuarioNIVEL'] = $row_usuario['niveis_acesso_id'];
                                                $_SESSION['usuarioORDEM'] = $ro_ordem['ordem_nvl'];
                                                $_SESSION['usuarioUNIDADEID']       = $row_usuario['unidade_id'];
                                                $_SESSION['usuarioUNIDADE']         = $row_usuario['nome_uni'];
                                                $_SESSION['usuarioUNIDADESIGLA']    = $row_usuario['sigla_uni'];
                                                $_SESSION['usuarioCARGO']           = $row_usuario['nome_cargo'];
                                                $_SESSION['usuarioPERFIL']          = $row_usuario['nome_nvl'];
                                                $_SESSION['contratoID']             = $row_usuario['idcontratosistema'];
                                                $_SESSION['contratoUSER']           = $row_usuario['contrato_sistema_id'];
                                                $_SESSION['empresaNOME']            = $row_usuario['nome_fantasia'];

                                                include_once("config/seguranca.php");

                                                $url_destino = pg . "/";

                                                $msg = array(
                                                    'tipo' => 'success',
                                                    'titulo' => 'Usuário logado',
                                                    'msg' => 'Redirecionar...',
                                                    'url' => $url_destino
                                                );

                                                echo json_encode($msg);
                                            } else {
                                                $msg = array(
                                                    'tipo' => 'error',
                                                    'titulo' => 'Ops...',
                                                    'msg' => 'Erro ao registrar usuário da API'
                                                );

                                                echo json_encode($msg);
                                            }
                                        } else {
                                            $msg = array(
                                                'tipo' => 'error',
                                                'titulo' => 'Ops...',
                                                'msg' => 'Perfil de acesso não localizado, contate o desenvolvedor!'
                                            );

                                            echo json_encode($msg);
                                        }
                                    } else {
                                        $msg = array(
                                            'tipo' => 'error',
                                            'titulo' => 'Ops...',
                                            'msg' => 'Erro ao registrar graduação, contate o desenvolvedor!'
                                        );

                                        echo json_encode($msg);
                                    }
                                }
                            }
                        } else {

                            $msg = array(
                                'tipo' => 'error',
                                'titulo' => 'Ops...',
                                'msg' => 'Digite seu usuário e senha corretamente!'
                            );

                            echo json_encode($msg);
                        }
                    } else {

                        $msg = array(
                            'tipo' => 'error',
                            'titulo' => 'Off-line',
                            'msg' => 'Autenticação ao servidor está indisponivel!'
                        );

                        echo json_encode($msg);
                    }
                } else {

                    $msg = array(
                        'tipo' => 'error',
                        'titulo' => 'Erro de processamento',
                        'msg' => 'Falha ao consultar servidor!'
                    );

                    echo json_encode($msg);
                }
            } else {

                $msg = array(
                    'tipo' => 'error',
                    'titulo' => 'Ops...',
                    'msg' => 'Não é possivel validar usuário e senha'
                );

                echo json_encode($msg);
            }
        }
    } else {
        $msg = array(
            'tipo' => 'info',
            'titulo' => 'Atenção',
            'msg' => 'Preencha o campo usuário e senha!'
        );

        echo json_encode($msg);
    }
} else {
    $msg = array(
        'tipo' => 'error',
        'titulo' => 'Atenção',
        'msg' => 'Página não encontrada!'
    );

    echo json_encode($msg);
}
