<?php

if(!isset($seguranca)){
    exit;
}
function carregar_botao($endereco, $conn){
    $botao_cad_user = "SELECT * FROM niveis_acessos_paginas nivacpg
                        INNER JOIN paginas pg on pg.id_pg = nivacpg.pagina_id 
                        WHERE pg.endereco_pg = '$endereco'
                        AND nivacpg.permissao = 1 AND nivacpg.niveis_acesso_id = ".$_SESSION['usuarioNIVEL']." 
                        ";
    $query_botao_cad_user = mysqli_query($conn, $botao_cad_user);
    if(($query_botao_cad_user) AND ($query_botao_cad_user->num_rows != 0)){
        return true;
    } else {
        return false;
    }
                        
}
