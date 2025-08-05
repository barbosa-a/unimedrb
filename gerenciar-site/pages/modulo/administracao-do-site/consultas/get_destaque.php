<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$query = "SELECT 
    id, 
    titulo, 
    arquivo, 
    descricao,
    dtInicio,
    dtFim,
    created
    FROM site_pub_destaque WHERE id = $id LIMIT 1
";
$result = $conn->query($query);

$images = [];
if (($result) and ($result->num_rows > 0)) {

    $row = $result->fetch_assoc();

    $images = array(
        "status"    => true,
        "id"        => $row['id'],
        "titulo"    => $row['titulo'],
        "descricao" => $row['descricao'],
        "dtInicio"  => $row['dtInicio'],
        "dtFim"     => $row['dtFim'],
        "arquivo"   => $row['arquivo'],
        "data"      => $row['created']
    );

} else {

    $images = array(
        "status"    => false
    );

}


header('Content-Type: application/json');
echo json_encode($images);
