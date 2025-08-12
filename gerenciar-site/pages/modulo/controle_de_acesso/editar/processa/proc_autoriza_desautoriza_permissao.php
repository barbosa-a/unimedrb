<?php
    $seguranca = true;
    include_once("../../../../../config/seguranca.php");
    include_once("../../../../../config/conexao.php");
    $permissao  = filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
    //$nvl        = filter_input(INPUT_POST, 'nvl', FILTER_SANITIZE_STRING);
    //consultar as permissoes atuais
    $per = "SELECT permissao FROM niveis_acessos_paginas WHERE id_nvl_pg = '$permissao' ";
    $query_per= mysqli_query($conn, $per);
    if (($query_per) AND ($query_per->num_rows > 0)) {
        $row_per = mysqli_fetch_assoc($query_per);
        //verificar se a permissão: 1 = 2 e 2 =1
        if($row_per['permissao'] == 1){
            $nova_permissao = 2;
        }else{
            $nova_permissao = 1;
        }
        //atualiza permissão
        $up_aut_perm = "UPDATE niveis_acessos_paginas SET permissao = '$nova_permissao', modificado_nvl_pg = NOW() WHERE id_nvl_pg = '$permissao' ";
        $query_up_aut_perm = mysqli_query($conn, $up_aut_perm);
        if (mysqli_affected_rows($conn) != 0) {
            echo "1";
        }else{
            echo "0";
        }
    } 

        
?>
