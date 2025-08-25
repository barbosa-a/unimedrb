let post_id = 0;

if (document.querySelector('#SendCadSobre')) {
    loadDataSobre();
}

if (document.getElementById('list-parceiros')) {
    listarParceiros();
}

if (document.getElementById('listar-depoimentos')) {
    listarDepoimentos();
}

if (document.getElementById('list-videos')) {
    listarVideos();
}

if (document.getElementById('list-galerias')) {
    listarGalerias();
}

if (document.getElementById('list-links')) {
    listarLinksUteis();
}

if (document.getElementById('list-fale-conosco')) {
    listarFaleConosco();
}

if (document.getElementById('list-organograma')) {
    listarOrganograma();
}

$(document).ready(function () {
    $('#categoriaPub').select2({
        placeholder: 'Pesquise uma categoria',
        ajax: {
            url: 'consultas/get-categorias.php',  // URL da sua API ou endpoint que retorna os dados
            dataType: 'json',
            delay: 250, // Tempo de atraso para otimizar as requisições
            data: function (params) {
                return {
                    searchTerm: params.term // O que o usuário digitou
                };
            },
            processResults: function (data) {
                // Formate os dados no formato esperado pelo Select2
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,  // o valor que será enviado ao backend
                            text: item.text // o texto que será mostrado no dropdown
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2 // Mínimo de caracteres para começar a busca
    });

});


$(function () {



    // Ativa a funcionalidade de arrastar e soltar na lista
    $("#list-banners").sortable({
        update: function (event, ui) {
            var orderedIDs = $(this).sortable('toArray', { attribute: 'data-id' });

            // Chamada AJAX para salvar a nova ordem no MySQL
            fetch('editar/processa/proc_up_ordem_banner.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ orderedIDs: orderedIDs })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //alert('Ordem atualizada com sucesso!');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            text: 'Ordem atualizada com sucesso!',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        //alert('Falha ao atualizar a ordem');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            text: 'Falha ao atualizar a ordem',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(error =>
                    Swal.fire({
                        icon: 'error',
                        text: 'Erro ao atualizar a ordem:', error,
                        toast: false,
                        showConfirmButton: false,
                        timer: 3000
                    })
                );
        }
    });

    $("#list-sobre-img").sortable({
        update: function (event, ui) {
            var orderedIDs = $(this).sortable('toArray', { attribute: 'data-id' });

            // Chamada AJAX para salvar a nova ordem no MySQL
            fetch('editar/processa/proc_up_ordem_sobre.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ orderedIDs: orderedIDs })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //alert('Ordem atualizada com sucesso!');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            text: 'Ordem atualizada com sucesso!',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        //alert('Falha ao atualizar a ordem');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            text: 'Falha ao atualizar a ordem',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(error =>
                    Swal.fire({
                        icon: 'error',
                        text: 'Erro ao atualizar a ordem:', error,
                        toast: false,
                        showConfirmButton: false,
                        timer: 3000
                    })
                );
        }
    });

    $('#formDataCapaPrincipal').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_capa_principal.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnCapa1').attr('disabled', 'disabled');
                $('#btnCapa1').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnCapa1').attr('disabled', false);
                $('#btnCapa1').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnCapa1').attr('disabled', false);
                $('#btnCapa1').text('Salvar');
            }
        });
    });

    $('#formDataCapaPub').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_capa_pub.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnCapa2').attr('disabled', 'disabled');
                $('#btnCapa2').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnCapa2').attr('disabled', false);
                $('#btnCapa2').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnCapa2').attr('disabled', false);
                $('#btnCapa2').text('Salvar');
            }
        });
    });

    $('#formDataBanner').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_banner.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadBanner').attr('disabled', 'disabled');
                $('#SendCadBanner').val('Salvando banner...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $('#formDataBanner')[0].reset();
                }

                $('#SendCadBanner').attr('disabled', false);
                $('#SendCadBanner').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadBanner').attr('disabled', false);
                $('#SendCadBanner').val('Salvar');
            }
        });
    });

    $('#formDataBannerSobre').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_banner_sobre.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadBannerSobre').attr('disabled', 'disabled');
                $('#SendCadBannerSobre').val('Salvando imagem...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $('#formDataBannerSobre')[0].reset();
                    listarBannerSobre();
                }

                $('#SendCadBannerSobre').attr('disabled', false);
                $('#SendCadBannerSobre').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadBannerSobre').attr('disabled', false);
                $('#SendCadBannerSobre').val('Salvar');
            }
        });
    });

    $('#formDataPubDestaque').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_pub_destaque.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadPubDestaque').attr('disabled', 'disabled');
                $('#SendCadPubDestaque').val('Salvando postagem...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $('#formDataPubDestaque')[0].reset();
                }

                $('#SendCadPubDestaque').attr('disabled', false);
                $('#SendCadPubDestaque').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadPubDestaque').attr('disabled', false);
                $('#SendCadPubDestaque').val('Salvar');
            }
        });
    });

    $('#formDataEditPubDestaque').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "editar/processa/proc_edit_pub_destaque.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendEditPubDestaque').attr('disabled', 'disabled');
                $('#SendEditPubDestaque').val('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $("#mdEditarDestaque").modal("hide");
                    loadTableDataDestaque();
                }

                $('#SendEditPubDestaque').attr('disabled', false);
                $('#SendEditPubDestaque').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendEditPubDestaque').attr('disabled', false);
                $('#SendEditPubDestaque').val('Salvar');
            }
        });
    });

    $('#formDataSobre').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_sobre.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadSobre').attr('disabled', 'disabled');
                $('#SendCadSobre').val('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#SendCadSobre').attr('disabled', false);
                $('#SendCadSobre').val('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadSobre').attr('disabled', false);
                $('#SendCadSobre').val('Salvar');
            }
        });
    });

    $('#formDataCategoriaPub').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_categoria.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendCategoriaPub').attr('disabled', 'disabled');
                $('#btnSendCategoriaPub').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $('#formDataCategoriaPub')[0].reset();
                    $('#novaCategoriaPub').modal('hide');
                }

                $('#btnSendCategoriaPub').attr('disabled', false);
                $('#btnSendCategoriaPub').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendCategoriaPub').attr('disabled', false);
                $('#btnSendCategoriaPub').text('Salvar');
            }
        });
    });

    $('#formDataPub').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_pub.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendPublicar').attr('disabled', 'disabled');
                $('#SendPublicar').val('Salvando postagem...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {

                    post_id = retorno.id;

                    $('#formDataPub')[0].reset();

                    // Iniciar upload das imagens paa galeria
                    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));

                }

                $('#SendPublicar').attr('disabled', false);
                $('#SendPublicar').val('Publicar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendPublicar').attr('disabled', false);
                $('#SendPublicar').val('Publicar');
            }
        });
    });

    $('#formDataEditPub').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_pub.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendPublicar').attr('disabled', 'disabled');
                $('#SendPublicar').val('Salvando postagem...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#SendPublicar').attr('disabled', false);
                $('#SendPublicar').val('Publicar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendPublicar').attr('disabled', false);
                $('#SendPublicar').val('Publicar');
            }
        });
    });

    $('#formDataEditCategoriaPub').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "../cadastrar/processa/proc_cad_categoria.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendCategoriaPub').attr('disabled', 'disabled');
                $('#btnSendCategoriaPub').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    $('#novaEditCategoriaPub').modal('hide');
                }

                $('#btnSendCategoriaPub').attr('disabled', false);
                $('#btnSendCategoriaPub').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendCategoriaPub').attr('disabled', false);
                $('#btnSendCategoriaPub').text('Salvar');
            }
        });
    });

    $('#formDataRedeSocial').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_rede_social.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendRedeSocial').attr('disabled', 'disabled');
                $('#btnSendRedeSocial').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendRedeSocial').attr('disabled', false);
                $('#btnSendRedeSocial').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendRedeSocial').attr('disabled', false);
                $('#btnSendRedeSocial').text('Salvar');
            }
        });
    });

    $('#formDataEndereco').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_endereco.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendEnd').attr('disabled', 'disabled');
                $('#btnSendEnd').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendEnd').attr('disabled', false);
                $('#btnSendEnd').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendEnd').attr('disabled', false);
                $('#btnSendEnd').text('Salvar');
            }
        });
    });

    $('#formDataContato').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_contato.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendContato').attr('disabled', 'disabled');
                $('#btnSendContato').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendContato').attr('disabled', false);
                $('#btnSendContato').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendContato').attr('disabled', false);
                $('#btnSendContato').text('Salvar');
            }
        });
    });

    $('#formDataFaq').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_faq.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendContato').attr('disabled', 'disabled');
                $('#btnSendContato').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                retorno.tipo == "success" ? $('#mdFaq').modal("hide") : '';

                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                loadFaq();

                $('#btnSendContato').attr('disabled', false);
                $('#btnSendContato').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendContato').attr('disabled', false);
                $('#btnSendContato').text('Salvar');
            }
        });
    });

    $('#formDataCeo').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_ceo.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendCeo').attr('disabled', 'disabled');
                $('#btnSendCeo').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendCeo').attr('disabled', false);
                $('#btnSendCeo').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendCeo').attr('disabled', false);
                $('#btnSendCeo').text('Salvar');
            }
        });
    });

    $('#formDataEditCeo').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_ceo.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendEditCeo').attr('disabled', 'disabled');
                $('#btnSendEditCeo').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendEditCeo').attr('disabled', false);
                $('#btnSendEditCeo').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendEditCeo').attr('disabled', false);
                $('#btnSendEditCeo').text('Salvar');
            }
        });
    });

    $('#formDataEditFoto').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_foto_ceo.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnEditFoto').attr('disabled', 'disabled');
                $('#btnEditFoto').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnEditFoto').attr('disabled', false);
                $('#btnEditFoto').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnEditFoto').attr('disabled', false);
                $('#btnEditFoto').text('Salvar');
            }
        });
    });

    $('#formDataDelCeo').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "../apagar/processa/proc_del_ceo.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnDelCeo').attr('disabled', 'disabled');
                $('#btnDelCeo').text('Apagando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                if (retorno.tipo == "success") {
                    setTimeout(function () {
                        window.location.href = "../ceo";
                    }, 2001);
                }

                $('#btnDelCeo').attr('disabled', false);
                $('#btnDelCeo').text('Apagar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnDelCeo').attr('disabled', false);
                $('#btnDelCeo').text('Apagar');
            }
        });
    });

    $('#formDataParceiros').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_parceiro.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendParceiros').attr('disabled', 'disabled');
                $('#btnSendParceiros').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarParceiros();

                $('#btnSendParceiros').attr('disabled', false);
                $('#btnSendParceiros').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendParceiros').attr('disabled', false);
                $('#btnSendParceiros').text('Salvar');
            }
        });
    });

    $('#formDataDepoimento').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_depoimento.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#sendCadDep').attr('disabled', 'disabled');
                $('#sendCadDep').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarDepoimentos();

                $('#sendCadDep').attr('disabled', false);
                $('#sendCadDep').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#sendCadDep').attr('disabled', false);
                $('#sendCadDep').text('Salvar');
            }
        });
    });

    $('#formDataEditDepoimento').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_depoimento.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#sendCadDep').attr('disabled', 'disabled');
                $('#sendCadDep').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#sendCadDep').attr('disabled', false);
                $('#sendCadDep').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#sendCadDep').attr('disabled', false);
                $('#sendCadDep').text('Salvar');
            }
        });
    });

    $('#formDataEditFotoDepoimento').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "processa/proc_edit_foto_depoimento.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#sendEditDep').attr('disabled', 'disabled');
                $('#sendEditDep').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#sendEditDep').attr('disabled', false);
                $('#sendEditDep').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#sendEditDep').attr('disabled', false);
                $('#sendEditDep').text('Salvar');
            }
        });
    });

    $('#formDataSec01').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_ads01.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadSec01').attr('disabled', 'disabled');
                $('#SendCadSec01').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarAds01();

                $('#SendCadSec01').attr('disabled', false);
                $('#SendCadSec01').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadSec01').attr('disabled', false);
                $('#SendCadSec01').text('Salvar');
            }
        });
    });

    $('#formDataSec02').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_ads02.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadSec02').attr('disabled', 'disabled');
                $('#SendCadSec02').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarAds02();

                $('#SendCadSec02').attr('disabled', false);
                $('#SendCadSec02').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadSec02').attr('disabled', false);
                $('#SendCadSec02').text('Salvar');
            }
        });
    });

    $('#formDataSec03').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_ads03.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SendCadSec03').attr('disabled', 'disabled');
                $('#SendCadSec03').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarAds03();

                $('#SendCadSec03').attr('disabled', false);
                $('#SendCadSec03').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#SendCadSec03').attr('disabled', false);
                $('#SendCadSec03').text('Salvar');
            }
        });
    });

    $('#formDataLogoCabecalho').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_logo_cb.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

                $('#btnSendLogoCabecalho').attr('disabled', 'disabled');
                $('#btnSendLogoCabecalho').text('Salvando...');

            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendLogoCabecalho').attr('disabled', false);
                $('#btnSendLogoCabecalho').text('Salvar');

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendLogoCabecalho').attr('disabled', false);
                $('#btnSendLogoCabecalho').text('Salvar');
            }
        });
    });

    $('#formDataLogoRodape').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_logo_rp.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

                $('#btnSendLogoRodape').attr('disabled', 'disabled');
                $('#btnSendLogoRodape').text('Salvando...');

            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendLogoRodape').attr('disabled', false);
                $('#btnSendLogoRodape').text('Salvar');

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendLogoRodape').attr('disabled', false);
                $('#btnSendLogoRodape').text('Salvar');
            }
        });
    });

    $('#formDataUrl').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_video.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

                $('#btnSendVideo').attr('disabled', 'disabled');
                $('#btnSendVideo').text('Salvando...');

            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarVideos();

                $('#btnSendVideo').attr('disabled', false);
                $('#btnSendVideo').text('Salvar');

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendVideo').attr('disabled', false);
                $('#btnSendVideo').text('Salvar');
            }
        });
    });

    $('#formDataGaleria').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_galeria.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

                $('#btnCriarGaleria').attr('disabled', 'disabled');
                $('#btnCriarGaleria').text('Salvando...');

            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarGalerias();

                $('#btnCriarGaleria').attr('disabled', false);
                $('#btnCriarGaleria').text('Salvar');

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnCriarGaleria').attr('disabled', false);
                $('#btnCriarGaleria').text('Salvar');
            }
        });
    });

    $('#formDataAddFotosAlbum').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_add_foto_galeria.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

                $('#btnSendGaleria').attr('disabled', 'disabled');
                $('#btnSendGaleria').text('Salvando...');

            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSendGaleria').attr('disabled', false);
                $('#btnSendGaleria').text('Salvar');

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendGaleria').attr('disabled', false);
                $('#btnSendGaleria').text('Salvar');
            }
        });
    });

    $('#formDataLinkUteis').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_links_uteis.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendLink').attr('disabled', 'disabled');
                $('#btnSendLink').text('Salvando link...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarLinksUteis();

                $('#btnSendLink').attr('disabled', false);
                $('#btnSendLink').text('salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendLink').attr('disabled', false);
                $('#btnSendLink').text('salvar');
            }
        });
    });

    $('#formDataMissaVisaoValores').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_missao_visao_valores.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSend').attr('disabled', 'disabled');
                $('#btnSend').text('Salvando...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                $('#btnSend').attr('disabled', false);
                $('#btnSend').text('salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSend').attr('disabled', false);
                $('#btnSend').text('salvar');
            }
        });
    });

    $('#formDataOrganograma').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_organograma.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSendOrgan').attr('disabled', 'disabled');
                $('#btnSendOrgan').text('Salvando imagem...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                listarOrganograma();

                $('#btnSendOrgan').attr('disabled', false);
                $('#btnSendOrgan').text('Salvar');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSendOrgan').attr('disabled', false);
                $('#btnSendOrgan').text('Salvar');
            }
        });
    });

    $('#formDataBpa').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_rel_bpa.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#sendBPA').attr('disabled', 'disabled');
                $('#sendBPA').text('Salvando aguarde...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 2000
                });

                loadRelBpa();

                $('#sendBPA').attr('disabled', false);
                $('#sendBPA').text('salvar');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#sendBPA').attr('disabled', false);
                $('#sendBPA').text('salvar');
            }
        });
    });

    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

    /*$('.filter-container').filterizr({ gutterPixels: 3 });
    $('.btn[data-filter]').on('click', function () {
        $('.btn[data-filter]').removeClass('active');
        $(this).addClass('active');
    }); */

});

