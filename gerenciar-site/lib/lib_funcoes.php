<?php
if (!isset($seguranca)) {
	exit;
}

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;



$linha = 1;
$linhaAnx = 1;

function carregar_botao($endereco, $conn)
{
	$botao_cad_user = "SELECT * FROM niveis_acessos_paginas nivacpg
	                        INNER JOIN paginas pg on pg.id_pg = nivacpg.pagina_id 
	                        WHERE pg.endereco_pg = '$endereco'
	                        AND nivacpg.permissao = 1 AND nivacpg.niveis_acesso_id = " . $_SESSION['usuarioNIVEL'] . " 
	    ";
	$query_botao_cad_user = mysqli_query($conn, $botao_cad_user);
	if (($query_botao_cad_user) and ($query_botao_cad_user->num_rows != 0)) {
		return true;
	} else {
		return false;
	}
}

function VerificarTempSenha($conn)
{
	//consultar historico de senhas alteradas
	$senha_atual_user = "
			SELECT 
				usuario_id,
                DATEDIFF(NOW(), created_hist_senha)	AS dias
			FROM 
				hist_senha 
			WHERE
				usuario_id = '{$_SESSION['usuarioID']}'
			AND 
				evento_senha_id = '1' 		
			ORDER BY DATE(created_hist_senha) DESC LIMIT 1";
	$query_senha_atual_user = mysqli_query($conn, $senha_atual_user);
	if (($query_senha_atual_user) and ($query_senha_atual_user->num_rows != 0)) {
		$usuario = mysqli_fetch_array($query_senha_atual_user);
		if ($usuario['dias'] > 30) {
			$up = "UPDATE usuarios SET situacoes_usuario_id = '4' WHERE id_user =" . $usuario['usuario_id'];
			$query_up = mysqli_query($conn, $up);
			if (mysqli_affected_rows($conn) > 0) {
				//salvar o historico de alteração de senha
				$cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('" . $usuario['usuario_id'] . "', '2', '4', NOW())";
				$query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
			}
		}
	}
}

function VerificarStatusContrato($conn)
{
	// consultar contratos
	$cons_contratos = "SELECT * FROM contrato_sistema WHERE DATEDIFF(fim_contrato, CURDATE()) = 0 AND fim_contrato IS NOT NULL ";
	$query_cons_contratos = mysqli_query($conn, $cons_contratos);
	if (($query_cons_contratos) and ($query_cons_contratos->num_rows > 0)) {
		$status_contrato = mysqli_fetch_assoc($query_cons_contratos);
		//atualizar status do contrato para: 2 = Inativo
		$up_contrato = "UPDATE contrato_sistema SET situacao_contrato_id = '2', modifield_contrato = NOW() ";
		$query_up_contrato = mysqli_query($conn, $up_contrato);
	}
}

function NomePagina($niveis_acesso_id, $url, $conn)
{
	$cons_pagina_atual = "
    		SELECT
                pg.nome_pg
			FROM 
				paginas pg 
			INNER JOIN 
				niveis_acessos_paginas nivpg on nivpg.pagina_id = pg.id_pg
			WHERE 
				pg.endereco_pg = '$url' 
			AND nivpg.pagina_id = pg.id_pg 
			AND nivpg.niveis_acesso_id = '$niveis_acesso_id' 
			AND nivpg.permissao = 1 
        ";
	$query_cons_pagina_atual = mysqli_query($conn, $cons_pagina_atual);
	$row_pg_atual = mysqli_fetch_assoc($query_cons_pagina_atual);

	if (($query_cons_pagina_atual) and ($query_cons_pagina_atual->num_rows != 0)) {
		return $row_pg_atual['nome_pg'];
	} else {
		return "Página inicial";
	}
}

function CarregarMenuLateral($usuarionvl, $conn)
{
	//Carregar menu dinamicamente conforme o nivel de acesso do usuário
	$menu = "SELECT nivpg.*,
							pg.id_pg,
                            pg.endereco_pg,
                            pg.nome_pg,
                            pg.icon,
							pg.objeto_id
                     FROM niveis_acessos_paginas nivpg
                     INNER JOIN paginas pg on pg.id_pg = nivpg.pagina_id
                     WHERE nivpg.niveis_acesso_id = '$usuarionvl' AND nivpg.permissao = 1 AND nivpg.menu = 1 AND (pg.pagina_id IS NULL OR pg.pagina_id = 0) ORDER BY pg.ordem_menu ASC";
	$query_menu = mysqli_query($conn, $menu);
	while ($row_menu = mysqli_fetch_assoc($query_menu)) { ?>

		<?php if ($row_menu['objeto_id'] == 1) { ?>

			<li class="nav-item">
				<a class="nav-link" href="<?php echo pg; ?>/<?php echo $row_menu['endereco_pg']; ?>">
					<i class="<?php echo $row_menu['icon']; ?>" aria-hidden="true"></i>
					<p><?php echo $row_menu['nome_pg']; ?></p>
				</a>
			</li>

		<?php } else { ?>

			<li class="nav-item">

				<a href="<?php echo pg; ?>/<?php echo $row_menu['endereco_pg']; ?>" class="nav-link">
					<i class="<?php echo $row_menu['icon']; ?>"></i>
					<p>
						<?php echo $row_menu['nome_pg']; ?>
						<i class="right fa fa-angle-left"></i>
					</p>
				</a>

				<ul class="nav nav-treeview">
					<?php foreach (carregarSubmenu($conn, $row_menu['id_pg']) as $sub) { ?>
					
						<li class="nav-item">
							<a href="<?php echo pg; ?>/<?php echo $sub['endereco_pg']; ?>" class="nav-link">
								
								<p><?php echo $sub['nome_pg']; ?></p>
							</a>
						</li>

					<?php } ?>

				</ul>
			</li>
		<?php } ?>
		
	<?php }
}

function paginasSubmenu($conn) {
	//Carregar menu dinamicamente conforme o nivel de acesso do usuário
	$menu = "SELECT 
			pg.id_pg,
			pg.nome_pg,
			pg.icon
		FROM niveis_acessos_paginas nivpg
		INNER JOIN paginas pg on pg.id_pg = nivpg.pagina_id
		WHERE nivpg.permissao = 1 AND nivpg.menu = 1 AND pg.objeto_id = 3 GROUP BY pg.id_pg ORDER BY pg.ordem_menu ASC
	";
	$query_menu = mysqli_query($conn, $menu);
	return $query_menu;
}

function carregarSubmenu($conn, $menu) {
	//Carregar menu dinamicamente conforme o nivel de acesso do usuário
	$menu = "SELECT 
			pg.id_pg,
			pg.nome_pg,
			pg.endereco_pg,
			pg.icon
		FROM niveis_acessos_paginas nivpg
		INNER JOIN paginas pg on pg.id_pg = nivpg.pagina_id
		WHERE nivpg.niveis_acesso_id = '{$_SESSION['usuarioNIVEL']}' AND nivpg.permissao = 1 AND nivpg.menu = 1 AND pg.objeto_id = 1 AND pg.pagina_id = '$menu' ORDER BY pg.ordem_menu ASC
	";
	$query_menu = mysqli_query($conn, $menu);
	return $query_menu;
}

