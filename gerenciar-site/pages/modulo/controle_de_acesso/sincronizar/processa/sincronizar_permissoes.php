<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");

$nvl = filter_input(INPUT_POST, 'nvl', FILTER_DEFAULT);
$ordem = 1;
$mod = array();
$msg = array('msg' => 'Sincronização de páginas concluido');

//Consultar modulos liberados para o nivel de acesso
$consmod = "SELECT p.modulo_id FROM niveis_acessos_paginas nap INNER JOIN paginas p on p.id_pg = nap.pagina_id WHERE nap.niveis_acesso_id = '$nvl' AND p.menu_lateral = 1 ";
$query_consmod = mysqli_query($conn, $consmod);
if (($query_consmod) and ($query_consmod->num_rows > 0)) {
    while ($a = mysqli_fetch_array($query_consmod)) {
        array_push($mod, $a['modulo_id']);
    }

    //var_dump($mod);

    //Converter Array em String
    $mods = implode(', ', $mod);

    //Listar paginas fora dos modulos cadastrados
    $conspg = "SELECT nap.id_nvl_pg, p.endereco_pg FROM paginas p INNER JOIN niveis_acessos_paginas nap on p.id_pg = nap.pagina_id WHERE p.modulo_id NOT IN($mods) AND nap.niveis_acesso_id = '$nvl' AND p.menu_lateral = 2";
    $query_conspg = mysqli_query($conn, $conspg);
    while ($b = mysqli_fetch_array($query_conspg)) {
        //echo "Páginas para excluir: " . $b['id_nvl_pg'] . "<br>";

        $del = "DELETE FROM niveis_acessos_paginas WHERE id_nvl_pg = '{$b['id_nvl_pg']}' ";
        $query_del = mysqli_query($conn, $del);
        if (mysqli_affected_rows($conn) > 0) {
            $msg = array('msg' => 'Páginas não autorizadas foram sincronizadas com sucesso');
        }else {
            $msg = array('msg' => 'Páginas não sincronizadas');
        }
        
    }
}else{
    $msg = array('msg' => 'Nenhum modulo encontrado para o perfil');
}
    
echo json_encode($msg);