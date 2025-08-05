$(function () {
    $(".ui-pg").sortable({
        update: function(event, ui) {
          var order = [];
          $(".sortable-item-pg").each(function() {
            order.push($(this).data("id"));
          });
    
          // Enviar a ordem para o servidor
          $.ajax({
            url: "editar/processa/proc_edit_ordem_pg.php",
            method: "POST",
            dataType: "JSON",
            data: { ordem: order },
            success: function(response) {
                toastr.success(response.msg);
                //Carregar todas as paginas do menu
                listPgMenu();
            },
            error: function(xhr, status, error) {
              // Lidar com erros (opcional)
              toastr.error('Erro interno no sistema');
            }
          });
        }
    });

    $('#formDataApi').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_api.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            async: true,
            beforeSend: function () {
                $('#btnSendCadApi').attr('disabled', 'disabled');
                $('#btnSendCadApi').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {
                    //Fechar modal
                    $("#modalNovaIntegracao").modal("hide");

                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: true
                    });
                }

                listApis();

                //$('#nova_senha_exp')[0].reset();
                $('#btnSendCadApi').attr('disabled', false);
                $('#btnSendCadApi').text('Salvar');
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
    });

    $('#formDataDoc').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_doc_api.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            async: true,
            beforeSend: function () {
                $('#btnSendCadDoc').attr('disabled', 'disabled');
                $('#btnSendCadDoc').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {
                    //Fechar modal
                    $("#novaDoc").modal("hide");

                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: true
                    });
                }

                listDocsApis();

                //$('#nova_senha_exp')[0].reset();
                $('#btnSendCadDoc').attr('disabled', false);
                $('#btnSendCadDoc').text('Salvar');
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
    });

    $('#formDataSendWpp').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "send/msg_whatsapp.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            async: true,
            beforeSend: function () {
                $('#btnSendWpp').attr('disabled', 'disabled');
                $('#btnSendWpp').text('Enviando...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {
                    //Fechar modal
                    $("#testApi").modal("hide");

                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    $('#formDataSendWpp')[0].reset();
                } else {
                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: true
                    });
                }

                
                $('#btnSendWpp').attr('disabled', false);
                $('#btnSendWpp').text('Enviar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendWpp').attr('disabled', false);
                $('#btnSendWpp').text('Enviar');
            }
        });
    });
});

function bkpdb() {
    $.ajax({
        url: "cadastrar/processa/proc_exe_bkp_bd.php",
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            $('#bkpbd').attr('disabled', 'disabled');
            $('#bkpbd').text('Fazendo backup...');   
        },
        success: function (retorno) {
            //Notificação
            Swal.fire({
                icon: retorno.tipo,
                title: retorno.titulo,
                text: retorno.msg,
                showConfirmButton: true,
                //timer: 2000
            });

            //$('#nova_senha_exp')[0].reset();
            $('#bkpbd').attr('disabled', false);
            $('#bkpbd').text('Backup local');  

            //Listar diretorio
            listBkpBd();
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

function listBkpBd() {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var listbkps  = document.getElementById("listbkps");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listbkps.innerHTML = '<tr class="text-center"><td colspan="3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/list_bkps_bd.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listbkps.innerHTML = xmlreq.responseText;
            }else{
                listbkps.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }

   function excluirBkpBD(arquivo) {

    
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    //listbkps.innerHTML = '<tr class="text-center"><td colspan="3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "apagar/processa/proc_del_bkp_bd.php?arquivo="+ arquivo, true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                Swal.fire({
                    icon: "info",
                    title: "Atenção",
                    text: xmlreq.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Ops",
                    text: xmlreq.statusText,
                    showConfirmButton: true,
                    //timer: 2000
                });
            }

            listBkpBd();
        }
    };
    xmlreq.send(null);
   }

   function bkpSys() {
    $.ajax({
        url: "cadastrar/processa/proc_exe_bkp_sys.php",
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            $('#bkpSys').attr('disabled', 'disabled');
            $('#bkpSys').text('Fazendo backup...');   
        },
        success: function (retorno) {
            //Notificação
            Swal.fire({
                icon: retorno.tipo,
                title: retorno.titulo,
                text: retorno.msg,
                showConfirmButton: true,
                //timer: 2000
            });

            //$('#nova_senha_exp')[0].reset();
            $('#bkpSys').attr('disabled', false);
            $('#bkpSys').text('Backup local');  

            //Listar diretorio
            listBkpSys();
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

function listBkpSys() {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var listbkps  = document.getElementById("listbkpSys");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listbkps.innerHTML = '<tr class="text-center"><td colspan="3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/list_bkps_sys.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listbkps.innerHTML = xmlreq.responseText;
            }else{
                listbkps.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }

   function excluirBkpSys(arquivo) {

    
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    //listbkps.innerHTML = '<tr class="text-center"><td colspan="3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "apagar/processa/proc_del_bkp_sys.php?arquivo="+ arquivo, true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                Swal.fire({
                    icon: "info",
                    title: "Atenção",
                    text: xmlreq.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Ops",
                    text: xmlreq.statusText,
                    showConfirmButton: true,
                    //timer: 2000
                });
            }

            listBkpSys();
        }
    };
    xmlreq.send(null);
   }



function listApis() {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var listApis  = document.getElementById("listApis");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listApis.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/list_apis.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listApis.innerHTML = xmlreq.responseText;
            }else{
                listApis.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }

function carregarIframe(link) {
    // Acesse o elemento iframe pelo ID
    var iframe = document.getElementById('previewIframe');

    // Defina o URL desejado no atributo src
    var url = link;
    iframe.src = url;    

    //Abrir modal
    $("#modalIframe").modal("show");
}

function listDocsApis() {
    var listApis  = document.getElementById("listDocsApis");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listApis.innerHTML = '<tr class="text-center"><td colspan="4"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/list_docs.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listApis.innerHTML = xmlreq.responseText;
            }else{
                listApis.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function abrirModalSendWpp(link) {

    document.getElementById("linkCurl").value = link;   

    $("#testApi").modal("show");  
}

if (document.getElementById("listPgMenu")) {
    listPgMenu();  
}

function listPgMenu() {

    // Declaração de Variáveis
    var listPgMenu  = document.getElementById("listPgMenu");
    var xmlreq = CriaRequest();
   
    // Exibi a imagem de progresso
    listPgMenu.innerHTML = '<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Aguarde carregando...</div>';
   
    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/paginas.php", true);
   
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
   
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
   
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                listPgMenu.innerHTML = xmlreq.responseText;
            }else{
                listPgMenu.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
   }