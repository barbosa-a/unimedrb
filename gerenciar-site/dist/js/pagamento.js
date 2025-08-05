$(function () {

    $('#formDataPayDebito').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_cartao.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnDebito').attr('disabled', 'disabled');
                $('#btnDebito').text('Aguarde...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                /*Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                }); */
                if (retorno.tipo == "success") {
                    toastr.success(retorno.msg);    
                } else {
                    toastr.error(retorno.msg);      
                }
                

                if (retorno.tipo == "success") {
                    stepper.next();    
                }


                $('#btnDebito').attr('disabled', false);
                $('#btnDebito').text('Salvar');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnDebito').attr('disabled', false);
                $('#btnDebito').text('Salvar');
            }
        });
    });

    $('#formDataPayCredito').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_cartao.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnCredito').attr('disabled', 'disabled');
                $('#btnCredito').text('Validando aguarde...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                /*Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                }); */
                if (retorno.tipo == "success") {
                    toastr.success(retorno.msg);    
                } else {
                    toastr.error(retorno.msg);      
                }
                

                if (retorno.tipo == "success") {
                    stepper.next();    
                }


                $('#btnCredito').attr('disabled', false);
                $('#btnCredito').text('Continuar');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnCredito').attr('disabled', false);
                $('#btnCredito').text('Continuar');
            }
        });
    });

    $('#formDataCartPlano').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_pay_plano.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnPayPlano').attr('disabled', 'disabled');
                $('#btnPayPlano').text('Validando aguarde...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                /*Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                }); */
                if (retorno.tipo == "success") {
                    toastr.success(retorno.msg);    
                } else {
                    toastr.error(retorno.msg);      
                }
                

                if (retorno.tipo == "success") {
                    stepper.next();    
                }


                $('#btnPayPlano').attr('disabled', false);
                $('#btnPayPlano').text('Continuar');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnPayPlano').attr('disabled', false);
                $('#btnPayPlano').text('Continuar');
            }
        });
    });

    $('#formDataPayEndereco').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "cadastrar/processa/proc_cad_pay_endereco.php",
            method: "POST",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnEndereco').attr('disabled', 'disabled');
                $('#btnEndereco').text('Validando aguarde...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                /*Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                }); */
                if (retorno.tipo == "success") {
                    toastr.success(retorno.msg);    
                } else {
                    toastr.error(retorno.msg);      
                }
                

                if (retorno.tipo == "success") {
                    stepper.next();    
                    resumo();
                }


                $('#btnEndereco').attr('disabled', false);
                $('#btnEndereco').text('Continuar');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnEndereco').attr('disabled', false);
                $('#btnEndereco').text('Continuar');
            }
        });
    });

    $("#btnPagarAgora").on("click", function () {
        $.ajax({
            url: "cadastrar/processa/proc_cad_pay.php",
            method: "POST",
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnPagarAgora').attr('disabled', 'disabled');
                $('#btnPagarAgora').text('Realizando pagamento...');
            },
            success: function (retorno) {
                //Notificação
                //$('#message_usuario').html(data);
                /*Swal.fire({
                    icon: retorno.tipo,
                    title: retorno.titulo,
                    text: retorno.msg,
                    showConfirmButton: false,
                    timer: 3000
                }); */
                if (retorno.tipo == "success") {
                    toastr.success(retorno.msg);    
                } else {
                    toastr.error(retorno.msg);      
                }
                

                if (retorno.tipo == "success") {
                    stepper.next();    
                }


                $('#btnPagarAgora').attr('disabled', false);
                $('#btnPagarAgora').text('Pagar agora');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Erro interno",
                    text: xhr.responseText,
                    showConfirmButton: true,
                    //timer: 2000
                });
                $('#btnPagarAgora').attr('disabled', false);
                $('#btnPagarAgora').text('Pagar agora');
            }
        });    
    });


});

function formPag(divId) {
    var divs = document.querySelectorAll('[id^="pay"]');
    divs.forEach(function (div) {
        if (div.id === divId) {
            div.classList.remove('hidden-pay');
        } else {
            div.classList.add('hidden-pay');
        }
    });
}

function resumo() {
    $.ajax({
        url: "consultar/resumo.php",
        method: "GET",
        //data: new FormData(this),
        dataType: "json",
        success: function (retorno) {
            document.getElementById("nomeResumo").innerHTML = retorno.nome;   
            document.getElementById("planoResumo").innerHTML = retorno.plano;   
            document.getElementById("valorResumo").innerHTML = retorno.valor;   
            document.getElementById("totalResumo").innerHTML = retorno.total;   
            document.getElementById("titularResumo").innerHTML = retorno.titular;   
            document.getElementById("numberResumo").innerHTML = retorno.number;  
            document.getElementById("valResumo").innerHTML = retorno.val;  
            document.getElementById("cvvResumo").innerHTML = retorno.cod;     
        },
        error: function (xhr) {
            Swal.fire({
                icon: "error",
                title: "Erro interno",
                text: xhr.responseText,
                showConfirmButton: true,
                //timer: 2000
            });
        }
    });
}