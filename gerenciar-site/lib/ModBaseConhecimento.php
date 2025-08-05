<?php
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
    } elseif ($minutos <= 60) {
        return $minutos == 1 ? 'há 1 minuto' : 'há ' . $minutos . ' minutos';
    } elseif ($hora <= 24) {
        return $hora == 1 ? 'há 1 hora' : 'há ' . $hora . ' horas';
    } elseif ($dias <= 7) {
        return $dias == 1 ? 'ontem' : 'há ' . $dias . ' dias';
    } elseif ($semanas <= 7) {
        return $semanas == 1 ? 'há 1 semana' : 'há ' . $semanas . ' semanas';
    } elseif ($meses <= 12) {
        return $meses == 1 ? 'há 1 mês' : 'há ' . $meses . ' meses';
    } else {
        return $anos == 1 ? 'há 1 ano' : 'há ' . $anos . ' anos';
    }
}

function listarArtigo($id, $conn)
{
    // Listar qtd
    $cons_qtd_user = "SELECT * FROM base_conhecimento WHERE id = '$id' LIMIT 1 ";
    $query_cons_qtd_user = mysqli_query($conn, $cons_qtd_user);
    $row = mysqli_fetch_assoc($query_cons_qtd_user);
    return $row;
}

function resumirTexto(string $texto = null, int $limite, string $continue = '...'): string
{
    $textoLimpo = trim(strip_tags($texto));

    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    $resumirTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limite), ''));
    return $resumirTexto . $continue;
}

function adicionarClasseImg($html, $classe) {
    // Expressão regular para buscar tags <img>
    $padrao = '/<img(.*?)>/i';

    // Função de callback para adicionar a classe dinâmica
    $callback = function ($match) use ($classe) {
        $imgTag = $match[0];
        $novaTag = str_replace('<img', '<img class="' . $classe . '"', $imgTag);
        return $novaTag;
    };

    // Substituir as tags <img> pelo resultado do callback
    $novoHtml = preg_replace_callback($padrao, $callback, $html);

    return $novoHtml;
}
?>