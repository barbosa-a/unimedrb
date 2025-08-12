<?php
    function formatFileSize($file) {
        $size = filesize($file);
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = 0;
    
        while ($size >= 1024 && $i < 4) {
            $size /= 1024;
            $i++;
        }
    
        return round($size, 2) . ' ' . $units[$i];
    }

    //consumir API com o CURL (Função para enviar msg via POST)
	function pullAPI($param1, $uri, $data){
        $curl = curl_init();
        switch ($param1){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
              break;
           default:
              if ($data)
                 $uri = sprintf("%s?%s", $uri, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    } 

    function sendWhatsApp($link, $numero, $msg) {
        $num = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $numero))));
        
        // Dados para enviar no corpo da requisição
        $data = array(
            "chatId" => validarNumeroTelefone($num) . "@c.us",
            "contentType" => "string",
            "content" => $msg,
        );
    
        // Headers da requisição
        $headers = array(
            'accept: */*',
            'x-api-key: comunidadezdg.com.br',
            'Content-Type: application/json'
        );
    
        // Inicializar a sessão cURL
        $ch = curl_init();
    
        // Configurar as opções da requisição
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Executar a requisição e obter a resposta
        $response = curl_exec($ch);
        $resposta = json_decode($response, true);
    
        // Verificar se houve algum erro
        if(curl_errno($ch)) {
            //echo 'Erro ao enviar requisição: ' . curl_error($ch);
            $arr = array('tipo' => 'success', 'titulo' => 'WhatsApp', 'msg' => 'Mensagem enviado');
            echo json_encode($arr); 
        }else{
    
            if ($resposta['success'] == true) {
                $arr = array('tipo' => 'success', 'titulo' => 'WhatsApp', 'msg' => "Mensagem enviado");
                echo json_encode($arr); 
            }else{
                $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao enviar mensagem de WhatsApp '. curl_error($ch) . "Erro: ". curl_errno($ch));
                echo json_encode($arr); 
            }
    
        }
    
        // Fechar a sessão cURL
        curl_close($ch);
    }

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

    function confApi($conn)
    {
        $cons = "SELECT * FROM apis";
        $query_cons = mysqli_query($conn, $cons);
        $row = mysqli_fetch_assoc($query_cons);
        return $row;
    }

    function validarNumeroTelefone($telefone) {
        // Remove caracteres não numéricos
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
    
        // Verifica se o número possui 11 dígitos e se o primeiro dígito é 9 (indicando um nono dígito)
        if (strlen($telefone) == 11 && substr($telefone, 2, 1) == '9') {
            // Remove o nono dígito
            $telefone = substr($telefone, 0, 2) . substr($telefone, 3);
        }
    
        if (strlen($telefone) == 10) {
            $telefone = 55 . $telefone;
        }
        
        if (strlen($telefone) <= 9) {
            $telefone = 404; //Número inválido
        }
    
        return $telefone;
    }
?>