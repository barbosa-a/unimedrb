<?php
function slug($text)
{
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

function sobre($conn)
{

    $query = "SELECT 
            id, 
            titulo, 
            sobre, 
            resumo,
            slug,
            created
            FROM site_sobre ORDER BY titulo ASC LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function sobreBannerSingle($conn)
{

    $query = "SELECT 
            id, 
            titulo, 
            transicao, 
            arquivo,
            obs,
            ordem
            FROM site_sobre_img ORDER BY ordem DESC LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function sobreBanners($conn)
{

    $query = "SELECT 
            id, 
            titulo, 
            transicao, 
            arquivo,
            obs,
            ordem
            FROM site_sobre_img ORDER BY ordem ASC
        ";
    $result = $conn->query($query);

    return $result;
}

function missaoVisaoValores($conn)
{

    $query = "SELECT 
            missao, 
            visao, 
            valores
            FROM site_missao_visao_valores LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function liderEquipe($conn)
{

    $query = "SELECT 
            nome, 
            descricao, 
            biografia,
            foto,
            DATE_FORMAT(data_inicio, '%d/%m/%Y') AS inicio,
            DATE_FORMAT(data_fim, '%d/%m/%Y') AS fim
            FROM site_ceo WHERE (data_fim IS NULL OR data_fim = '0000-00-00') LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function equipe($conn)
{

    $query = "SELECT 
            nome, 
            descricao, 
            biografia,
            foto,
            DATE_FORMAT(data_inicio, '%d/%m/%Y') AS inicio,
            DATE_FORMAT(data_fim, '%d/%m/%Y') AS fim
            FROM site_ceo WHERE data_fim != '0000-00-00' ORDER BY data_fim DESC
        ";
    $result = $conn->query($query);

    return $result;
}

function ads($conn, $local)
{

    $query = "SELECT 
            titulo, 
            slug, 
            arquivo,
            legenda,
            link
            FROM site_banners_ads WHERE anuncio = '{$local}' ORDER BY id DESC LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function banners($conn)
{

    $query = "SELECT 
            titulo, 
            transicao, 
            arquivo,
            link
            FROM site_banners WHERE CURDATE() >= dt_inicio AND CURDATE() <= dt_fim ORDER BY ordem ASC
        ";
    $result = $conn->query($query);

    return $result;
}

function bannerSingle($conn)
{

    $query = "SELECT 
            titulo, 
            transicao, 
            arquivo,
            link,
            obs,
            card_titulo,
            card_link,
            card_desc
            FROM site_banners ORDER BY ordem DESC LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function logos($conn, $local)
{

    $query = "SELECT 
            logo, 
            slug, 
            arquivo
            FROM site_logos WHERE local = '{$local}' LIMIT 1
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function linksUteis($conn)
{

    $query = "SELECT 
            nome_site, 
            link_site
            FROM site_links_uteis ORDER BY nome_site ASC
        ";
    $result = $conn->query($query);

    return $result;
}

function redesSociais($conn)
{

    $query = "SELECT 
            facebook, 
            status_facebook,
            instagram, 
            status_instagram,
            youtube,
            status_youtube,
            linkedin,
            status_linkedin
            FROM site_redes_socias
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function endereco($conn)
{

    $query = "SELECT 
            endereco, 
            horario, 
            telefone_principal,
            telefone_secundario
            FROM site_endereco
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function contatos($conn)
{

    $query = "SELECT 
            enderecoEmail, 
            numeroWpp, 
            telefoneFixo,
            telefoneCelular
            FROM site_contato
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function faq($conn)
{

    $query = "SELECT 
            id,
            pergunta, 
            resposta
            FROM site_faq
    ";
    $result = $conn->query($query);

    return $result;
}

function adicionarClasseImg($html, $classe)
{
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

function destaque($conn)
{

    $query = "SELECT 
                titulo,
                arquivo,
                descricao
            FROM site_pub_destaque
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function pubDestaque($conn)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id
            WHERE sp.destacar = 'Sim' AND sp.slug != '' AND sp.status = 'Publicar'
                ORDER BY sp.id DESC LIMIT 4
        ";
    $result = $conn->query($query);

    return $result;
}

function pubSemDestaque($conn, $limite)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created,
            sp.visualizacoes
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id
            WHERE sp.pagina != 'Projetos sociais' AND sp.slug != '' AND sp.status = 'Publicar'
                ORDER BY sp.id DESC
            LIMIT $limite
        ";
    $result = $conn->query($query);

    return $result;
}

function pubMaisVisualizadas($conn)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created,
            sp.visualizacoes,
            COUNT(sp.id) AS pubs
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id 
                    WHERE sp.slug != '' AND sp.status = 'Publicar' AND sp.visualizacoes != 0
                        GROUP BY sp.id
                                ORDER BY sp.visualizacoes DESC   
                                    LIMIT 10                             
            
        ";
    $result = $conn->query($query);

    return $result;
}

function video($conn)
{

    $query = "SELECT 
                url
            FROM site_videos
        ";
    $result = $conn->query($query);

    if (($result) and ($result->num_rows > 0)) {

        $row = $result->fetch_assoc();

        return $row;
    }
}

function projetosSociais($conn)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.capa_pub,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created,
            sp.visualizacoes
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id
                    WHERE sp.pagina = 'Projetos sociais' AND sp.slug != '' AND sp.status = 'Publicar'
                        ORDER BY sp.id DESC
            
        ";
    $result = $conn->query($query);

    return $result;
}

function galeria($conn)
{

    $query = "SELECT 
        sg.album,
        sgf.nome, 
        sgf.arquivo,
        sgf.slug,
        sgf.legenda,
        sgf.site_galeria_id
    FROM site_galeria_fotos sgf
    INNER JOIN (
        SELECT site_galeria_id, MAX(id) AS max_id
        FROM site_galeria_fotos
        GROUP BY site_galeria_id
    ) latest ON sgf.site_galeria_id = latest.site_galeria_id AND sgf.id = latest.max_id
    INNER JOIN site_galeria sg ON sg.id = sgf.site_galeria_id
    ORDER BY sgf.id DESC
    LIMIT 12
    ";
    $result = $conn->query($query);

    return $result;
}

function categoriasPostadas($conn, $pagina)
{

    $query = "SELECT 
            spc.categoria,
            COUNT(sp.id) AS total
            FROM site_publicacoes_categoria spc
                INNER JOIN site_publicacoes sp ON spc.id = sp.site_publicacoes_categoria_id 
                    WHERE sp.slug != '' AND sp.status = 'Publicar' AND sp.pagina = '{$pagina}'
                        GROUP BY spc.categoria
                            ORDER BY spc.categoria ASC
            
        ";
    $result = $conn->query($query);

    return $result;
}

function maisVisualizadas($conn, $pagina)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created,
            sp.visualizacoes
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id 
                    WHERE sp.slug != '' AND sp.status = 'Publicar' AND sp.pagina = '{$pagina}' AND sp.visualizacoes != 0
                        ORDER BY sp.visualizacoes DESC
            
        ";
    $result = $conn->query($query);

    return $result;
}

function pubRecentes($conn)
{

    $query = "SELECT 
            sp.titulo, 
            sp.capa_princial,
            sp.slug,
            spc.categoria,
            u.nome_user,
            sp.pagina,
            DATE_FORMAT(sp.created, '%d/%m/%Y') AS criado,
            DATE_FORMAT(sp.created, '%d') AS dia,
            DATE_FORMAT(sp.created, '%M') AS mes,
            sp.created,
            sp.visualizacoes
            FROM site_publicacoes sp 
                INNER JOIN site_publicacoes_categoria spc ON spc.id = sp.site_publicacoes_categoria_id 
                INNER JOIN usuarios u ON u.id_user = sp.usuario_id 
                    WHERE sp.slug != '' AND sp.status = 'Publicar'
                        ORDER BY sp.id DESC
                            LIMIT 6
            
        ";
    $result = $conn->query($query);

    return $result;
}

function todasCategoriasPostadas($conn)
{

    $query = "SELECT 
            spc.categoria,
            COUNT(sp.id) AS total
            FROM site_publicacoes_categoria spc
                INNER JOIN site_publicacoes sp ON spc.id = sp.site_publicacoes_categoria_id 
                    WHERE sp.slug != '' AND sp.status = 'Publicar'
                        GROUP BY spc.categoria
                            ORDER BY spc.categoria ASC
            
        ";
    $result = $conn->query($query);

    return $result;
}

function registrarAcesso($conn, $materia, $ip)
{

    try {

        $cad = "INSERT INTO site_publicacoes_visualizacoes (site_publicacoes_id, ip_address, created) VALUES ('{$materia}', '{$ip}', NOW())";
        $query = mysqli_query($conn, $cad);

        $up = "UPDATE site_publicacoes SET visualizacoes = visualizacoes + 1 WHERE id = '{$materia}' ";
        $query_up = mysqli_query($conn, $up);

        $msg = array(
            'tipo' => 'success',
            'titulo' => 'Sucesso',
            'msg' => 'Você visualizou'
        );

        return json_encode($msg);
    } catch (Exception $e) {

        $msg = array(
            'tipo' => 'error',
            'titulo' => 'error',
            'msg' => $e->getMessage()
        );

        return json_encode($msg);
    }
}

function organograma($conn)
{

    $query = "SELECT 
            arquivo
        FROM site_organograma
    ";
    $result = $conn->query($query);

    return $result;
}

function capitalizeFirstLetters($string)
{
    $string = ucwords(strtolower($string));
    return $string;
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

function resumirTexto(string $texto = null, int $limite, string $continue = '...'): string
{
    $textoLimpo = trim(strip_tags($texto));

    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    $resumirTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limite), ''));
    return $resumirTexto . $continue;
}

function getClientIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
