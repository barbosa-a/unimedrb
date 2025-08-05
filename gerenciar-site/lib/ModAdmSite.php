<?php 

function slug($text) {
    // Converter caracteres especiais em letras normais
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

    // Converter espaços em hífens
    $text = str_replace(' ', '-', $text);
    
    // Remover caracteres indesejados
    $text = preg_replace('/[^a-zA-Z0-9-]/', '', $text);
    
    // Converter para minúsculas
    $text = strtolower($text);
    
    return $text;
}

function slugImage($fileName) {
    // Remove a extensão do arquivo
    $fileName = pathinfo($fileName, PATHINFO_FILENAME);
    
    // Substitui espaços e caracteres especiais por hífens
    $slug = preg_replace('/[^a-zA-Z0-9\-]/', '-', $fileName);
    
    // Converte o slug para minúsculas
    $slug = strtolower($slug);
    
    // Remove hífens duplicados
    $slug = preg_replace('/-+/', '-', $slug);
    
    return $slug;
}

function contarTempo(string $data)
{
    $agora = strtotime(date('Y-m-d H:i:s'));
    $tempo = strtotime($data);
    $diferenca = $agora - $tempo;
    $segundos = $diferenca;
    $minutos = round($diferenca / 60);
    $hora = round($diferenca / 3600);
    $dias = round($diferenca / 86400);
    $semanas = round($diferenca / 604800);
    $meses = round($diferenca / 2419200);
    $anos = round($diferenca / 29030400);

    if ($segundos <= 60) {
        return 'agora';
    }elseif ($minutos <= 60) {
        return $minutos == 1 ? 'há 1 minuto' : 'há '. $minutos .' minutos'; 
    }elseif ($hora <= 24) {
        return $hora == 1 ? 'há 1 hora' : 'há '. $hora .' horas'; 
    }elseif ($dias <= 7) {
        return $dias == 1 ? 'ontem' : 'há '. $dias .' dias'; 
    }elseif ($semanas <= 7) {
        return $semanas == 1 ? 'há 1 semana' : 'há '. $semanas .' semanas'; 
    }elseif ($meses <= 12) {
        return $meses == 1 ? 'há 1 mês' : 'há '. $meses .' meses'; 
    }else {
        return $anos == 1 ? 'há 1 ano' : 'há '. $anos .' anos'; 
    }
}

function resumirTexto(string $texto = null, int $limite, string $continue = '...'): string
{
    $textoLimpo = trim(strip_tags($texto));

    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    $resumirTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limite), ''));
    return $resumirTexto.$continue;
}

function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

?>