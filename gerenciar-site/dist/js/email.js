$(function () {
    $('#formDataEmailTeste').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "envio/testar_srv.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            async: true,
            beforeSend: function () {
                $('#testarSrvEmail').attr('disabled', 'disabled');
                $('#testarSrvEmail').text('Aguarde...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {
                    //Fechar modal
                    $("#modal-form-envio").modal("hide");

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

                //$('#nova_senha_exp')[0].reset();
                $('#testarSrvEmail').attr('disabled', false);
                $('#testarSrvEmail').text('Testar servidor');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true
                });
                $('#testarSrvEmail').attr('disabled', false);
                $('#testarSrvEmail').text('Testar servidor');
            }
        });
    });

});

function sendEmailModeloTeste(id, modulo) {
    $.ajax({
        url: "envio/testar_modelo.php",
        method: "POST",
        data: {
            modulo: modulo
        },
        dataType: "json",
        beforeSend: function () {
            $('button[id="'+id+'"]').attr('disabled', 'disabled');
            $('button[id="'+id+'"]').append('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');   
        },
        success: function (retorno) {
            //Notificação
            if (retorno.tipo == "success") {
                //Fechar modal
                //$("#modal-form-envio").modal("hide");

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

            //$('#nova_senha_exp')[0].reset();
            $('button[id="'+id+'"]').attr('disabled', false);
            $(".spinner-border.spinner-border-sm").remove();
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