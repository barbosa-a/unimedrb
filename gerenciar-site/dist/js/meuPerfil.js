$(function () {  
    $('#formDataAvatarPerfil').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"processa/proc_cad_avatar.php",
            method:"POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#btnSendCadAvatar').attr('disabled','disabled');
                $('#btnSendCadAvatar').text('Aguarde...');
            },
            success:function(retorno){
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#formDataAvatarPerfil')[0].reset();
                $('#btnSendCadAvatar').attr('disabled', false);
                $('#btnSendCadAvatar').text('Salvar imagem');
            },
            error: function(xhr, status, error){
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });
});