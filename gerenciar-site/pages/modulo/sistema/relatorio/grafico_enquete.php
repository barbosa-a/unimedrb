<?php  
  //session_start();
  header("Content-Type: application/json; charset=utf-8", true);
  //segurança do ADM
  $seguranca = true;    
  //Biblioteca auxiliares
  include_once("../../../../config/config.php");
  include_once("../../../../config/conexao.php");
  include_once("../../../../lib/lib_funcoes.php");
  include_once("../../../../lib/lib_timezone.php");

  $dt = filter_input_array(INPUT_GET, FILTER_DEFAULT);

  $retorno = array();

  if (!empty($dt['dt_inicio']) AND !empty($dt['dt_fim'])) {
    $cons = "
      SELECT er.nome, COUNT(e.resultado) AS total FROM enquete_rating er
      LEFT JOIN enquete e ON e.resultado = er.pts 
      WHERE date(e.created) >= '{$dt['dt_inicio']}' AND date(e.created) <= '{$dt['dt_fim']}' 
      GROUP BY er.idrating ORDER BY er.pts DESC
    ";
  }else{
    $cons = "
      SELECT er.nome, COUNT(e.resultado) AS total FROM enquete_rating er
      LEFT JOIN enquete e ON e.resultado = er.pts
      GROUP BY er.idrating ORDER BY er.pts DESC
    ";
  }

  
  $query_cons = mysqli_query($conn, $cons);
  if (($query_cons) AND ($query_cons->num_rows > 0)) {
    while ($aval = mysqli_fetch_assoc($query_cons)) {
      array_push($retorno, array($aval["nome"], $aval["total"]));
    }      
  }else{
    array_push($retorno, array('Sem registros', 0));  
  }

  //Passando vetor em forma de json
  echo json_encode($retorno, JSON_NUMERIC_CHECK); 
  