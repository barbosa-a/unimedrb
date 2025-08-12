<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

try {

    $slug = slugGeral($dado['titulo']);

    $edit = "UPDATE site_publicacoes SET 
        titulo                          = '{$dado['titulo']}', 
        subtitulo                       = '{$dado['subtitulo']}', 
        texto                           = '{$dado['noticia']}', 
        descricao_meta                  = '{$dado['resumo']}', 
        palavras_chave                  = '{$dado['palavras_chave']}',
        slug                            = '{$slug}',
        status                          = '{$dado['status']}', 
        pagina                          = '{$dado['pagina']}',
        destacar                        = '{$dado['destacar']}',
        unidade_id                      = '{$dado['unidade']}', 
        site_publicacoes_categoria_id   = '{$dado['categoriaPub']}', 
        usuario_modified_id             = '{$_SESSION['usuarioID']}',
        modifield = NOW() 
        WHERE id = '{$dado['id']}' 
    ";
    $query = $conn->query($edit);

    $msg = array(
        'tipo' => 'success',
        'titulo' => 'Sucesso',
        'msg' => 'Registro alterado com sucesso'
    );
    echo json_encode($msg);

} catch (Exception $e) {

    $msg = array(
        'tipo' => 'error',
        'titulo' => 'Error',
        'msg' => 'Tente novamente, erro: ' . $e->getMessage()
    );
    echo json_encode($msg);

}
