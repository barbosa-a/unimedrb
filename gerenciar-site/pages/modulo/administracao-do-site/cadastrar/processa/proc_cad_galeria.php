<?php
session_start();

//segurança do ADM
$seguranca = true;

//Biblioteca auxiliares
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");
include_once("../../../../../lib/lib_timezone.php");

$dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verifica se o formulário foi submetido
if (isset($_POST['album'])) {
    // Caminho onde as imagens serão salvas
    $diretorio = "../../../../../dist/storage/galeria/";

    // Cria o diretório caso não exista
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    $msg = [];

    try {

        $cad = "INSERT INTO site_galeria 
            (album, descricao, usuario_id, created) 
                VALUES
            ('{$dado['album']}', '{$dado['descricao']}', '{$_SESSION['usuarioID']}', NOW())
        ";
        $query = mysqli_query($conn, $cad);

        $id = mysqli_insert_id($conn);

        // Pasta
        $pasta = "/dist/storage/galeria/";

        // Itera sobre cada arquivo enviado
        foreach ($_FILES['arquivo']['tmp_name'] as $key => $tmp_name) {

            $nomeArquivo = basename($_FILES['arquivo']['name'][$key]);
            $nomeArquivoSemExtensao = pathinfo($nomeArquivo, PATHINFO_FILENAME);
            //Faz a verificação da extensao do arquivo
            $extensao = pathinfo($_FILES['arquivo']['name'][$key], PATHINFO_EXTENSION);
            $size = $_FILES['arquivo']['size'][$key];
            $type = $_FILES['arquivo']['type'][$key];
            $slug = slugImage($_FILES['arquivo']['name'][$key]) . '.' . $extensao;
            $caminhoCompleto = $diretorio . $slug;
            $dir = $pasta . $slug;

            // Move o arquivo para o diretório de uploads
            if (move_uploaded_file($tmp_name, $caminhoCompleto)) {
                // Insere os dados da imagem no banco de dados
                $cadFotos = "INSERT INTO site_galeria_fotos 
                    (site_galeria_id, type_img, size_img, nome, slug, arquivo, legenda, created) 
                        VALUES
                    ('$id', '$type', '$size', '{$nomeArquivoSemExtensao}', '{$slug}', '$dir', '{$dado['legenda']}', NOW())
                ";
                $queryFotos = mysqli_query($conn, $cadFotos);

                $msg = array(
                    'tipo' => 'success', 
                    'titulo' => 'Sucesso', 
                    'msg' => 'Fotos registradas com sucesso'
                );

            } else {
                
                $msg = array(
                    'tipo' => 'error', 
                    'titulo' => 'Erro', 
                    'msg' => 'Erro ao mover arquivo para pasta'
                );

            }
        }

        
        echo json_encode($msg);

    } catch (Exception $e) {

        $msg = array(
            'tipo' => 'error', 
            'titulo' => 'Erro', 
            'msg' => $e->getMessage()
        );
        echo json_encode($msg);
    }
}else{
    $msg = array(
        'tipo' => 'error', 
        'titulo' => 'Erro', 
        'msg' => 'Nenhum arquivo encontrado'
    );
    echo json_encode($msg);
}
