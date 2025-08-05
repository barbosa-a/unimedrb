var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(function () {  
    $('#formDataLogin').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"valida_login.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnLogin').attr('disabled','disabled');
                $('#btnLogin').text('Validando login...');
            },
            success:function(retorno){
                //Notificação
                
                if (retorno.url) {
                    location.replace(retorno.url);    
                }else{
                    Toast.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        //showConfirmButton: true,
                        //timer: 2000
                    });
                }                

                //$('#formDataLogin')[0].reset();
                $('#btnLogin').attr('disabled', false);
                $('#btnLogin').text('Acessar');
            },
            error: function(xhr, status, error){
                Toast.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    //showConfirmButton: false,
                    //timer: 2000
                });
                $('#btnLogin').attr('disabled', false);
                $('#btnLogin').text('Acessar');
            }
        });
    });

    $('#formDataUpdateSenha').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"valida/valida_senha_update.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#sendRedefinirSenha').attr('disabled','disabled');
                $('#sendRedefinirSenha').val('Atualizando senha...');
            },
            success:function(retorno){
                //Notificação
                
                if (retorno.url) {
                    Toast.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        //showConfirmButton: false,
                        //timer: 2900
                    });

                    setTimeout(() => {
                        location.replace(retorno.url);
                    }, 3000);  
                }else{
                    Toast.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        //showConfirmButton: true,
                        //timer: 2000
                    });
                }                

                //$('#formDataLogin')[0].reset();
                $('#sendRedefinirSenha').attr('disabled', false);
                $('#sendRedefinirSenha').val('Atualizar senha');
            },
            error: function(xhr, status, error){
                Toast.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    //showConfirmButton: false,
                    //timer: 5000
                });
                $('#sendRedefinirSenha').attr('disabled', false);
                $('#sendRedefinirSenha').val('Atualizar senha');
            }
        });
    });

    $('#formDataSenhaEmail').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"processa/proc_send_recover_password.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnSenhaEmail').attr('disabled','disabled');
                $('#btnSenhaEmail').text('Validando e-mail...');
            },
            success:function(retorno){
                //Notificação
                
                Toast.fire({
                    icon: retorno.tipo,
                    title: retorno.msg,
                });   
                
                if (retorno.tipo == "success") {
                    sendEmail(retorno.usuario, retorno.senha, retorno.modulo);
                }

                //$('#formDataLogin')[0].reset();
                $('#btnSenhaEmail').attr('disabled', false);
                $('#btnSenhaEmail').text('Solicitar nova senha');
            },
            error: function(xhr, status, error){
                Toast.fire({
                    icon: "error",
                    title: "Erro interno ao validar e-mail",
                    text: xhr.responseText,
                    //showConfirmButton: false,
                    //timer: 2000
                });
                $('#btnSenhaEmail').attr('disabled', false);
                $('#btnSenhaEmail').text('Solicitar nova senha');
            }
        });
    });

    $('#formDataSenhaWpp').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"processa/proc_send_recover_password_wpp.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnSenhaWpp').attr('disabled','disabled');
                $('#btnSenhaWpp').text('Validando número...');
            },
            success:function(retorno){
                //Notificação
                
                Toast.fire({
                    icon: retorno.tipo,
                    title: retorno.msg,
                });   
                
                if (retorno.tipo == "success") {
                    sendWpp(retorno.usuario, retorno.wpp, retorno.senha, retorno.modulo);
                }

                //$('#formDataLogin')[0].reset();
                $('#btnSenhaWpp').attr('disabled', false);
                $('#btnSenhaWpp').text('Solicitar');
            },
            error: function(xhr, status, error){
                Toast.fire({
                    icon: "error",
                    title: "Erro interno ao validar número",
                    text: xhr.responseText,
                    //showConfirmButton: false,
                    //timer: 2000
                });
                $('#btnSenhaWpp').attr('disabled', false);
                $('#btnSenhaWpp').text('Solicitar');
            }
        });
    });

    $('#formDataNewUser').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"cadastrar/processa/proc_cad_usuario.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnRegistrar').attr('disabled','disabled');
                $('#btnRegistrar').text('Registrando aguarde...');
            },
            success:function(retorno){

                //Notificação                
                Toast.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    //showConfirmButton: true,
                    //timer: 2000
                });               

                //$('#formDataLogin')[0].reset();
                $('#btnRegistrar').attr('disabled', false);
                $('#btnRegistrar').text('Registrar');
            },
            error: function(xhr, status, error){
                Toast.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    //showConfirmButton: true
                });
                $('#btnRegistrar').attr('disabled', false);
                $('#btnRegistrar').text('Registrar');
            }
        });
    });
});

function sendEmail(usuario, senha, modulo) {
    $.ajax({
        url: "processa/send_email.php",
        method: 'POST',
        data: {
            'usuario': usuario,
            'senha': senha,
            'modulo': modulo
        },
        dataType: "json",
        beforeSend: function () {
            $('#btnSenhaEmail').attr('disabled', 'disabled');
            $('#btnSenhaEmail').text('Enviando e-mail...');
        },
        success: function (result) {
            Toast.fire({
                icon: result.tipo,
                title: result.msg
            });
            $('#btnSenhaEmail').attr('disabled', false);
            $('#btnSenhaEmail').text('Solicitar nova senha');
        },
        error: function (xhr, status, error) {
            Toast.fire({
                icon: 'error',
                title: xhr.responseText
            });
            $('#btnSenhaEmail').attr('disabled', false);
            $('#btnSenhaEmail').text('Solicitar nova senha');
        }
    });
}

function sendWpp(usuario, numero, senha, modulo) {
    $.ajax({
        url: "processa/send_wpp.php",
        method: 'POST',
        data: {
            'usuario': usuario,
            'wpp': numero,
            'senha': senha,
            'modulo': modulo
        },
        dataType: "json",
        beforeSend: function () {
            $('#btnSenhaWpp').attr('disabled', 'disabled');
            $('#btnSenhaWpp').text('Enviando mensagem...');
        },
        success: function (result) {
            Toast.fire({
                icon: result.tipo,
                title: result.msg
            });

            $("#modalWpp").modal("hide");
            
            $('#btnSenhaWpp').attr('disabled', false);
            $('#btnSenhaWpp').text('Solicitar');
        },
        error: function (xhr) {
            Toast.fire({
                icon: 'error',
                title: xhr.responseText
            });
            $('#btnSenhaWpp').attr('disabled', false);
            $('#btnSenhaWpp').text('Solicitar');
        }
    });
}