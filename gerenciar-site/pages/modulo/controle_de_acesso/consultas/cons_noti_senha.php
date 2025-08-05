<?php  
	session_start();
	//segurança do ADM
    $seguranca = true;   
    include_once("../../../../config/config.php"); 
	include_once("../../../../config/conexao.php");
	include_once("../../../../lib/lib_funcoes.php");
	include_once("../../../../lib/lib_botoes.php");

	//consultar historico de senhas alteradas e mostrar notificação
	$senha_atual_user = "
		SELECT 
			30 - TIMESTAMPDIFF(DAY, created_hist_senha, NOW()) AS dias
		FROM 
			hist_senha 
		WHERE 
			usuario_id = '{$_SESSION['usuarioID']}' 
		AND
			evento_senha_id = 1 
		ORDER BY created_hist_senha DESC LIMIT 1 ";
	$query_senha_atual_user = mysqli_query($conn, $senha_atual_user);
	if (($query_senha_atual_user) AND ($query_senha_atual_user->num_rows > 0)) {
		$user_logado = mysqli_fetch_assoc($query_senha_atual_user);
		if ($user_logado['dias'] < 7) {		
			$temp = array('dias' => $user_logado['dias']);
			echo json_encode($temp);
		}
	}	
?>