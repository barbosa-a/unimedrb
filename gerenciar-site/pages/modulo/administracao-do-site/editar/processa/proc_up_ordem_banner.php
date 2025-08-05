<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$data = json_decode(file_get_contents('php://input'), true);
$orderedIDs = $data['orderedIDs'];

$msg = [];

foreach ($orderedIDs as $position => $id) {
    $query = "UPDATE site_banners SET ordem = $position, modified = NOW() WHERE id = $id";
    $result = $conn->query($query);
    if ($result) {
        $msg = ['success' => true];
    }else{
        $msg = ['success' => false];
    }
    
}

echo json_encode($msg);