function delTree($dir)
{
	if (is_dir($dir)) {
		$files = array_diff(scandir($dir), array('.', '..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	} else {
		return false;
	}
}

function statusUsuario($conn)
{
	//Consultar status
	$status = "SELECT * FROM situacoes_usuarios WHERE (id_situacao = 1 OR id_situacao = 2)";
	$query_status = mysqli_query($conn, $status);
	while ($row_status = mysqli_fetch_array($query_status)) {
		echo '<option value=' . $row_status['id_situacao'] . ' >' . $row_status['nome_situacao'] . '</option>';
	}
	return $row_status;
}

function unidadeUsuario($conn)
{
	//Consultar unidade
	$unidade = "SELECT * FROM unidade ORDER BY nome_uni ASC";
	$query_unidade = mysqli_query($conn, $unidade);
	return $query_unidade;
}

function cargoUsuario($conn)
{
	//Consultar cargo
	$cargo = "SELECT * FROM cargo ORDER BY nome_cargo ASC";
	$query_cargo = mysqli_query($conn, $cargo);
	return $query_cargo;
}

function perfilUsuario($perfil, $ordem, $conn)
{
	//Consultar nivel de acesso
	if ($perfil == 1) {
		$nvl = "SELECT * FROM niveis_acessos ";
		$query_nvl = mysqli_query($conn, $nvl);
	} else {
		$nvl = "SELECT * FROM niveis_acessos WHERE ordem_nvl > '$ordem' ";
		$query_nvl = mysqli_query($conn, $nvl);
	}
	while ($row_nvl = mysqli_fetch_array($query_nvl)) { ?>
		<option value="<?php echo $row_nvl['id_nvl']; ?>"><?php echo $row_nvl['nome_nvl']; ?></option>
	<?php }
	return $row_nvl;
}

function listarCargos($botao_edit_cargo, $botao_apagar_cargo, $conn)
{
	if (($_SESSION['usuarioNIVEL'] == 1) or ($_SESSION['contratoUSER'] == null) or ($_SESSION['contratoUSER'] == 0) or ($_SESSION['contratoUSER'] == 1)) {
		//consultar cargos
		$cargo = "SELECT * FROM cargo c LEFT JOIN departamento d ON d.id_depar = c.departamento ORDER BY id_cargo ASC ";
		$query_cargo = mysqli_query($conn, $cargo);
	}else{
		//consultar cargos
		$cargo = "SELECT * FROM cargo c LEFT JOIN departamento d ON d.id_depar = c.departamento WHERE c.contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY id_cargo ASC ";
		$query_cargo = mysqli_query($conn, $cargo);	
	}
	//$total_cargos = mysqli_num_rows($query_cargo);
	while ($row_cargo = mysqli_fetch_array($query_cargo)) { ?>
		<tr>
			<td><?php echo $row_cargo['nome_cargo']; ?></td>
			<td><?php echo $row_cargo['nome_depar']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($row_cargo['criado_cargo'])); ?></td>
			<td class="text-center">
				<?php if ($botao_edit_cargo) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_cargo?cargo=<?php echo $row_cargo['id_cargo']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_apagar_cargo) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_cargo?cargo=<?php echo $row_cargo['id_cargo']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
	return $row_cargo;
}

function listarDepartamentos($botao_edit_departamento, $botao_apagar_departamento, $conn)
{
	if (($_SESSION['usuarioNIVEL'] == 1) or ($_SESSION['contratoUSER'] == null) or ($_SESSION['contratoUSER'] == 0) or ($_SESSION['contratoUSER'] == 1)) {
		//consultar departamento
		$cons_departamento = "SELECT * FROM departamento ORDER BY id_depar ASC ";
		$query_depar = mysqli_query($conn, $cons_departamento);
	}else {
			//consultar departamento
			$cons_departamento = "SELECT * FROM departamento WHERE contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY id_depar ASC ";
			$query_depar = mysqli_query($conn, $cons_departamento);
	}
	//$total_depart = mysqli_num_rows($query_depar);
	while ($row_depar = mysqli_fetch_array($query_depar)) { ?>
		<tr>
			<td><?php echo $row_depar['nome_depar']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($row_depar['criado_depar'])); ?></td>
			<td class="text-center">
				<?php if ($botao_edit_departamento) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_departamento?departamento=<?php echo $row_depar['id_depar']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_apagar_departamento) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_departamento?departamento=<?php echo $row_depar['id_depar']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
	return $row_depar;
}

function listarGrupos($botao_edit_grupo, $botao_apagar_grupo, $conn)
{
	if (($_SESSION['usuarioNIVEL'] == 1) or ($_SESSION['contratoUSER'] == null) or ($_SESSION['contratoUSER'] == 0) or ($_SESSION['contratoUSER'] == 1)) {
		//consultar grupos
		$grupos = "SELECT * FROM grupo ORDER BY id_gru ASC ";
		$query_grupos = mysqli_query($conn, $grupos);
		$total_grupos = mysqli_num_rows($query_grupos);
	}else {
		//consultar grupos
		$grupos = "SELECT * FROM grupo WHERE contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY id_gru ASC ";
		$query_grupos = mysqli_query($conn, $grupos);
		$total_grupos = mysqli_num_rows($query_grupos);
	}
	while ($row_grupo = mysqli_fetch_array($query_grupos)) { ?>
		<tr>
			<td><?php echo $row_grupo['nome_gru']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($row_grupo['criado_gru'])); ?></td>
			<td class="text-center">
				<?php if ($botao_edit_grupo) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_grupo?grupo=<?php echo $row_grupo['id_gru']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_apagar_grupo) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_grupo?grupo=<?php echo $row_grupo['id_gru']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
	return $row_grupo;
}

