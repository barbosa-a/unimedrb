<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$msg = [];

$query = "DELETE FROM site_organograma WHERE id = $id ";
$result = mysqli_query($conn, $query);
if ($result) {
    $msg = ['success' => true];
} else {
    $msg = ['success' => false];
}

echo json_encode($msg);
