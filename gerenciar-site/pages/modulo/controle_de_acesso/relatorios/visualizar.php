<?php
    //iniciar sessão
    session_start();    
    date_default_timezone_set('America/Rio_Branco');
    //Conexão com o banco de dados
    include_once '../../../config/conexao.php';
    $relatorio  = filter_input(INPUT_GET, 'relatorio', FILTER_SANITIZE_NUMBER_INT);
    $usuario    = filter_input(INPUT_GET, 'usuario', FILTER_SANITIZE_NUMBER_INT);
    $unidade    = filter_input(INPUT_GET, 'unidades', FILTER_SANITIZE_NUMBER_INT);
    $status     = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($unidade)){
        //consultar unidade
        $cons_uni = "SELECT * FROM unidade WHERE id_uni = '$unidade' ";
        $query_cons_uni = mysqli_query($conn, $cons_uni);
        $rowUni = mysqli_fetch_assoc($query_cons_uni);
    }    
    if($relatorio == 1){ 
        $usuarioCTA = " 
            SELECT 
                u.nome_user,
                u.email_user,
                u.login_user,
                n.nome_nvl,
                c.nome_cargo,
                un.nome_uni,
                s.nome_situacao,
                u.criado_user,
                u.ult_acesso
            FROM 
                usuarios u
            LEFT JOIN 
                niveis_acessos n
            ON
                n.id_nvl = u.niveis_acesso_id
            LEFT JOIN
                cargo c
            ON
                c.id_cargo = u.cargo_id
            LEFT JOIN
                unidade un
            ON
                un.id_uni = u.unidade_id
            LEFT JOIN
                situacoes_usuarios s
            ON
                s.id_situacao = u.situacoes_usuario_id
            WHERE 
                u.unidade_id LIKE '%$unidade%' 
            AND 
                u.situacoes_usuario_id LIKE '%$status%'
            ORDER BY u.nome_user ASC ";
        $query_usuarioCTA = mysqli_query($conn, $usuarioCTA);
        $total = mysqli_num_rows($query_usuarioCTA);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório de usuários_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="8">Relatório Usuários</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="8">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="9" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Login</th>
                            <th scope="col">Perfil</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Data</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Último acesso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_array($query_usuarioCTA)) { ?>
                            <tr>
                                <td><?php echo $user['nome_user']; ?></td>
                                <td><?php echo $user['email_user']; ?></td>
                                <td><?php echo $user['login_user']; ?></td>
                                <td><?php echo $user['nome_nvl']; ?></td>
                                <td><?php echo $user['nome_cargo']; ?></td>
                                <td><?php echo $user['nome_uni']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($user['criado_user'])); ?></td>
                                <td><?php echo $user['nome_situacao']; ?></td>
                                <td>
                                    <?php 
                                        if(empty($user['ult_acesso'])){
                                            echo 'N/D';
                                        } else {
                                            echo date('d/m/Y H:i:s', strtotime($user['ult_acesso'])); 
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="3" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 2) { 
        //Consultar nivel de acesso
        if ($_SESSION['usuarioNIVEL'] == 1) {
            $nvl = "SELECT * FROM niveis_acessos ";
            $query_nvl = mysqli_query($conn, $nvl);
            $total = mysqli_num_rows($query_nvl);
        } else {
            $nvl = "SELECT * FROM niveis_acessos WHERE ordem_nvl > '" . $_SESSION['usuarioORDEM'] . "' ";
            $query_nvl = mysqli_query($conn, $nvl);
            $total = mysqli_num_rows($query_nvl);
        }
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Perfil de Acesso_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="3">Relatório Perfil de Acesso</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="3">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="4" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Ordem</th>
                            <th scope="col">Data</th>
                            <th scope="col">Última modificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_nvl = mysqli_fetch_array($query_nvl)) { ?>
                            <tr>
                            <td><?php echo $row_nvl['nome_nvl']; ?></td>
                            <td><?php echo $row_nvl['ordem_nvl']; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($row_nvl['criado_nvl'])); ?></td>
                            <td>
                                <?php
                                    if(!empty($row_nvl['modificado_nvl'])){
                                        echo date('d/m/Y H:i:s', strtotime($row_nvl['modificado_nvl']));
                                    } else {
                                        echo 'N/D';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>    
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="2" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 3) { 
        $usuarioCTA = " 
            SELECT 
                u.nome_user,
                u.email_user,
                u.login_user,
                n.nome_nvl,
                c.nome_cargo,
                un.nome_uni,
                s.nome_situacao,
                u.criado_user,
                u.ult_acesso,
                u.niveis_acesso_id AS perfil
            FROM 
                usuarios u
            LEFT JOIN 
                niveis_acessos n
            ON
                n.id_nvl = u.niveis_acesso_id
            LEFT JOIN
                cargo c
            ON
                c.id_cargo = u.cargo_id
            LEFT JOIN
                unidade un
            ON
                un.id_uni = u.unidade_id
            LEFT JOIN
                situacoes_usuarios s
            ON
                s.id_situacao = u.situacoes_usuario_id
            WHERE 
                u.id_user LIKE '%$usuario%'
            ORDER BY u.nome_user ASC ";
        $query_usuarioCTA = mysqli_query($conn, $usuarioCTA);
        $total = mysqli_num_rows($query_usuarioCTA);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Perfil de Acesso do Usuário_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="7">Relatório Perfil de Acesso do Usuário</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="7">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="8" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Login</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Data</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Último acesso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_array($query_usuarioCTA)) { ?>
                            <tr>
                                <td><?php echo $user['nome_user']; ?></td>
                                <td><?php echo $user['email_user']; ?></td>
                                <td><?php echo $user['login_user']; ?></td>                                
                                <td><?php echo $user['nome_cargo']; ?></td>
                                <td><?php echo $user['nome_uni']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($user['criado_user'])); ?></td>
                                <td><?php echo $user['nome_situacao']; ?></td>
                                <td>
                                    <?php 
                                        if(empty($user['ult_acesso'])){
                                            echo 'N/D';
                                        } else {
                                            echo date('d/m/Y H:i:s', strtotime($user['ult_acesso'])); 
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <table class="table table-striped table-sm table-borderless" id="table">
                                        <thead>
                                            <tr>
                                                <td colspan="8" class="text-center"><b>Perfil: </b><?php echo $user['nome_nvl']; ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Operação</th>
                                                <th scope="col">Permissão</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $consNVL = "SELECT * FROM niveis_acessos_paginas nvl INNER JOIN paginas pg ON pg.id_pg = nvl.pagina_id WHERE nvl.niveis_acesso_id = '".$user['perfil']."' ";
                                                $query_consNVL = mysqli_query($conn, $consNVL);
                                                $linhas = 1;
                                                while ($operacoes = mysqli_fetch_array($query_consNVL)) { ?>
                                                    <tr>
                                                        <td><?php echo $linhas++; ?></td>
                                                        <td><?php echo $operacoes['endereco_pg']; ?></td>
                                                        <td>
                                                            <?php
                                                                if($operacoes['permissao'] == 1){
                                                                    echo 'Ativo';
                                                                } else {
                                                                    echo 'Inativo';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="3" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 4) { 
        //Consultar cargo
        $cargo = "SELECT * FROM cargo c INNER JOIN departamento d ON d.id_depar = c.departamento ORDER BY c.nome_cargo ASC ";
        $query_cargo = mysqli_query($conn, $cargo);
        $total = mysqli_num_rows($query_cargo);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Cargos_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="3">Relatório Cargos</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="3">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="4" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Data</th>
                            <th scope="col">Última modificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_cargo = mysqli_fetch_array($query_cargo)) { ?>
                            <tr>
                                <td><?php echo $row_cargo['nome_cargo']; ?></td>
                                <td><?php echo $row_cargo['nome_depar']; ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($row_cargo['criado_cargo'])) ?></td>
                                <td>
                                    <?php 
                                        if(!empty($row_cargo['modificado_cargo'])){
                                            echo date('d/m/Y H:i:s', strtotime($row_cargo['modificado_cargo'])); 
                                        } else {
                                            echo 'N/D';
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>       
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="2" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 5) { 
        //Departamentos
        $consDepar = "SELECT * FROM departamento ORDER BY nome_depar ASC";
        $query_consDepar = mysqli_query($conn, $consDepar);
        $total = mysqli_num_rows($query_consDepar);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Departamentos_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="2">Relatório Departamentos</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="2">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="3" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Última modificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($dados = mysqli_fetch_array($query_consDepar)) { ?>
                            <tr>
                                <td><?php echo $dados['nome_depar']; ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($dados['criado_depar'])) ?></td>
                                <td>
                                    <?php 
                                        if(!empty($dados['modificado_depar'])){
                                            echo date('d/m/Y H:i:s', strtotime($dados['modificado_depar'])); 
                                        } else {
                                            echo 'N/D';
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="1" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 6) { 
        //Consultar unidade
        $cons_unidade = "SELECT * FROM unidade u LEFT JOIN grupo g ON g.id_gru = u.grupo_id ORDER BY nome_uni ASC";
        $query_unidade = mysqli_query($conn, $cons_unidade);
        $total = mysqli_num_rows($query_unidade);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Unidades_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="4">Relatório Unidades</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="4">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="5" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Sigla</th>
                            <th scope="col">Grupo</th>
                            <th scope="col">Data</th>
                            <th scope="col">Última modificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_unidade = mysqli_fetch_array($query_unidade)) { ?>
                            <tr>
                                <td><?php echo $row_unidade['nome_uni']; ?></td>
                                <td><?php echo $row_unidade['sigla_uni']; ?></td>
                                <td><?php echo $row_unidade['nome_gru']; ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($row_unidade['criado_uni'])); ?></td>
                                <td>
                                    <?php
                                        if(!empty($row_unidade['modificado_uni'])){
                                            echo date('d/m/Y H:i:s', strtotime($row_unidade['modificado_uni'])); 
                                        } else {
                                            echo 'N/D';
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>  
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="2" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php }elseif ($relatorio == 7) { 
        //consultar grupos
        $grupo = "SELECT * FROM grupo ORDER BY nome_gru ASC";
        $query_grupo = mysqli_query($conn, $grupo);
        $total = mysqli_num_rows($query_grupo);
        ?>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Relatório Grupos_<?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></title>
                <link href="css/bootstrap.min.css" rel="stylesheet">    
                <link rel="stylesheet" type="text/css" href="css/print.css" />
                <script src="js/print.js"></script>
            </head>
            <body>
                <table class="table table-striped table-sm table-borderless" id="table">
                    <thead>
                        <tr>
                            <td scope="col" colspan="1" class="text-center" rowspan="2">
                                <img src="img/Companycloud_original.png" width="170" height="50">
                            </td>
                            <td scope="col" colspan="3">Relatório Grupos</td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="3">Controle de Acesso</td>
                        </tr>
                        <?php if(!empty($unidade)){ ?>
                            <tr>
                                <td scope="col" colspan="4" class="text-center">Unidade: <?php echo $rowUni['sigla_uni'] ." - ". $rowUni['nome_uni'] ?></td>
                            </tr>
                        <?php } ?>                        
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Macro</th>
                            <th scope="col">Data</th>
                            <th scope="col">Última modificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <<?php while ($row_grupo = mysqli_fetch_array($query_grupo)){ ?>
                            <tr>
                                <td><?php echo $row_grupo['nome_gru']; ?></td>
                                <td>
                                    <?php
                                        $grupoMacro = "SELECT * FROM grupo WHERE id_gru =".$row_grupo['grupo_pai_id'];
                                        $query_grupoMacro = mysqli_query($conn, $grupoMacro);
                                        $macro = mysqli_fetch_assoc($query_grupoMacro);
                                        echo $macro['nome_gru']; 
                                    ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($row_grupo['criado_gru'])); ?></td>
                                <td>
                                    <?php
                                        if(!empty($row_grupo['modificado_gru'])){
                                            echo date('d/m/Y H:i:s', strtotime($row_grupo['modificado_gru'])); 
                                        } else {
                                            echo 'N/D';
                                        }                                        
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Usuário solicitante: <?php echo $_SESSION['usuarioLOGIN'] ." - ". date('d/m/Y H:i') ?></td>
                            <td colspan="2" class="text-right">Total de registros: <?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>                
            </body>
        </html>
    <?php } ?>


