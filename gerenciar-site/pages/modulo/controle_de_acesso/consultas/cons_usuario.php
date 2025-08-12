<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");
include_once("../../../../lib/lib_botoes.php");

$dados_usuario = filter_input(INPUT_GET, 'dados_usuario', FILTER_DEFAULT);
if (!empty($dados_usuario)) {
	//Cnsultar usuário atraves do campo pesquisa
	if (($_SESSION['usuarioNIVEL'] == 1) or ($_SESSION['contratoUSER'] == null) or ($_SESSION['contratoUSER'] == 0)) {
		$cons_usuario = "SELECT * FROM usuarios u
	            INNER JOIN situacoes_usuarios s on s.id_situacao = u.situacoes_usuario_id 
	            WHERE nome_user LIKE '%$dados_usuario%' ";
	} else {
		$cons_usuario = "SELECT * FROM usuarios u
			INNER JOIN situacoes_usuarios s on s.id_situacao = u.situacoes_usuario_id 
			WHERE 
			u.niveis_acesso_id <> 1 AND 
			u.contrato_sistema_id = '{$_SESSION['contratoUSER']}' AND 
			(u.nome_user LIKE '%$dados_usuario%' OR u.login_user LIKE '%$dados_usuario%') 
		";
	}
	$query_cons_usuario = mysqli_query($conn, $cons_usuario);
	if (($query_cons_usuario) and ($query_cons_usuario->num_rows != 0)) {
		$row_total = mysqli_num_rows($query_cons_usuario);
		echo '
		            <div class="row ">
		                <div class="col-6">
		                    Resultado(s) de busca: "' . $dados_usuario . '"
		                </div>
		                <div class="col-6 text-right">
		                    ' . $row_total . ' registro(s) encontrado.
		                </div>                                        
		            </div>
		            <div class="table-responsive">
		                <table class="table ">
		                    <thead>
		                        <tr>
		                            <th>Nome</th>
		                            <th>Nome de usuário</th>
		                            <th>Status</th>
		                            <th class="d-none d-md-table-cell">Data</th>
		                            <th>Ação</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		            ';
		while ($row_usuario = mysqli_fetch_array($query_cons_usuario)) { ?>
			<tr>
				<td><?php echo $row_usuario['nome_user']; ?></td>
				<td><?php echo $row_usuario['login_user']; ?></td>
				<td class="<?php echo $row_usuario['cor_situacao']; ?>"><?php echo $row_usuario['nome_situacao']; ?></td>
				<td class="d-none d-md-table-cell"><?php echo date('d/m/Y', strtotime($row_usuario['criado_user'])); ?></td>
				<td class="table-action">
					<?php if ($botao_edit_user) { ?>
						<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=<?php echo $row_usuario['token']; ?>">
							<i class="align-middle fa fa-pencil-square-o mr-2"></i>
						</a>
					<?php } ?>
					<?php if ($botao_apagar_user) { ?>
						<a href="#" data-toggle="modal" data-target="#deluser<?php echo $row_usuario['id_user']; ?>">
							<i class="align-middle fa fa-trash"></i>
						</a>
					<?php } ?>
				</td>
			</tr>
			<!-- Modal -->
			<div class="modal fade" id="deluser<?php echo $row_usuario['id_user']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p class="text-center">Deseja excluir este usu[ario?</p>
							<p class="text-center text-danger text-bold"><?php echo $row_usuario['nome_user']; ?></p>
						</div>
						<div class="modal-footer">
							<a href="<?php echo pg; ?>/pages/modulo/controle_de_acesso/apagar/proc_del_usuario?usuario=<?php echo $row_usuario['id_user']; ?>">
								<button type="button" class="btn btn-danger">Excluir</button>
							</a>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		</tbody>
		</table>
		</div>
	<?php  } else { ?>
		<tr>
			<td colspan="5">Nenhum usuário encontrado: "<?php echo $dados_usuario ?>"</td>
		</tr>
	<?php  } ?>
<?php } ?>