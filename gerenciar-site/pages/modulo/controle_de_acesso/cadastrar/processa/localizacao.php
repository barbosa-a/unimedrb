<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
//include_once("../../../../../lib/lib_funcoes.php");
//include_once("../../../../../lib/lib_botoes.php");

$latitude    = filter_input(INPUT_POST, 'latitude', FILTER_DEFAULT);
$longitude   = filter_input(INPUT_POST, 'longitude', FILTER_DEFAULT);

$cons = "SELECT id FROM usuarios_localizacao WHERE usuario_id = '{$_SESSION['usuarioID']}' AND latitude = $latitude AND longitude = $longitude LIMIT 1";
$query_cons = mysqli_query($conn, $cons);
if (($query_cons) and ($query_cons->num_rows == 0)) {
    try {
        $cad = "INSERT INTO usuarios_localizacao 
            (usuario_id, latitude, longitude, created) 
            VALUES 
            ('{$_SESSION['usuarioID']}', '{$latitude}', '{$longitude}', NOW())
        ";
        $query_cad= mysqli_query($conn, $cad);
    
        $arr = array('tipo' => 'success', 'msg' => 'Sua sessão foi iniciada');
        echo json_encode($arr);
        
    } catch (Exception $e) {
        $arr = array('tipo' => 'error', 'msg' => 'Erro de geolocalização: ' . $e->getMessage());
        echo json_encode($arr);
    }
} else {
    $arr = array('tipo' => 'info', 'msg' => 404);
    echo json_encode($arr);
}