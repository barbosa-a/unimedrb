$(function () {  
    $('#formDataArtigoBC').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"processa/proc_cad_artigo.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnSendCadArtigo').attr('disabled','disabled');
                $('#btnSendCadArtigo').text('Aguarde...');
            },
            success:function(retorno){
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                });

                $('#formDataArtigoBC')[0].reset();
                $('#btnSendCadArtigo').attr('disabled', false);
                $('#btnSendCadArtigo').text('Salvar artigo');
            },
            error: function(xhr, status, error){
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnSendCadArtigo').attr('disabled', false);
                $('#btnSendCadArtigo').text('Salvar artigo');
            }
        });
    });
});

function listArtigos() {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var listArtigos  = document.getElementById("listArtigos");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listArtigos.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "../consultas/artigos.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listArtigos.innerHTML = xmlreq.responseText;
            }else{
                listArtigos.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }

   if (document.getElementById("resulArtigos")) {
    pesquisarArtigos(assunto = ""); 
   }

   function pesquisarArtigos(assunto) {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var listArtigos  = document.getElementById("resulArtigos");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listArtigos.innerHTML = '<h2 class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</h2>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "./consultas/cons_artigo.php?assunto="+assunto, true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listArtigos.innerHTML = xmlreq.responseText;
            }else{
                listArtigos.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }

   function cadVisualizacao(artigo) {
    $.ajax({
        url: "cadastrar/processa/proc_cad_visu.php",
        method: "POST",
        dataType: "json",
        data: {
            id: artigo
        },
        success: function (retorno) {
            
            if (retorno.tipo == "success") {
                $("#visuArtigo"+artigo).modal("show");    
            }else{
                Swal.fire({
                    icon: "error",
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: true
                });    
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: true
            });
        }
    }); 
   }

   function cadCurtidas(artigo, valor) {
    $.ajax({
        url: "cadastrar/processa/proc_cad_curtida.php",
        method: "POST",
        dataType: "json",
        data: {
            id: artigo,
            pont: valor
        },
        success: function (retorno) {

            Toast.fire({
                icon: retorno.tipo,
                title: retorno.msg
            });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: true
            });
        }
    }); 
   }
