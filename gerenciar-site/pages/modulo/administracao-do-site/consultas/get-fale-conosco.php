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
    assunto,
    autor, 
    email,
    mensagem,
    DATE_FORMAT(created, '%d/%m/%Y às %H:%i:%s') AS criado
    FROM site_fale_conosco ORDER BY id DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"         => $row['id'],
        "assunto"    => $row['assunto'],
        "autor"      => $row['autor'],
        "email"      => $row['email'],
        "mensagem"   => $row['mensagem'],
        "criado"     => $row['criado']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
