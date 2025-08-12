<?php  
	session_start();
	//segurança do ADM
    $seguranca = true;   
    include_once("../../../../config/config.php"); 
	include_once("../../../../config/conexao.php");
	include_once("../../../../lib/lib_funcoes.php");
	include_once("../../../../lib/lib_botoes.php");

	$permission = filter_input(INPUT_POST, 'permission', FILTER_DEFAULT);
    $nvl = filter_input(INPUT_POST, 'nvl', FILTER_DEFAULT);

    //consultar permissoes do perfil
	$per_menu_pg = "SELECT 
        ob.objeto,
        m.nome_mod,
        pg.nome_pg,
        nv.permissao,
        nv.id_nvl_pg
    FROM 
        paginas pg 
    INNER JOIN 
        niveis_acessos_paginas nv ON nv.pagina_id = pg.id_pg
    LEFT JOIN 
        objeto_paginas ob ON ob.idobj = pg.objeto_id
    INNER JOIN
        modulos m ON m.id_mod = pg.modulo_id
    WHERE 
        nv.niveis_acesso_id = '$nvl' AND (m.nome_mod LIKE '%$permission%' OR pg.nome_pg LIKE '%$permission%') order by m.nome_mod ASC";
    $query_per_menu_pg = mysqli_query($conn, $per_menu_pg);
    if (($query_per_menu_pg) AND ($query_per_menu_pg->num_rows > 0)) {
        while ($row_perm_menu_pg = mysqli_fetch_array($query_per_menu_pg)) { ?>
            <tr>
                <td scope="row"><?php echo $row_perm_menu_pg['objeto']; ?> </td>
                <td><?php echo $row_perm_menu_pg['nome_mod']; ?> </td>
                <td><?php echo $row_perm_menu_pg['nome_pg']; ?> </td>
                <td>
                    <?php if ($row_perm_menu_pg['permissao'] == 1) { ?>
                        <input type="button" class="btn btn-danger btn-sm" onclick="AlterarPermissao(<?php echo $row_perm_menu_pg['id_nvl_pg']; ?>);" value="Desabilitar" />
                    <?php } else { ?>
                        <input type="button" class="btn btn-success btn-sm" onclick="AlterarPermissao(<?php echo $row_perm_menu_pg['id_nvl_pg']; ?>);" value="Habilitar" />
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="4">Nenhuma permissão encontrada</td>
        </tr>
    <?php } ?>