<?php 

    $seguranca = true;
    include_once("../../../config/config.php");
    include_once("../../../lib/lib_funcoes.php");
    
    // Receber os dados da imagem
    $dados_imagem = $_FILES['image'];
    $description = isset($_POST['alt']) ? $_POST['alt'] : '';

    // Diretorio onde será salvo a imagem
    $diretorio = "../../../dist/storage/publicacoes/";

    // Gerar uma chave para o nome do arquivo
    $chave = uniqid();

    // Gerar slug
    $slug = slugImage($dados_imagem['name']) . "-" . $chave;

    // Pegar extensão
    $extensao = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $nome_imagem = $slug . "." . $extensao;

    move_uploaded_file($dados_imagem['tmp_name'], $diretorio . $nome_imagem);
    $retorno['success'] = true;
    $retorno['file'] = pg . "/dist/storage/publicacoes/" . $nome_imagem;
    $retorno['description'] = $description;

    echo json_encode($retorno);

?>