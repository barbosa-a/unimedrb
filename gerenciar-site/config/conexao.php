<?php
if(!isset($seguranca)){
    exit;
}

$servidor = "localhost";
$usuario  = "unimedrb-landing-page";
$senha    = "PmpCPnkFGiss6EbZ";
$banco    = "unimedrb-landing-page";

//criar conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);
if(!$conn){
    die("Falha ao conectar servidor: ". mysqli_connect_error());
}else{
    //echo "Conexão realizada com sucesso.";
}


?>