function loadFaq() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-faq.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('load-faq');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image, index) => {

                // HTML da li
                list.innerHTML += `  
                    
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${image.pergunta}</td>
                        <td>${image.resposta}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="apagarFaq(${image.id})">Apagar</button>
                        </td>
                    </tr>
                    
                `;
            });
        })
        .catch(error => console.error('Erro ao listar faq:', error));
}

if (document.getElementById('load-faq')) {
    loadFaq();
}

function apagarFaq(id) {
  Swal.fire({
    title: "Deseja excluir este registro?",
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: "Apagar",
    denyButtonText: `Don't save`
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {

      fetch('apagar/processa/proc_del_faq.php', {
        method: 'POST', // Define o método HTTP como POST
        headers: {
          'Content-Type': 'application/json' // Especifica o tipo de conteúdo enviado
        },
        body: JSON.stringify({ // Converte o objeto para JSON
          id: id
        })
      })
        .then(response => response.json()) // Converte a resposta para JSON
        .then(data => {

          loadFaq();

          Swal.fire({
            position: "center",
            icon: data.tipo,
            title: data.titulo,
            text: data.msg,
            showConfirmButton: false,
            timer: 2500
          });

        }) // Manipula os dados retornados
        .catch(error => {

          Swal.fire({
            position: "center",
            icon: "error",
            title: "Ops...",
            text: error,
            showConfirmButton: false,
            timer: 2500
          });

        }); // Trata erros

    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
}

function apagarSimulacao(id) {
  Swal.fire({
    title: "Deseja excluir este registro?",
    showDenyButton: false,
    showCancelButton: true,
    confirmButtonText: "Apagar",
    denyButtonText: `Don't save`
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {

      fetch('apagar/processa/proc_del_simulacao.php', {
        method: 'POST', // Define o método HTTP como POST
        headers: {
          'Content-Type': 'application/json' // Especifica o tipo de conteúdo enviado
        },
        body: JSON.stringify({ // Converte o objeto para JSON
          id: id
        })
      })
        .then(response => response.json()) // Converte a resposta para JSON
        .then(data => {

          loadSimulacao();

          Swal.fire({
            position: "center",
            icon: data.tipo,
            title: data.titulo,
            text: data.msg,
            showConfirmButton: false,
            timer: 2500
          });

        }) // Manipula os dados retornados
        .catch(error => {

          Swal.fire({
            position: "center",
            icon: "error",
            title: "Ops...",
            text: error,
            showConfirmButton: false,
            timer: 2500
          });

        }); // Trata erros

    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
}

function marcarComoRecebido(id) {
  Swal.fire({
    title: "Deseja adicionar uma observação?",
    input: "text",
    inputAttributes: {
      autocapitalize: "off"
    },
    showCancelButton: true,
    confirmButtonText: "Marcar",
    showLoaderOnConfirm: true,
    preConfirm: async (message) => {

      try {
        const response = await fetch("editar/processa/proc_marcar_recebida.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `id=${encodeURIComponent(id)}&message=${encodeURIComponent(message)}`
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
          throw new Error(data.message || "Erro ao atualizar simulação.");
        }

        loadSimulacao();

        return data;
      } catch (error) {
        Swal.showValidationMessage(`Erro: ${error.message}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Sucesso!",
        text: "Simulação recebida com sucesso",
        icon: "success"
      });
    }
  });
}


function loadSimulacao() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-simulacao.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('load-simulacao');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image, index) => {

                // HTML da li
                list.innerHTML += `  
                    
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>
                            ${image.nomeEmpresa} <br>
                            <small>CNPJ: ${image.cnpj}</small>
                        </td>
                        <td>${image.email}</td>
                        <td>
                            ${image.nomeContato} <br>
                            <small><i class="fa fa-mobile" aria-hidden="true"></i> ${image.telefone}</small>
                        </td>
                        <td>${image.criado}</td>
                        <td>
                            <div class="btn-group dropleft">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Menu
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#visuSimu${image.id}">Visualizar</a>
                                    <a class="dropdown-item" href="#" onclick="marcarComoRecebido(${image.id})">Marcar como recebido</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="apagarSimulacao(${image.id})">Excluir</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="visuSimu${image.id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Visualizar dados</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <dl class="row">
                                        <dt class="col-sm-3">Cidade</dt>
                                        <dd class="col-sm-9">${image.cidade}</dd>

                                        <dt class="col-sm-3">Possui assistência médica?</dt>
                                        <dd class="col-sm-9">${image.ass_medica}</dd>

                                        <dt class="col-sm-3">Sexo</dt>
                                        <dd class="col-sm-9">${image.sexo}</dd>

                                        <dt class="col-sm-3">Faixa Etária</dt>
                                        <dd class="col-sm-9">${image.faixaEtaria}</dd>

                                        <dt class="col-sm-3">Quantidade</dt>
                                        <dd class="col-sm-9">${image.qtd}</dd>
                                    </dl>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                `;
            });
        })
        .catch(error => console.error('Erro ao listar simulação:', error));
}

if (document.getElementById('load-simulacao')) {
    loadSimulacao();
}

function listarOrganograma() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-organograma.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-organograma');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image, index) => {

                // HTML da li
                list.innerHTML += `  
                    
                    <tr>
                        <th scope="row">${index}</th>
                        <td>${image.nome}</td>
                        <td>${image.criado}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#visuOrga${image.id}">Visualizar</button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#conf_exclusao${image.id}">Apagar</button>
                        </td>
                    </tr>

                    <div class="modal fade" id="visuOrga${image.id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Organograma</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="${image.arquivo}" class="rounded mx-auto d-block" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="conf_exclusao${image.id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Deseja excluir este registro?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirOrganograma(${image.id})">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                `;
            });
        })
        .catch(error => console.error('Erro ao listar imagens:', error));
}

// Função para buscar e listar imagens do totem no MySQL
function listarBanners() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-banners.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-banners');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                const li = document.createElement('li');
                li.dataset.id = image.id; // Adicione o ID da imagem como atributo de dados

                // HTML da li
                li.innerHTML = `                   

                    <div class="media d-flex align-items-center">
                        <span class="handle ui-sortable-handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <img src="${image.url}" alt="${image.titulo}" width="150" height="auto">
                   
                        <div class="media-body ml-3">
                            <h5 class="mt-0">${image.titulo}</h5>
                            <p class="">
                                <i class="fa fa-university" aria-hidden="true"></i> ${image.unidade} <br>
                                <i class="fa fa-calendar" aria-hidden="true"></i> ${image.inicio} - ${image.fim}
                            </p> 
                            <p class="">
                                ${image.obs}
                            </p> 
                            <button type="button" class="btn btn-danger btn-sm" onclick="delBanner(${image.id})"><i class="fa fa-trash-o"></i></button>
                            
                        </div>
                    </div>
                    
                `;

                list.appendChild(li);
            });
        })
        .catch(error => console.error('Erro ao listar imagens:', error));
}

function listarFaleConosco() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-fale-conosco.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-fale-conosco');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image, index) => {

                // HTML da li
                list.innerHTML += ` 
                
                    <tr>
                        <th scope="row">${index}</th>
                        <td>${image.autor} <br> ${image.email}</td>
                        <td>${image.assunto}</td>
                        <td>${image.criado}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#abrirMsg${image.id}">Visualizar</button>    
                        </td>
                    </tr> 
                    
                    <div class="modal fade" id="abrirMsg${image.id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Mensagem</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ${image.mensagem}
                            </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => console.error('Erro ao listar mensagens:', error));
}

function listarLinksUteis() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-links-uteis.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-links');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image, index) => {

                // HTML da li
                list.innerHTML += ` 
                
                    <tr>
                        <th scope="row">${index}</th>
                        <td>${image.nome}</td>
                        <td>${image.link}</td>
                        <td>${image.criado}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="apagarLinksUteis(${image.id})">Excluir</button>    
                        </td>
                    </tr>                    
                `;
            });
        })
        .catch(error => console.error('Erro ao listar links:', error));
}

function listarBannerSobre() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-banners-sobre.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-sobre-img');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                const li = document.createElement('li');
                li.dataset.id = image.id; // Adicione o ID da imagem como atributo de dados

                // HTML da li
                li.innerHTML = `                   

                    <div class="media d-flex align-items-center">
                        <span class="handle ui-sortable-handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <img src="${image.url}" alt="${image.titulo}" class="img-fluid" width="150" height="auto">
                   
                        <div class="media-body ml-3">
                            <h5 class="mt-0">${image.titulo}</h5>
                            <p class="">
                                <i class="fa fa-calendar" aria-hidden="true"></i> ${image.criado}
                            </p> 
                            <p class="">
                                ${image.obs}
                            </p> 
                            <button type="button" class="btn btn-danger btn-sm" onclick="delBannerSobre(${image.id})"><i class="fa fa-trash-o"></i></button>
                            
                        </div>
                    </div>
                    
                `;

                list.appendChild(li);
            });
        })
        .catch(error => console.error('Erro ao listar imagens:', error));
}

function listarGaleria(id) {
    // Chamada AJAX para buscar as imagens
    fetch('../consultas/get-galeria.php?id=' + id) // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-galeria');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 
                
                    <div class="col-sm-2">
                        <a href="${image.url}" data-toggle="lightbox" data-title="${image.nome}" data-gallery="gallery">
                            <img src="${image.url}" class="img-fluid mb-2" alt="${image.nome}" />
                        </a>
                        <button type="button" class="btn btn-danger btn-sm btn-block" onclick="mdApagarGaleria(${image.id}, ${id})">Excluir</button>
                    </div>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar imagens:', error));
}

function apagarLinksUteis(id) {

    $.ajax({
        url: "apagar/processa/proc_del_links_uteis.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarLinksUteis();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });

}

function excluirOrganograma(id) {

    $.ajax({
        url: "apagar/processa/proc_del_organograma.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarOrganograma();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });

}

function excluirRelBpa(id) {

    $.ajax({
        url: "apagar/processa/proc_del_rel_bpa.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                $("#conf_exclusao"+id).modal("hide");

                loadRelBpa();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
    
}

function delBanner(id) {

    $.ajax({
        url: "apagar/processa/proc_del_banner.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarBanners();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });

}

function delBannerSobre(id) {

    $.ajax({
        url: "apagar/processa/proc_del_banner_sobre.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarBannerSobre();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });

}

// Função para buscar e listar imagens do totem no MySQL
function loadTableDataDestaque() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-destaques.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {

            document.querySelector('#list-destaques').innerHTML = '';

            data.forEach((rowData, index) => {
                createDynamicRow(rowData, index + 1); // Chama a função para criar a linha, passando os dados e o índice
            });

        })
        .catch(error => console.error('Erro ao listar tabela:', error));
}

function createDynamicRow(rowData, rowIndex) {

    // Cria o elemento <tr>
    const trElement = document.createElement('tr');

    // Array de dados da linha extraídos do MySQL
    const values = [rowIndex, rowData.titulo, rowData.inicio, rowData.fim, rowData.criado];

    // Loop para criar e adicionar as células <td> e <th> com os dados do MySQL
    values.forEach((data, index) => {
        let cellElement;
        if (index === 0) { // Se for o índice (primeira célula), cria um <th>
            cellElement = document.createElement('th');
            cellElement.setAttribute('scope', 'row');
        } else { // Para as outras células, cria um <td>
            cellElement = document.createElement('td');
        }
        cellElement.textContent = data; // Define o texto da célula
        trElement.appendChild(cellElement); // Adiciona a célula à linha <tr>
    });

    // Cria a última célula para os botões
    const buttonCell = document.createElement('td');

    // Botão de edição
    const editButton = document.createElement('button');
    editButton.type = 'button';
    editButton.classList.add('btn', 'btn-primary', 'btn-sm');
    editButton.setAttribute('onclick', `mdEditarDestaque(${rowData.id})`); // Passa o ID do registro ao clicar

    const editIcon = document.createElement('i');
    editIcon.classList.add('fa', 'fa-pencil-square-o');
    editIcon.setAttribute('aria-hidden', 'true');

    editButton.appendChild(editIcon);
    buttonCell.appendChild(editButton);

    // Adiciona um espaço entre os botões
    buttonCell.appendChild(document.createTextNode(' '));

    // Botão de apagar
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('btn', 'btn-primary', 'btn-sm');
    deleteButton.setAttribute('onclick', `mdApagarDestaque(${rowData.id})`); // Passa o ID do registro ao clicar

    const deleteIcon = document.createElement('i');
    deleteIcon.classList.add('fa', 'fa-times');
    deleteIcon.setAttribute('aria-hidden', 'true');

    deleteButton.appendChild(deleteIcon);
    buttonCell.appendChild(deleteButton);

    // Adiciona a célula de botões à linha <tr>
    trElement.appendChild(buttonCell);

    // Insere a linha na tabela (use o ID ou seletor apropriado)
    document.querySelector('#list-destaques').appendChild(trElement); // Substitua 'tbody' pelo seletor do seu tbody
}

let btnBanners = document.getElementById("custom-content-below-img-tab");
let btnDestaques = document.getElementById("custom-content-below-meus-destaque-tab");

if (document.getElementById("custom-content-below-img-tab")) {
    btnBanners.addEventListener("click", listarBanners);
}

if (document.getElementById("custom-content-below-meus-destaque-tab")) {
    btnDestaques.addEventListener("click", loadTableDataDestaque);
}

function mdEditarDestaque(id) {

    $.ajax({
        url: "consultas/get_destaque.php",
        method: "GET",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {

            if (retorno.status) {

                $('#edit_titulo').val(retorno.titulo);
                //$('#edit_dt_inicio').val(retorno.dtInicio);
                //$('#edit_dt_fim').val(retorno.dtFim);
                $('#edit_desc').summernote('code', retorno.descricao);
                //$('#edit_desc').val(retorno.descricao);
                $('#idpubdestaque').val(retorno.id);

                $("#mdEditarDestaque").modal("show");

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Ops...",
                    text: "Nenhum registro encontrado",
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function mdApagarDestaque(id) {

    $("#btnDelDestaque").attr("onclick", `apagarDestaque(${id})`);

    $("#mdApagarDestaque").modal("show");

}

function mdApagarGaleria(id, pub) {

    $("#btnDelImgGaleria").attr("onclick", `apagarGaleria(${id}, ${pub})`);

    $("#excluirImgGaleria").modal("show");
}

function apagarGaleria(id, pub) {
    $.ajax({
        url: "../apagar/processa/proc_del_galeria.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarGaleria(pub);
                $("#excluirImgGaleria").modal("hide");

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function apagarDestaque(id) {
    $.ajax({
        url: "apagar/processa/proc_del_destaque.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                loadTableDataDestaque();
                $("#mdApagarDestaque").modal("hide");

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

// Função para buscar e listar sobre no MySQL
function loadDataSobre() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-sobre.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {

            $("#titulo").val(data.titulo);
            $('#sobre').summernote('code', data.sobre);
            $("#resumo").val(data.resumo);

        })
        .catch(error => console.error('Erro ao listar tabela:', error));
}

if (document.getElementById("custom-content-below-noticias-tab")) {
    document.getElementById("custom-content-below-noticias-tab").addEventListener("click", listarPublicados);
}

function listarPublicados() {
    var searchQuery = document.getElementById('search_pub').value;

    fetch('consultas/get-publicacoes.php?search=' + searchQuery)
        .then(response => response.json())
        .then(data => {
            var tableBody = document.getElementById('listar-publicacoes');
            tableBody.innerHTML = '';

            data.forEach(function (registro) {
                var row = '<tr>' +
                    '<td>' +
                    '<ul class="list-inline">' +
                    '<li class="list-inline-item">' +
                    '<img alt="Avatar" class="table-avatar" src="' + registro.capa + '">' +
                    '</li>' +
                    '</ul>' +
                    '</td>' +
                    '<td>' +
                    '<a>'
                    + registro.titulo +
                    '</a> <br>' +

                    '<small>' +
                    'Cadastrado: ' + registro.criado +
                    '</small>' +
                    '</td>' +
                    '<td>' + registro.user + '</td>' +
                    '<td class="project_progress">' + registro.categoria + '</td>' +
                    '<td class="project-state">' + registro.status + '</td>' +
                    '<td class="project-actions text-right">' +
                    '<a class="btn btn-primary btn-sm mr-2" href="' + registro.url + '/pages/modulo/administracao-do-site/visualizar/publicacao?id=' + registro.id + '"><i class="fa fa-folder"></i> </a>' +
                    '<a class="btn btn-info btn-sm mr-2" href="' + registro.url + '/pages/modulo/administracao-do-site/editar/edit_publicacao?id=' + registro.id + '"><i class="fa fa-pencil"></i> </a>' +
                    '<a class="btn btn-danger btn-sm" href="#" onclick="mdApagarPub(' + registro.id + ')"> <i class="fa fa-trash"></i> </a>' +
                    '</td>' +
                    '</tr>';
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Erro ao buscar os registros:', error));
}

// Chama a função listarRegistros ao carregar a página
if (document.getElementById('listar-publicacoes')) {
    document.addEventListener('DOMContentLoaded', listarPublicados);
}

function mdApagarPub(pub_id) {

    $("#btnDelPub").attr("onclick", "apagarPub(" + pub_id + ")");
    $("#delPub").modal("show");

}

function apagarPub(pub_id) {
    $.ajax({
        url: "apagar/processa/proc_del_pub.php",
        method: "POST",
        data: {
            id: pub_id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarPublicados();
                $("#delPub").modal("hide");

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}
if (document.getElementById('mdShowCategoria')) {
    document.getElementById('mdShowCategoria').addEventListener('click', listarCategorias);   
}

function listarCategorias() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-md-categorias.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-categorias');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 
                
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="categoria[${image.id}]" id="categ-${image.id}" value="${image.text}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-sm" onclick="salvarAlteracoesCategoria()">Alterar</button>
                        </div>
                    </div>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar categorias:', error));
}

function salvarAlteracoesCategoria() {
    // Capturar todos os inputs dentro do formulário
    var form = document.getElementById('list-categorias');
    var formData = new FormData(form);

    // Enviar os dados via AJAX para o PHP salvar no banco de dados
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'editar/processa/proc_edit_categoria.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            //alert('Alterações salvas com sucesso!');
            Swal.fire({
                icon: "success",
                title: "Sucesso",
                text: "Alterações salvas com sucesso!",
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            //alert('Erro ao salvar alterações.');
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: "Erro ao salvar alterações.",
                showConfirmButton: false,
                timer: 2000
            });
        }
    };
    xhr.send(formData);
}

function listarCeo() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-ceo.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-ceo');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>${image.nome}</b></h2>
                                        <p class="text-muted text-sm"><b>${image.descricao} </b> </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-calendar"></i></span> Data inicio: ${image.data1}</li>
                                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-calendar"></i></span> Data fim: ${image.data2}</li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="${image.foto}" alt="user-avatar" class="img-circle img-fluid" width="100">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="editar/edit_ceo?id=${image.id}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-pencil-square-o"></i> Editar dados
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar categorias:', error));
}

function listarParceiros() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-parceiros.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-parceiros');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                ${image.nome}
                            </a>
                            <br>
                            <small>
                                Link: ${image.link}
                            </small>
                        </td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="${image.foto}">
                                </li>
                            </ul>
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarParceiro(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar categorias:', error));
}

function listarDepoimentos() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-depoimentos.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('listar-depoimentos');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="${image.foto}">
                                </li>
                            </ul>
                        </td>
                        <td>
                            <a>
                                ${image.nome}
                            </a>
                            <br>
                            <small>
                                ${image.cargoFuncao}
                            </small>
                        </td>
                        
                        <td class="project-state">
                            ${image.registrado}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#viewDepo-${image.id}">
                                <i class="fa fa-folder"></i>
                                View
                            </a>
                            <a class="btn btn-info btn-sm" href="editar/edit_depoimento?id=${image.id}">
                                <i class="fa fa-pencil"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarDepoimento(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="viewDepo-${image.id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Visualizar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ${image.texto}
                            </div>
                            </div>
                        </div>
                    </div>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar categorias:', error));
}

function apagarDepoimento(id) {
    $.ajax({
        url: "apagar/processa/proc_del_depoimento.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.tipo == "success") {

                listarDepoimentos();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function apagarParceiro(id) {
    $.ajax({
        url: "apagar/processa/proc_del_parceiro.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarParceiros();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function listarAds01() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-ads01.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-ads01');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                ${image.nome}
                            </a>
                            <br>
                            <small>
                                Link: <a href="${image.link}" target="_blank">${image.link}</a>
                            </small>
                        </td>
                        <td>
                            ${image.criado}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarAds(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar ads:', error));
}

function listarAds02() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-ads02.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-ads02');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                ${image.nome}
                            </a>
                            <br>
                            <small>
                                Link: <a href="${image.link}" target="_blank">${image.link}</a>
                            </small>
                        </td>
                        <td>
                            ${image.criado}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarAds(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar ads:', error));
}

function listarAds03() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-ads03.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-ads03');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                ${image.nome}
                            </a>
                            <br>
                            <small>
                                Link: <a href="${image.link}" target="_blank">${image.link}</a>
                            </small>
                        </td>
                        <td>
                            ${image.criado}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarAds(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar ads:', error));
}

function apagarAds(id) {
    $.ajax({
        url: "apagar/processa/proc_del_ads.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarAds01();
                listarAds02();
                listarAds03();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function listarVideos() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-videos.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-videos');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += ` 

                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                ${image.url}
                            </a>
                        </td>
                        <td>
                            ${image.criado}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="${image.url}" target="_blank">
                                <i class="fa fa-television">
                                </i>
                                Assistir
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" onclick="apagarVideo(${image.id})">
                                <i class="fa fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar videos:', error));
}

function apagarVideo(id) {
    $.ajax({
        url: "apagar/processa/proc_del_video.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                listarVideos();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

function listarGalerias() {
    // Chamada AJAX para buscar as imagens
    fetch('consultas/get-galerias.php') // Altere para o caminho correto do seu arquivo PHP
        .then(response => response.json()) // Supondo que o retorno seja um JSON
        .then(data => {
            const list = document.getElementById('list-galerias');
            list.innerHTML = ''; // Limpa a lista antes de preencher

            data.forEach((image) => {
                // HTML da li
                list.innerHTML += `

                    <div class="col-md-4 col-lg-4 col-xl-2">
                        <a href="#" onclick="listarFotosAlbuns(${image.id})">
                            <div class="card mb-2 bg-gradient-dark">
                                <img class="card-img-top img-fluid d-block" src="${image.img}" alt="Album">
                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <h5 class="card-title text-primary text-white">${image.album}</h5>
                                    <p class="card-text text-white pb-2 pt-1">${image.descricao}</p>
                                    <span class="text-white">${image.criado}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                `;

            });
        })
        .catch(error => console.error('Erro ao listar galerias:', error));
}

function listarFotosAlbuns(album) {

    $.ajax({
        url: "consultas/get-fotos-albuns.php",
        method: "GET",
        data: {
            id: album
        },
        dataType: "json",
        success: function (response) {

            if (response.length > 0) {

                let resultadoHtml = "";
                response.forEach(item => {
                    resultadoHtml += `<div class="product-image-thumb" onclick="mdDeletarFotoAlbum(${album},${item.id})"><img src="${item.img}" alt="${item.slug}"></div>`;
                });
                
                $('#resultadoBody').html(resultadoHtml);
                $('#resultadoModal').modal('show');
                $('#btnCadFoto').attr('onclick', `mdAddFotoAlbum(${album})`);

            } else {
                
                Swal.fire({
                    icon: "info",
                    title: "Ops...",
                    text: "Nenhum resultado encontrado.",
                    showConfirmButton: false,
                    timer: 2000
                });
            }

        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
    
}

function mdDeletarFotoAlbum(album, id) {

    $('#resultadoModal').modal('hide');
    $('#btnSendExcluirFoto').attr('onclick', `deletarFotoAlbum(${album},${id})`);
    $('#mdDel').modal('show');
    
}

function mdAddFotoAlbum(album) {

    $('#resultadoModal').modal('hide');
    $('#album').val(album);
    $('#addFotos').modal('show');
    
}

function deletarFotoAlbum(album, id) {
    $.ajax({
        url: "apagar/processa/proc_del_foto_album.php",
        method: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (retorno) {


            if (retorno.success) {

                $('#mdDel').modal('hide');

                listarFotosAlbuns(album);

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: 'Registro excluido com sucesso!',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                //alert('Falha ao atualizar a ordem');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: 'Falha ao excluir registro',
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}