function listarPerfilAcesso($botao_perm_perfil, $botao_edit_perfil, $botao_apagar_perfil, $userNVL, $userID, $conn)
{
	//consultar nivel de acesso
	if ($userNVL == 1) {
		$nvl = "SELECT * FROM niveis_acessos ";
		$query_nvl = mysqli_query($conn, $nvl);
		$total_nvl = mysqli_num_rows($query_nvl);

		$usuarioCTA = "SELECT * FROM usuarios ";
		$query_usuarioCTA = mysqli_query($conn, $usuarioCTA);
		$total_usuarios = mysqli_num_rows($query_usuarioCTA);
	} else {
		$nvl = "SELECT * FROM niveis_acessos WHERE ordem_nvl > (SELECT ordem_nvl FROM niveis_acessos WHERE id_nvl = '$userNVL') AND contrato_sistema_id = '{$_SESSION['contratoUSER']}'  ";
		$query_nvl = mysqli_query($conn, $nvl);
		$total_nvl = mysqli_num_rows($query_nvl);
		//usuários
		$usuarioCTA = "SELECT * FROM usuarios WHERE niveis_acesso_id > (SELECT niveis_acesso_id FROM usuarios WHERE id_user = '$userID') ";
		$query_usuarioCTA = mysqli_query($conn, $usuarioCTA);
		$total_usuarios = mysqli_num_rows($query_usuarioCTA);
	}
	while ($row_nvl = mysqli_fetch_array($query_nvl)) { ?>
		<tr>
			<td><?php echo $row_nvl['nome_nvl']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($row_nvl['criado_nvl'])); ?></td>
			<td class="text-center">
				<?php if ($botao_perm_perfil) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/listar/list_permissao?nvl=<?php echo $row_nvl['id_nvl']; ?>" data-toggle="tooltip" data-placement="top" title="Permissões">
						<i class="fa fa-fw fa-cogs"></i>
					</a>
				<?php } ?>
				<?php if ($botao_edit_perfil) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_perfil?perfil=<?php echo $row_nvl['id_nvl']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_apagar_perfil) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_perfil?perfil=<?php echo $row_nvl['id_nvl']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
}

function listarUnidades($botao_edit_unidade, $botao_apagar_unidade, $conn)
{
	if (($_SESSION['usuarioNIVEL'] == 1) or ($_SESSION['contratoUSER'] == null) or ($_SESSION['contratoUSER'] == 0) or ($_SESSION['contratoUSER'] == 1)) {
		$unidade = "SELECT * FROM unidade u LEFT JOIN grupo g on g.id_gru = u.grupo_id ORDER BY id_uni ASC ";
		$query_unidade = mysqli_query($conn, $unidade);
	}else {
		$unidade = "SELECT * FROM unidade u LEFT JOIN grupo g on g.id_gru = u.grupo_id WHERE u.contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY id_uni ASC ";
		$query_unidade = mysqli_query($conn, $unidade);
	}
	while ($row_unidade = mysqli_fetch_array($query_unidade)) { ?>
		<tr>
			<td><?php echo $row_unidade['sigla_uni']; ?></td>
			<td><?php echo $row_unidade['nome_uni']; ?></td>
			<td><?php echo $row_unidade['nome_gru']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($row_unidade['criado_uni'])); ?></td>
			<td class="text-center">
				<?php if ($botao_edit_unidade) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_unidade?unidade=<?php echo $row_unidade['id_uni']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_apagar_unidade) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_unidade?unidade=<?php echo $row_unidade['id_uni']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
}

function ListarPerfilUsuario($usuario_ordem, $perfil_atual, $conn)
{
	//Consultar nivel de acesso
	if ($_SESSION['usuarioNIVEL'] == 1) {
		$nvl = "SELECT * FROM niveis_acessos ";
		$query_nvl = mysqli_query($conn, $nvl);
	} else {
		$nvl = "SELECT * FROM niveis_acessos WHERE ordem_nvl >= '$usuario_ordem' ";
		$query_nvl = mysqli_query($conn, $nvl);
	}
	while ($row_nvl = mysqli_fetch_array($query_nvl)) { ?>
		<option value="<?php echo $row_nvl['id_nvl']; ?>" <?php
															//Nesse if eu trago a seleção pre defenina no bd
															if ($perfil_atual == $row_nvl['id_nvl']) {
																echo 'selected';
															}
															?>>
			<?php echo $row_nvl['nome_nvl']; ?>
		</option>
	<?php }
}

function ListarUnidadesUsuario($unidade_atual, $conn)
{
	//Consultar unidade
	$consUnidade = "SELECT * FROM unidade ORDER BY nome_uni ASC";
	$query_consUnidade = mysqli_query($conn, $consUnidade);
	while ($row_ConsUnidade = mysqli_fetch_array($query_consUnidade)) { ?>
		<option value="<?php echo $row_ConsUnidade['id_uni']; ?>" <?php
																	//Nesse if eu trago a seleção pre defenina no bd
																	if ($unidade_atual == $row_ConsUnidade['id_uni']) {
																		echo 'selected';
																	}
																	?>>
			<?php echo $row_ConsUnidade['nome_uni']; ?>
		</option>
	<?php }
}

function ListarCargosUsuario($cargo_atual, $conn)
{
	//Consultar cargo
	$consCargo = "SELECT * FROM cargo ORDER BY nome_cargo ASC";
	$query_consCargo = mysqli_query($conn, $consCargo);
	while ($cargoUsuario = mysqli_fetch_array($query_consCargo)) { ?>
		<option value="<?php echo $cargoUsuario['id_cargo']; ?>" <?php
																	//Nesse if eu trago a seleção pre defenina no bd
																	if ($cargo_atual == $cargoUsuario['id_cargo']) {
																		echo 'selected';
																	}
																	?>>
			<?php echo $cargoUsuario['nome_cargo']; ?>
		</option>
	<?php }
}

function ListarStatusUsuario($status_atual, $conn)
{
	if (($status_atual == 1) or ($status_atual == 3) or ($status_atual == 4)) {
		//Consultar status
		$status = "SELECT * FROM situacoes_usuarios WHERE id_situacao = '$status_atual' ";
		$query_status = mysqli_query($conn, $status);
	} else {
		//Consultar status
		$status = "SELECT * FROM situacoes_usuarios WHERE id_situacao = 2 OR id_situacao = 5";
		$query_status = mysqli_query($conn, $status);
	}


	while ($row_status = mysqli_fetch_array($query_status)) {
	?>
		<option value="<?php echo $row_status['id_situacao']; ?>" <?php
																	//Nesse if eu trago a seleção pre defenina no bd
																	if ($status_atual == $row_status['id_situacao']) {
																		echo 'selected';
																	}
																	?>>
			<?php echo $row_status['nome_situacao']; ?>
		</option>
	<?php }
}

function ListarHistoricoSenhaUsuario($usuario, $conn)
{
	//consultar historico 
	$cons_hist = "SELECT * FROM hist_senha h
	        INNER JOIN evento_senha e ON e.id_eventoSenha = h.evento_senha_id
	        INNER JOIN usuarios u ON u.id_user = h.operador WHERE h.usuario_id = '$usuario' ORDER BY h.id_histSenha DESC ";
	$query_cons_hist = mysqli_query($conn, $cons_hist);
	while ($row_cons_hist = mysqli_fetch_array($query_cons_hist)) { ?>
		<tr>
			<th scope="row"><?php echo $row_cons_hist['id_histSenha']; ?></th>
			<td><?php echo date('d/m/Y H:i:s', strtotime($row_cons_hist['created_hist_senha'])); ?></td>
			<td><?php echo $row_cons_hist['login_user']; ?></td>
			<td><?php echo $row_cons_hist['nome_evento']; ?></td>
		</tr>
	<?php }
}

