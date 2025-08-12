<?php
if(!isset($seguranca)){
    exit;
}

function limparurl($conteudo){
    $formato_a = '"!@$%()#*{[}]+;:,\\\'<>º°ª';
    $formato_b = '______________________________';
    $conteudo_ct = strtr($conteudo, $formato_a, $formato_b);
    $conteudo_br = str_ireplace(" ", " ", $conteudo_ct);
    $conteudo_st = strip_tags($conteudo_br);
    $conteudo_lp = trim($conteudo_st);
    
    return $conteudo_lp;
}

function limparSenha($conteudo){
    $formato_a = '"()#&*{[}]/?-+=;:,\\\'<>º°ª';
    $formato_b = '                  ';
    $conteudo_ct = strtr($conteudo, $formato_a, $formato_b);
    $conteudo_br = str_ireplace(" ", " ", $conteudo_ct);
    $conteudo_st = strip_tags($conteudo_br);
    $conteudo_lp = trim($conteudo_st);
    
    return $conteudo_lp;
}


