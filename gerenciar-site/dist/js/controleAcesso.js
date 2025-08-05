// Obtenha a URL atual
var url = new URL(window.location.href);

// Obtenha o valor do parâmetro 'nvl'
var nvl = url.searchParams.get('nvl');

$(function () {

    $('#formDataCadUser').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_cad_usuario.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            beforeSend: function () {
                $('#sendCadastraUser').attr('disabled', 'disabled');
                $('#sendCadastraUser').val('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {

                    Toast.fire({
                        icon: retorno.tipo,
                        title: retorno.msg
                    });

                    $('#formDataCadUser')[0].reset();

                    //let checkbox = document.getElementById('sendEmail');

                    if (retorno.sendemail == "on") {
                        sendEmail(retorno.id, retorno.senha, retorno.modulo);
                    }

                } else {
                    Swal.fire({
                        icon: retorno.tipo,
                        title: retorno.titulo,
                        text: retorno.msg,
                        showConfirmButton: true
                    });
                }


                $('#sendCadastraUser').attr('disabled', false);
                $('#sendCadastraUser').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true
                });
                $('#sendCadastraUser').attr('disabled', false);
                $('#sendCadastraUser').val('Salvar');
            }
        });
    });

    $('#formDataFotoPerfil').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url:"processa/proc_edit_foto.php",
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

                $('#formDataFotoPerfil')[0].reset();
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

                $('#btnSendCadAvatar').attr('disabled', false);
                $('#btnSendCadAvatar').text('Salvar imagem');
            }
        });
    });
});

function sendEmail(usuario, senha, modulo) {
    $.ajax({
        url: "../send/send_email.php",
        method: 'POST',
        data: {
            'usuario': usuario,
            'senha': senha,
            'modulo': modulo
        },
        dataType: "json",
        beforeSend: function () {
            $('#sendCadastraUser').attr('disabled', 'disabled');
            $('#sendCadastraUser').val('Enviando e-mail...');
        },
        success: function (result) {
            Toast.fire({
                icon: result.tipo,
                title: result.msg
            });
            $('#sendCadastraUser').attr('disabled', false);
            $('#sendCadastraUser').val('Salvar');
        },
        error: function (xhr, status, error) {
            Toast.fire({
                icon: 'error',
                title: xhr.responseText
            });
            $('#sendCadastraUser').attr('disabled', false);
            $('#sendCadastraUser').val('Salvar');
        }
    });
}

let preloader = document.querySelector('.preloader-custom');

function startLoading() {
    preloader.style.display = 'flex';
    // Aqui você pode adicionar lógica adicional de carregamento, se necessário
}

function stopLoading() {
    preloader.style.display = 'none';
    // Aqui você pode adicionar lógica adicional para parar o carregamento, se necessário
}

//Alterar permissoes do usuári no perfil de acesso
function AlterarPermissao(valor) {
    var dados = {
        'permissao' : valor
    };
    var pgurl = '../editar/processa/proc_autoriza_desautoriza_permissao.php';
    $.ajax({
        //url da pagina
        url: pgurl,
        data: dados,
        type: 'POST',
        cache: false,
        error: function(){
            Toast.fire({
                icon: 'error',
                title: 'Erro ao realizar chamada.'
            });
        },
        success: function (result) {
            if(result == '1'){
                Toast.fire({
                    icon: 'success',
                    title: ' Permissão alterada com sucesso.'
                });
                searchPermission(permission = "", nvl);
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Permissão não alterada.'
                });    
            }
        }
    });
}

if (document.querySelector('#result-permission')) { 

    // Verifique se o valor foi encontrado
    if (nvl !== null) {
        sincronizarPermissoes(nvl);
    } else {
        Toast.fire({
            icon: "error",
            title: "O parâmetro nvl não foi encontrado na URL."
        });
    }
}

function sincronizarPermissoes(nvl) {
    $.ajax({
        url: "../sincronizar/processa/sincronizar_permissoes.php",
        method: 'POST',        
        data: {
            'nvl': nvl
        }, 
        dataType: "json",      
        beforeSend: function () {
            //$("#sincronPg").modal("show");            
        },
        success: function (result) {

            Toast.fire({
                icon: 'info',
                title: result.msg
            });            

            searchPermission(permission = "", nvl);           
            
        },
        error: function (xhr, status, error){
            Toast.fire({
                icon: 'error',
                title: xhr.responseText
            });
        }
    });    
}

function searchPermission(permission, nvl) {

    startLoading();

    $.ajax({
        type: 'POST',
        url: '../consultas/cons_permission.php',
        data: {
            permission: permission,
            nvl: nvl
        },
        success: function (response) {
            $('#result-permission').html(response);
            stopLoading();
        }
    });
}

obterLocalizacao();

function obterLocalizacao() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(mostrarLocalizacao);
    } else {
        Toast.fire({
            icon: "info",
            title: "Geolocalização não é suportada neste navegador."
        });
        //alert("Geolocalização não é suportada neste navegador.");
    }
}

function mostrarLocalizacao(posicao) {
    var latitude = posicao.coords.latitude;
    var longitude = posicao.coords.longitude;

    // Envie as coordenadas para o servidor (por exemplo, usando AJAX)
    // Exiba as coordenadas ou realize outras operações necessárias
    //alert("Latitude: " + latitude + "\nLongitude: " + longitude);

    $.ajax({
        type: 'POST',
        url: pastaRaiz + 'pages/modulo/controle_de_acesso/cadastrar/processa/localizacao.php',
        dataType: 'json',
        data: {
            latitude: latitude,
            longitude: longitude
        },
        success: function (response) {
            if (response.tipo == 'error') {
                Toast.fire({
                    icon: response.tipo,
                    title: response.msg
                });    
            }            
        }
    });
    
}