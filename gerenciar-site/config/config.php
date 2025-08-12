<?php

header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

date_default_timezone_set('America/Rio_Branco');
$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
$site = "unimedrb";

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $protocol = 'https';

    define('pg', "$protocol://$url_host/gerenciar-site");
    define('site', "$protocol://$url_host/");
} else {
    $protocol = 'http';

    define('pg', "$protocol://$url_host/$site/gerenciar-site");
    define('site', "$protocol://$url_host/$site/");
}

define('nomeSistema', 'Área Restrita');
define('textoRodape', 'Texto 1');
define('subTextoRodape', 'Text 2 &copy; 2024');
define('btnCadastro', false);
define('btnTrocarSenha', true);
define('btnTextoRodape', false);
define('btnSubTextoRodape', false);

// API
define('authAPI', false);
