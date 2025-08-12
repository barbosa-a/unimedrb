<?php
    if(!isset($seguranca)){
        exit;
    }
    //Gerar novo token para usuarios com token vencidos a cada 8 hora
    $pesq_us = "SELECT id_user FROM usuarios WHERE ult_token <= DATE_SUB(NOW(),INTERVAL 8 HOUR)";            
    $query_pesq_us = mysqli_query($conn, $pesq_us);
    while ($row_us = mysqli_fetch_array($query_pesq_us)){
        //echo $row_us['login_user']."<br>";
        $token_auth = mb_strtoupper(strval(bin2hex(openssl_random_pseudo_bytes(32))));
        //update para alterar a senha do usuário
        $up_token_auth = "UPDATE usuarios SET token='$token_auth', ult_token = NOW() WHERE id_user = '{$row_us['id_user']}' ";
        $query_up_token_auth = mysqli_query($conn, $up_token_auth);
        if(mysqli_affected_rows($conn) != 0){
            //salvar historico de altenticação do tokens gerados
            $cad_token = "INSERT INTO auth_token (usuario_id, token, criado_token) VALUES ('{$row_us['id_user']}', '$token_auth', NOW())";
            $query_cad_token = mysqli_query($conn, $cad_token);

        }
    }
?>
