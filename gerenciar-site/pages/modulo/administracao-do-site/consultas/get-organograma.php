<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$query = "SELECT 
    sg.id,
    sg.nome,
    sg.arquivo, 
    DATE_FORMAT(sg.created, '%d/%m/%Y') AS criado
    FROM site_organograma sg ORDER BY id DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome'],
        "arquivo"   => pg . $row['arquivo'],
        "criado"    => $row['criado']
    );
}

header('Content-Type: application/json');
echo json_encode($images);