function ListarDepartamentosCargos($conn)
{
	//consultar departamento
	$cons_departamento = "SELECT * FROM departamento ORDER BY id_depar ASC ";
	$query_depar = mysqli_query($conn, $cons_departamento);
	while ($row_depar = mysqli_fetch_array($query_depar)) { ?>
		<option value="<?php echo $row_depar['id_depar']; ?>"><?php echo $row_depar['nome_depar']; ?></option>
	<?php }
}

function ListarGruposPai($conn)
{
	//consultar grupos
	$grupo = "SELECT * FROM grupo ORDER BY nome_gru ASC";
	$query_grupo = mysqli_query($conn, $grupo);
	while ($row_grupo = mysqli_fetch_array($query_grupo)) { ?>
		<option value="<?php echo $row_grupo['id_gru']; ?>"><?php echo $row_grupo['nome_gru']; ?></option>
	<?php }
}

function ListarPerfisAcesso($usuarioNivelAtual, $conn)
{
	//consultar menu
	$cons_pg_menu = "
			SELECT * FROM 
				modulos m 
		    INNER JOIN 
		        paginas p 
		    ON
		        p.modulo_id = m.id_mod
		    INNER JOIN
		        niveis_acessos_paginas n
		    ON
		        n.pagina_id = p.id_pg
		    WHERE 
		        n.niveis_acesso_id = '$usuarioNivelAtual' AND p.menu_lateral = 1 AND m.permissao_mod = 1 group by m.id_mod ORDER BY m.id_mod ASC";
	$query_cons_pg_menu = mysqli_query($conn, $cons_pg_menu);
	while ($row_pg_menu = mysqli_fetch_array($query_cons_pg_menu)) { ?>
		<option value="<?php echo $row_pg_menu['id_mod']; ?>" <?php
																if ($row_pg_menu['id_mod'] == 2) {
																	echo "selected";
																}
																?>>
			<?php echo $row_pg_menu['nome_mod']; ?>
		</option>
	<?php }
}

function ListarDepartamentoEdit($id, $conn)
{
	//consultar departamento
	$cons_departamento = "SELECT * FROM departamento ORDER BY id_depar ASC ";
	$query_depar = mysqli_query($conn, $cons_departamento);
	while ($row_depar = mysqli_fetch_array($query_depar)) { ?>
		<option value="<?php echo $row_depar['id_depar']; ?>" <?php
																if ($row_depar['id_depar'] == $id) {
																	echo 'selected';
																}
																?>>
			<?php echo $row_depar['nome_depar']; ?></option>
	<?php }
}

function ListarGruposPaiEdit($grupo_atual, $conn)
{

	$grupo_pai = "SELECT * FROM grupo";
	$query_grupo_pai    = mysqli_query($conn, $grupo_pai);
	while ($row_grupo_pai = mysqli_fetch_array($query_grupo_pai)) { ?>
		<option value="<?php echo $row_grupo_pai['id_gru']; ?>" <?php
																//Nesse if eu trago a seleção pre defenina no bd
																if ($grupo_atual == $row_grupo_pai['id_gru']) {
																	echo 'selected';
																} ?>>
			<?php echo $row_grupo_pai['nome_gru']; ?>
		</option>
	<?php }
}

