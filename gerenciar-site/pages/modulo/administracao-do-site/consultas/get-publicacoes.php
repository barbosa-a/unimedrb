<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$buscar = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT 
    sp.id, 
    sp.titulo, 
    sp.subtitulo, 
    sp.texto,
    sp.descricao_meta,
    sp.palavras_chave,
    sp.capa_princial,
    sp.status,
    spc.categoria,
    u.nome_user,
    DATE_FORMAT(sp.created, '%d/%m/%Y às %H:%i:%s') AS criado 
    FROM site_publicacoes sp 
        INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id
        INNER JOIN usuarios u ON u.id_user = sp.usuario_id
    WHERE sp.titulo LIKE '%$buscar%' ORDER BY id DESC LIMIT 5
";
$result = $conn->query($query);

$dados = [];
while ($row = $result->fetch_assoc()) {
    
    $dados[] = array(
        "id"                => $row['id'],
        "titulo"            => $row['titulo'],
        "subtitulo"         => $row['subtitulo'],
        "texto"             => $row['texto'],
        "descricao_meta"    => $row['descricao_meta'],
        "capa"               => pg . $row['capa_princial'],
        "criado"            => $row['criado'],
        "categoria"         => $row['categoria'],
        "user"              => $row['nome_user'],
        "status"            => $row['status'],
        "url"               => pg
    );
}

header('Content-Type: application/json');
echo json_encode($dados);