function ListarModulosSistema($botao_edit_mod, $botao_del_mod, $conn)
{
	//consultar modulo
	$cons_mod = "SELECT * FROM modulos m INNER JOIN situacoes_menu s ON s.id_st_me = m.permissao_mod ORDER BY nome_mod ASC";
	$query_cons_mod = mysqli_query($conn, $cons_mod);
	while ($rowMod = mysqli_fetch_array($query_cons_mod)) { ?>
		<tr>
			<th scope="row"><?php echo $rowMod['id_mod']; ?></th>
			<td><?php echo $rowMod['nome_mod']; ?></td>
			<td><?php echo $rowMod['chave_mod']; ?></td>
			<td class="<?php echo $rowMod['cor_st_me']; ?>"><?php echo $rowMod['nome_st_me']; ?></td>
			<td><?php echo date('d/m/Y H:i:s', strtotime($rowMod['created_mod'])); ?></td>
			<td>
				<?php if ($botao_edit_mod) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/sistema/editar/edit_modulo?modulo=<?php echo $rowMod['id_mod']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
				<?php if ($botao_del_mod) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/sistema/apagar/processa/proc_del_modulo?modulo=<?php echo $rowMod['id_mod']; ?>&nome=<?php echo $rowMod['nome_mod']; ?>">
						<i class="fa fa-fw fa-trash"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
}

function ListarOperacoesSistema($botao_edit_fluxo, $conn)
{
	//consultar paginas
	$cons_pg_sys = "SELECT * FROM paginas p LEFT JOIN objeto_paginas o ON o.idobj = p.objeto_id INNER JOIN modulos m ON m.id_mod = p.modulo_id ORDER BY nome_mod ASC";
	$query_cons_pg_sys = mysqli_query($conn, $cons_pg_sys);
	while ($SysPg = mysqli_fetch_array($query_cons_pg_sys)) { ?>
		<tr>
			<td><?php echo $SysPg['objeto']; ?></td>
			<td><?php echo $SysPg['nome_mod']; ?></td>
			<td><?php echo $SysPg['nome_pg']; ?></td>
			<td><?php echo $SysPg['endereco_pg']; ?></td>
			<td>
				<?php if ($botao_edit_fluxo) { ?>
					<a href="<?php echo pg; ?>/pages/modulo/sistema/editar/edit_fluxo?operacao=<?php echo $SysPg['id_pg']; ?>">
						<i class="fa fa-pencil-square"></i>
					</a>
				<?php } ?>
			</td>
		</tr>
	<?php }
}

function ListarModulos($conn)
{
	//modulos
	$list_mod = "SELECT * FROM modulos ORDER BY nome_mod ASC ";
	$query_list_mod = mysqli_query($conn, $list_mod);
	while ($mod = mysqli_fetch_array($query_list_mod)) { ?>
		<option value="<?php echo $mod['id_mod']; ?>">
			<?php echo $mod['nome_mod']; ?>
		</option>
	<?php }
}

function ListModulos($conn)
{
	//modulos
	$list_mod = "SELECT * FROM modulos ORDER BY nome_mod ASC ";
	$query_list_mod = mysqli_query($conn, $list_mod);
	return $query_list_mod;
}

function ListarOpcoesMenu($conn)
{
	//opções menu
	$list_op_menu = "SELECT * FROM opcoes_menu ORDER BY nome ASC";
	$query_list_op_menu = mysqli_query($conn, $list_op_menu);
	while ($OpMenu = mysqli_fetch_array($query_list_op_menu)) { ?>
		<option value="<?php echo $OpMenu['id']; ?>">
			<?php echo $OpMenu['nome']; ?>
		</option>
	<?php }
}

function ListarObjPaginas($conn)
{
	//objetos da pagina
	$obj = "SELECT * FROM objeto_paginas ORDER BY objeto ASC";
	$query_obj = mysqli_query($conn, $obj);
	while ($rowObj = mysqli_fetch_array($query_obj)) { ?>
		<option value="<?php echo $rowObj['idobj']; ?>">
			<?php echo $rowObj['objeto']; ?>
		</option>
	<?php }
}

function ListarModulosEdit($mod_atual, $conn)
{
	//modulos
	$list_mod = "SELECT * FROM modulos ORDER BY nome_mod ASC";
	$query_list_mod = mysqli_query($conn, $list_mod);
	while ($mod = mysqli_fetch_array($query_list_mod)) { ?>
		<option value="<?php echo $mod['id_mod']; ?>" <?php
														if ($mod_atual == $mod['id_mod']) {
															echo "selected";
														}
														?>>
			<?php echo $mod['nome_mod']; ?>
		</option>
	<?php }
}

function ListarMenuEdit($menu_atual, $conn)
{
	//opções menu
	$list_op_menu = "SELECT * FROM opcoes_menu ORDER BY nome ASC";
	$query_list_op_menu = mysqli_query($conn, $list_op_menu);
	while ($OpMenu = mysqli_fetch_array($query_list_op_menu)) { ?>
		<option value="<?php echo $OpMenu['id']; ?>" <?php
														if ($menu_atual == $OpMenu['id']) {
															echo "selected";
														}
														?>>
			<?php echo $OpMenu['nome']; ?>
		</option>
	<?php }
}

function ListarObjPaginasEdit($objID, $conn)
{
	//objetos da pagina
	$obj = "SELECT * FROM objeto_paginas ORDER BY objeto ASC";
	$query_obj = mysqli_query($conn, $obj);
	while ($rowObj = mysqli_fetch_array($query_obj)) { ?>
		<option value="<?php echo $rowObj['idobj']; ?>" <?php
														if ($objID == $rowObj['idobj']) {
															echo "selected";
														}
														?>>
			<?php echo $rowObj['objeto']; ?>
		</option>
	<?php }
}

function ListarStatusMenu($status_atual, $conn)
{
	//Consultar status
	$status = "SELECT * FROM situacoes_menu";
	$query_status = mysqli_query($conn, $status);
	while ($row_status = mysqli_fetch_array($query_status)) { ?>
		<option value="<?php echo $row_status['id_st_me']; ?>" <?php
																//Nesse if eu trago a seleção pre defenina no bd
																if ($status_atual == $row_status['id_st_me']) {
																	echo 'selected';
																}
																?>>
			<?php echo $row_status['nome_st_me']; ?>
		</option>
	<?php }
}

function ListarModulosPerfilAcesso($nvl, $nvl_user, $ordem, $conn, $btn_del_nvl)
{
	//consultar permissoes do perfil de acesso
	if ($nvl_user == 1) {
		$perm = "SELECT * FROM niveis_acessos_paginas n
		            INNER JOIN paginas p on p.id_pg = n.pagina_id
		            INNER JOIN situacoes_permisoes s on s.id_st_perm = n.permissao
		            INNER JOIN situacoes_menu m on m.id_st_me = n.menu
		        WHERE n.niveis_acesso_id = '$nvl' AND p.menu_lateral = 1 AND p.pagina_id IS NULL ORDER BY n.id_nvl_pg ASC ";
	} else {
		$perm = "SELECT * FROM niveis_acessos_paginas n
		            INNER JOIN paginas p on p.id_pg = n.pagina_id
		            INNER JOIN situacoes_permisoes s on s.id_st_perm = n.permissao
		            INNER JOIN situacoes_menu m on m.id_st_me = n.menu
		            INNER JOIN niveis_acessos nv on nv.id_nvl = n.niveis_acesso_id
		        WHERE n.niveis_acesso_id = '$nvl' AND p.menu_lateral = 1 AND p.pagina_id IS NULL AND nv.ordem_nvl > '$ordem' AND n.permissao = 1 ORDER BY n.id_nvl_pg ASC ";
	}
	$query_perm = mysqli_query($conn, $perm);
	while ($row_perm = mysqli_fetch_array($query_perm)) { ?>
		<tr>
			<td><?php echo $row_perm['nome_pg']; ?></td>
			<td class="<?php echo $row_perm['cor_st_perm']; ?>"><?php echo $row_perm['nome_st_perm']; ?></td>
			<td>
				<?php if ($btn_del_nvl) { ?>
					<a href="<?php echo pg ?>/pages/modulo/controle_de_acesso/apagar/proc_del_mod_permissao?modulo=<?php echo $row_perm['modulo_id']; ?>&nvl=<?php echo $nvl; ?>">
						<i class="fa fa-trash" aria-hidden="true"></i>	
					</a>
				<?php } ?>
				
			</td>
		</tr>
	<?php }
}

function ListarUsuarioPerfilAcesso($nvl, $conn)
{
	// code...
	$list_user_nvl = "SELECT u.login_user, c.nome_cargo FROM usuarios u INNER JOIN cargo c ON c.id_cargo = u.cargo_id WHERE u.niveis_acesso_id = '$nvl' ";
	$query_list_user_nvl = mysqli_query($conn, $list_user_nvl);
	while ($list_nvl = mysqli_fetch_array($query_list_user_nvl)) { ?>
		<tr>
			<td><?php echo $list_nvl['login_user']; ?></td>
			<td><?php echo $list_nvl['nome_cargo']; ?></td>
		</tr>
	<?php }
}

function ListarPermissoes($nvl, $conn)
{
	//consultar permissoes do perfil
	$per_menu_pg = "
        	SELECT 
        		* 
        	FROM 
        		paginas pg 
            INNER JOIN 
            	niveis_acessos_paginas nv ON nv.pagina_id = pg.id_pg
            LEFT JOIN 
            	objeto_paginas ob ON ob.idobj = pg.objeto_id
            INNER JOIN
            	modulos m ON m.id_mod = pg.modulo_id
            WHERE 
            	nv.niveis_acesso_id = '$nvl' order by pg.nome_pg ASC";
	$query_per_menu_pg = mysqli_query($conn, $per_menu_pg);
	while ($row_perm_menu_pg = mysqli_fetch_array($query_per_menu_pg)) { ?>
		<tr>
			<td scope="row"><?php echo $row_perm_menu_pg['objeto']; ?> </td>
			<td><?php echo $row_perm_menu_pg['nome_mod']; ?> </td>
			<td><?php echo $row_perm_menu_pg['nome_pg']; ?> </td>
			<td>
				<?php if ($row_perm_menu_pg['permissao'] == 1) { ?>
					<input type="checkbox" name="mycheckbox" checked data-bootstrap-switch data-off-color="danger" onfocus="AlterarPermissao(this.value);" data-on-color="success" value="<?php echo $row_perm_menu_pg['id_nvl_pg']; ?>" />
				<?php } else { ?>
					<input type="checkbox" name="mycheckbox" data-bootstrap-switch data-off-color="danger" onfocus="AlterarPermissao(this.value);" data-on-color="success" value="<?php echo $row_perm_menu_pg['id_nvl_pg']; ?>" />
				<?php } ?>
			</td>
		</tr>
	<?php }
}

function ListarModulosPerfilAcessoAtual($nvl, $ordem, $conn)
{
	//consultar menu
	$cons_pg_menu = "
			SELECT 
				id_mod,
				nome_mod 
			FROM 
				modulos  
			WHERE 
				id_mod 
			NOT IN 
				(
					SELECT 
						p.modulo_id 
					FROM 
						paginas p 
					INNER JOIN 
						niveis_acessos_paginas n 
					ON 
						n.pagina_id = p.id_pg 
					WHERE 
						n.niveis_acesso_id = '$nvl' 
					AND p.menu_lateral = 1 
					GROUP BY 
						p.modulo_id
				) 
			ORDER BY nome_mod ASC";
	$query_cons_pg_menu = mysqli_query($conn, $cons_pg_menu);
	while ($row_pg_menu = mysqli_fetch_array($query_cons_pg_menu)) { ?>
		<option value="<?php echo $row_pg_menu['id_mod']; ?>">
			<?php echo $row_pg_menu['nome_mod']; ?>
		</option>
		<?php }
}

function dados_sistema($dado, $conn)
{
	//Listar dados do sistema
	$cons_dados_sistema = "SELECT * FROM personalizacao_sistema p INNER JOIN versoes v ON v.idversao = p.versao_atual_sistema ";
	$query_cons_dados_sistema = mysqli_query($conn, $cons_dados_sistema);
	if (($query_cons_dados_sistema) and ($query_cons_dados_sistema->num_rows != 0)) {
		$dadosSys = mysqli_fetch_assoc($query_cons_dados_sistema);
		return $dadosSys[$dado];
	} else {
		return false;
	}
}

function ListarPlanos($PlanoNome, $opcao, $conn)
{
	// consultar planos
	$cons_plano = "SELECT idplano, nome_plano FROM planos ORDER BY nome_plano ASC";
	$query_cons_plano = mysqli_query($conn, $cons_plano);
	if ($opcao == "opcao_select") {
		if (empty($PlanoNome)) {
			while ($plano = mysqli_fetch_array($query_cons_plano)) { ?>
				<option value="<?php echo $plano['idplano']; ?>"><?php echo $plano['nome_plano']; ?></option>
			<?php }
		} else {
			while ($plano = mysqli_fetch_array($query_cons_plano)) { ?>
				<option value="<?php echo $plano['idplano']; ?>" <?php if ($PlanoNome == $plano['nome_plano']) {
																		echo "selected";
																	} ?>><?php echo $plano['nome_plano']; ?></option>
			<?php }
		}
	} elseif ($opcao == "opcao_ul") {
		while ($plano = mysqli_fetch_array($query_cons_plano)) { ?>
			<li><?php echo $plano['nome_plano']; ?></li>
		<?php }
	} else {
		return false;
	}
}

function ListarModeloPlanoEdit($opcao, $conn)
{
	// concultar modelo de plano
	$cons_modelos_plano = "
			SELECT 
				m.idmodeloplano, p.nome_plano, m.nome_mod_plano, m.valor_plano 
			FROM 
			planos_modelos m 
			INNER JOIN planos p ON p.idplano = m.plano_id ORDER BY m.nome_mod_plano ASC";
	$query_cons_modelos_plano = mysqli_query($conn, $cons_modelos_plano);
	if (($query_cons_modelos_plano) and ($query_cons_modelos_plano->num_rows > 0)) {
		while ($visu_pacote = mysqli_fetch_array($query_cons_modelos_plano)) {	?>
			<option value="<?php echo $visu_pacote['idmodeloplano']; ?>" <?php
																			if ($opcao == $visu_pacote['nome_mod_plano']) {
																				echo "selected";
																			}
																			?>><?php echo $visu_pacote['nome_mod_plano']; ?></option>
			<?php }
	} else {
		return false;
	}
}

function ListarModeloPlano($opcao, $conn)
{
	// concultar modelo de plano
	$cons_modelos = "SELECT nome_plano, nome_mod_plano, valor_plano FROM planos_modelos m INNER JOIN planos p ON p.idplano = m.plano_id ORDER BY nome_mod_plano ASC";
	$query_cons_modelos = mysqli_query($conn, $cons_modelos);
	if (($query_cons_modelos) and ($query_cons_modelos->num_rows > 0)) {
		if ($opcao == "preco") {
			while ($pacote = mysqli_fetch_array($query_cons_modelos)) {	?>
				<li><?php echo $pacote['nome_mod_plano']; ?>: <code>R$ <?php echo number_format($pacote['valor_plano'], 2, ",", "."); ?></code></li>
			<?php }
		} elseif ($opcao == "pacote") {
			while ($pacote = mysqli_fetch_array($query_cons_modelos)) {	?>
				<div class="col-sm-4">
					<div class="position-relative p-3 bg-gray" style="height: 180px">
						<div class="ribbon-wrapper ribbon-lg">
							<div class="ribbon bg-danger text-lg">
								<?php echo $pacote['nome_mod_plano']; ?>
							</div>
						</div>
						Pacote <br /> <?php echo $pacote['nome_plano']; ?> <br />
						<h5>R$ <?php echo number_format($pacote['valor_plano'], 2, ",", "."); ?></h5>
					</div>
				</div>
			<?php }
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function ListarContratos($conn)
{
	// consultar contratos
	$cons_contrato = "
			SELECT
				c.idcontratosistema, 
				c.razao_social,
				c.plano,
				pm.nome_mod_plano,
				c.valor_contrato,
				s.status_contrato,
				DATEDIFF(fim_contrato, CURDATE()) AS dias_virgencia
			FROM 
				contrato_sistema c 
			INNER JOIN 
				situacao_contrato s 
			ON 
				s.idsituacaocontrato = c.situacao_contrato_id 
			INNER JOIN 
				usuarios u 
			ON 
				u.id_user = c.usuario_id
			INNER JOIN 
				planos_modelos pm
			ON
				pm.idmodeloplano = c.planos_modelos_id
			ORDER BY
				c.razao_social,
				c.fim_contrato ASC
		";
	$query_cons_contrato = mysqli_query($conn, $cons_contrato);
	if (($query_cons_contrato) and ($query_cons_contrato->num_rows > 0)) {
		while ($dadosContrato = mysqli_fetch_array($query_cons_contrato)) { ?>
			<tr>
				<td><?php echo $dadosContrato['razao_social']; ?></td>
				<td><?php echo $dadosContrato['plano']; ?></td>
				<td><?php echo $dadosContrato['nome_mod_plano']; ?></td>
				<td>R$ <?php echo number_format($dadosContrato['valor_contrato'], 2, ",", "."); ?></td>
				<td><?php echo $dadosContrato['dias_virgencia'] . " dia(s)" ?></td>
				<td><?php echo $dadosContrato['status_contrato']; ?></td>
				<td>
					<a href="<?php echo pg;  ?>/pages/modulo/sistema/editar/edit_contrato?contrato=<?php echo $dadosContrato['idcontratosistema']; ?>">
						<i class="fa fa-pencil-square" aria-hidden="true"></i>
					</a>
				</td>
			</tr>
		<?php }
	} else {
		return false;
	}
}

function ListarUsuarios($contrato, $conn)
{
	// Listar usuários do sistema e contratos
	$cons_usuarios = "SELECT login_user, criado_user FROM usuarios WHERE contrato_sistema_id = '$contrato' ";
	$query_cons_usuarios = mysqli_query($conn, $cons_usuarios);
	if (($query_cons_usuarios) and ($query_cons_usuarios->num_rows != 0)) {
		while ($contratoUser = mysqli_fetch_assoc($query_cons_usuarios)) { ?>
			<tr>
				<td><?php echo $contratoUser['login_user']; ?></td>
				<td><?php echo date('d/m/Y H:i', strtotime($contratoUser['criado_user'])); ?></td>
			</tr>
		<?php }
	} else {
		return false;
	}
}

function ListarDadosContrato($contrato, $conn)
{
	// listar dados do contrato
	$cons_contrato = "SELECT * FROM contrato_sistema WHERE idcontratosistema = '$contrato' LIMIT 1 ";
	$query_cons_contrato = mysqli_query($conn, $cons_contrato);
	$contrato = mysqli_fetch_assoc($query_cons_contrato);
	return $contrato;
}

function ListarSituacaoContrato($situacao, $conn)
{
	// Listar situação do contrato atual
	$cons_status_contrato = "SELECT * FROM situacao_contrato ";
	$query_cons_status_contrato = mysqli_query($conn, $cons_status_contrato);
	while ($situacaoAtual = mysqli_fetch_assoc($query_cons_status_contrato)) { ?>
		<option value="<?php echo $situacaoAtual['idsituacaocontrato']; ?>" <?php if ($situacao == $situacaoAtual['idsituacaocontrato']) {
																				echo "selected";
																			} ?>><?php echo $situacaoAtual['status_contrato']; ?></option>
	<?php }
}

function changelog($conn)
{
	// litar change log
	$cons_version = "SELECT idversao, versao, DATE_FORMAT(created_versao, '%d %M %Y') AS data FROM versoes ORDER BY idversao DESC ";
	$query_cons_version = mysqli_query($conn, $cons_version);
	while ($version = mysqli_fetch_array($query_cons_version)) { ?>
		<div class="time-label">
			<span class="bg-gray text-center">
				<?php echo "v" . $version['versao'] . "<br>" . $version['data']; ?>
			</span>
		</div>
		<?php
		$cons_hist_change = "
	        	SELECT 
	        		DATE_FORMAT(ch.created, '%H:%i') AS hora, 
	        		DATE_FORMAT(ch.created, '%d/%m/%Y') AS dt,
	        		u.login_user,
	        		cv.icone,
	        		cv.mudanca,
	        		ch.descricao
	        	FROM changelog ch 
	        	INNER JOIN categoria_versao cv ON cv.idcatversao = ch.categoria_versao_id 
	        	INNER JOIN usuarios u ON u.id_user = ch.usuario_id
	        	WHERE ch.versoes_id = '" . $version['idversao'] . "' ORDER BY ch.idchangelog DESC";
		$query_cons_hist_change = mysqli_query($conn, $cons_hist_change);
		while ($hist_version = mysqli_fetch_array($query_cons_hist_change)) { ?>
			<div>
				<i class="<?php echo $hist_version['icone']; ?>"></i>
				<div class="timeline-item">
					<span class="time">
						<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $hist_version['dt']; ?>
						<i class="fa fa-clock"></i> <?php echo $hist_version['hora']; ?>
					</span>

					<h3 class="timeline-header"><a href="#"><?php echo $hist_version['login_user']; ?></a> <?php echo $hist_version['mudanca']; ?></h3>

					<div class="timeline-body">
						<?php echo $hist_version['descricao']; ?>
					</div>
				</div>
			</div>
		<?php }
	}
}

function listarVersoes($id, $conn)
{
	// versoes do sistema
	$cons_versao = "SELECT * FROM versoes ORDER BY idversao DESC";
	$query_cons_versao = mysqli_query($conn, $cons_versao);
	while ($versao = mysqli_fetch_array($query_cons_versao)) { ?>
		<option value="<?php echo $versao['idversao']; ?>" <?php if ($id == $versao['idversao']) {
																echo "selected";
															} ?>><?php echo $versao['versao']; ?></option>
	<?php }
}

function listarCategoria($conn)
{
	// categoria da versão
	$cons_cat_versao = "SELECT idcatversao, titulo FROM categoria_versao ORDER BY titulo ASC ";
	$query_cons_cat_versao = mysqli_query($conn, $cons_cat_versao);
	while ($cat = mysqli_fetch_array($query_cons_cat_versao)) { ?>
		<option value="<?php echo $cat['idcatversao']; ?>"><?php echo $cat['titulo']; ?></option>
<?php }
}

function Usuarios($dado, $conn)
{
	// Usuário logado
	$cons_usuario_logado = "SELECT 
			us.foto,
			us.nome_user,
			us.email_user,
			un.nome_uni,
			ca.nome_cargo,
			nv.nome_nvl,
			c.razao_social,
			d.nome_depar
		FROM 
			usuarios us
        INNER JOIN unidade un ON un.id_uni = us.unidade_id 
        INNER JOIN cargo ca ON ca.id_cargo = us.cargo_id
        LEFT JOIN departamento d ON d.id_depar = ca.departamento
        INNER JOIN niveis_acessos nv ON nv.id_nvl = us.niveis_acesso_id 
        LEFT JOIN contrato_sistema c ON c.idcontratosistema = us.contrato_sistema_id
        WHERE us.id_user = '{$_SESSION['usuarioID']}' LIMIT 1";
	$query_cons_usuario_logado = mysqli_query($conn, $cons_usuario_logado);
	$dadosUsuario = mysqli_fetch_assoc($query_cons_usuario_logado);
	return $dadosUsuario[$dado];
}

function ListarQtdUsuariosPorContrato($conn)
{
	// Listar qtd
	$cons_qtd_user = "SELECT * FROM usuarios_contrato";
	$query_cons_qtd_user = mysqli_query($conn, $cons_qtd_user);
	//$qtd = mysqli_fetch_assoc($query_cons_qtd_user);
	return $query_cons_qtd_user;
}

function ListarContratosAtivos($conn)
{
	// listar dados do contrato
	if (!empty($_SESSION['contratoID'])) {
		$cons_contrato = "SELECT idcontratosistema, razao_social FROM contrato_sistema WHERE idcontratosistema = '{$_SESSION['contratoID']}' ORDER BY razao_social ASC ";
	} else {
		$cons_contrato = "SELECT idcontratosistema, razao_social FROM contrato_sistema ORDER BY razao_social ASC ";
	}
	$query_cons_contrato = mysqli_query($conn, $cons_contrato);
	if (($query_cons_contrato) and ($query_cons_contrato->num_rows != 0)) {
		return $query_cons_contrato;
	} else {
		return false;
	}
}

function tmpEnquete($conn)
{
	$cons_enquete = "SELECT * FROM enquete WHERE usuario_id = '{$_SESSION['usuarioID']}' ";
	$query_cons_enquete = mysqli_query($conn, $cons_enquete);
	if (mysqli_affected_rows($conn) <= 0) {
		return true;
	} else {
		$cons_periodo = "SELECT * FROM enquete WHERE usuario_id = '{$_SESSION['usuarioID']}' AND DATEDIFF(NOW(), created) >= 15";
		$query_cons_periodo = mysqli_query($conn, $cons_periodo);
		if (($query_cons_periodo) and ($query_cons_periodo->num_rows != 0)) {
			return true;
		} else {
			return false;
		}
	}
}

function cons_generica($tabela, $conn)
{
	$cons = "SELECT * FROM $tabela ";
	$query_cons = mysqli_query($conn, $cons);
	return $query_cons;
}

function filesize_formatted($path)
{
	$size = $path;
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$power = $size > 0 ? floor(log($size, 1024)) : 0;
	return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function diasDatas($data_inicial, $data_final)
{
	$diferenca = strtotime($data_final) - strtotime($data_inicial);
	$dias = floor($diferenca / (60 * 60 * 24));
	return $dias;
}


function nome_sobrenome($nome)
{
	$partes = explode(' ', $nome);
	$primeiroNome = array_shift($partes);
	$ultimoNome = array_pop($partes);

	return $primeiroNome . " " . $ultimoNome;
}

function calcularIdade($dataNascimento)
{
	$hoje = new DateTime();
	$nascimento = new DateTime($dataNascimento);
	$idade = $hoje->diff($nascimento);
	return $idade->y;
}

function pastaModulo($nome)
{
	# pasta em minusculo
	$pasta = mb_strtolower($nome);

	# substituir espaços em branco pelo traço
	$pasta = str_replace(' ', '-', $pasta);

	return $pasta;
}

function listContratoEmpresa($conn)
{
	$cons_contrato = "SELECT * FROM contrato_sistema ORDER BY razao_social ASC ";
	$query_cons_contrato = mysqli_query($conn, $cons_contrato);
	return $query_cons_contrato;
}

function PesquisarEnquete($conn, $contrato, $dtinicio, $dtfim)
{

	$cons_enquete = "
			SELECT er.nome, COUNT(e.resultado) AS total FROM enquete_rating er
			RIGHT JOIN enquete e ON e.resultado	= er.pts 
			WHERE e.contrato_sistema_id = '$contrato'
			AND date(e.created) >= '$dtinicio' 
			AND date(e.created) <= '$dtfim' 
			GROUP BY er.idrating ORDER BY er.pts DESC
		";
	$query_cons_enquete = mysqli_query($conn, $cons_enquete);
	if (($query_cons_enquete) and ($query_cons_enquete->num_rows > 0)) {
		return $query_cons_enquete;
	} else {
		return $query_cons_enquete;
	}
}

function PesquisarEnqueteDepoimento($conn, $contrato, $dtinicio, $dtfim)
{

	$cons_enquete = "
			SELECT 
				obs, 
				DATE_FORMAT(created, '%d/%m/%Y') AS dt 
			FROM enquete 
			WHERE contrato_sistema_id = '$contrato' 
			AND obs <> '' 
			AND date(created) >= '$dtinicio' 
			AND date(created) <= '$dtfim' 
		";
	$query_cons_enquete = mysqli_query($conn, $cons_enquete);
	if (($query_cons_enquete) and ($query_cons_enquete->num_rows > 0)) {
		return $query_cons_enquete;
	} else {
		return $query_cons_enquete;
	}
}

function abreviarNomeUsuario($nomeCompleto)
{

	//verificar o tamanho da string
	if (strlen($nomeCompleto) > 20) {
		$partesNome = explode(' ', $nomeCompleto); // Divide o nome em partes separadas por espaço

		$nomeAbreviado = '';

		foreach ($partesNome as $indice => $parte) {
			if ($indice === 0 || $indice === count($partesNome) - 1) {
				$nomeAbreviado .= $parte . ' '; // Mantém o primeiro e último nome sem abreviação
			} else {
				// Verifica se a parte atual não é "DO", "DE" ou "DA"
				if (!in_array(strtoupper($parte), ['DO', 'DE', 'DA'])) {
					$primeiraLetra = substr($parte, 0, 1);
					$nomeAbreviado .= $primeiraLetra . '. '; // Abrevia as partes que não são "DO", "DE" ou "DA"
				} else {
					$nomeAbreviado .= $parte . ' '; // Mantém as partes "DO", "DE" ou "DA" sem abreviação
				}
			}
		}

		return trim($nomeAbreviado); // Remove espaços extras e retorna o nome abreviado
	} else {

		// Não abreviar nome
		return $nomeCompleto;
	}
}

//função para convertero tempo em milissegundos
function convTmp($horario)
{
	//$horario = "00:01:00";
	$partes = explode(':', $horario);
	$segundos = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
	$milissegundos = $segundos * 1000;
 
	return $milissegundos;
}

function slugGeral($text) {
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

function viewPub($conn, $id)
{
	$cons = "SELECT * FROM site_publicacoes WHERE id = '$id' ";
	$query = mysqli_query($conn, $cons);
	$result = mysqli_fetch_assoc($query);
	return $result;
}

function listCategorias($conn)
{
	$cons = "SELECT * FROM site_publicacoes_categoria ORDER BY categoria ASC ";
	$query = mysqli_query($conn, $cons);
	//$result = mysqli_fetch_assoc($query);
	return $query;
}

function listarDadosRedeSocial($conn)
{
	// Listar qtd
	$cons = "SELECT * FROM site_redes_socias";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function listarDadosEndereco($conn)
{
	// Listar qtd
	$cons = "SELECT * FROM site_endereco";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function listarDadosContato($conn)
{
	// Listar qtd
	$cons = "SELECT * FROM site_contato";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function listarDadosCeo($conn, $id)
{
	// Listar qtd
	$cons = "SELECT * FROM site_ceo WHERE id = $id LIMIT 1 ";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function listarDadosDepoimento($conn, $id)
{
	// Listar qtd
	$cons = "SELECT * FROM site_depoimento WHERE id = $id LIMIT 1 ";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function logo($conn, $local)
{
	// Listar qtd
	$cons = "SELECT * FROM site_logos WHERE local = '$local' ORDER BY id DESC LIMIT 1 ";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

function missaoVisaoValores($conn)
{
	// Listar qtd
	$cons = "SELECT * FROM site_missao_visao_valores";
	$query = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query);
	return $row;
}

?>