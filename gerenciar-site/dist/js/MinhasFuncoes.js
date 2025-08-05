var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});


// Obtém o domínio da URL
var dominio = window.location.hostname;
// Obtendo o protocolo
var protocolo = window.location.protocol;
// Obtém a pasta raiz da URL
if (dominio == "localhost") {
    var pastaRaiz = "/landing-page-unimedrb/gerenciar-site/";
} else {
    var pastaRaiz = "/";
}


var data = new Date();
var dia = String(data.getDate()).padStart(2, '0');
var mes = String(data.getMonth() + 1).padStart(2, '0');
var ano = data.getFullYear();
dataAtual = dia + '/' + mes + '/' + ano;
anoAtual = ano;

$(document).ready(function () {

    //Exibir modal com msg de retono    
    $('#procmsg').modal('show');
    //Consultar situação da senha do usuário logado
    $.ajax({ // ajax
        url: pastaRaiz + "pages/modulo/controle_de_acesso/consultas/cons_noti_senha.php",
        dataType: "json",
        success: function (dado) {
            Swal.fire({
                icon: 'info',
                title: 'Sua senha irá expirar em ' + dado.dias + ' dias, clique para alterá-la',
                confirmButtonText: 'Atualizar',
                position: 'bottom',
                toast: true,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    //abrir modal de troca de senha
                    $("#alterarSenhaExpUsuário").modal("show");
                }
            });
        }
    });
});

/**
* Função para criar um objeto XMLHTTPRequest
*/
function CriaRequest() {
    try {
        request = new XMLHttpRequest();
    } catch (IEAtual) {

        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (IEAntigo) {

            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (falha) {
                request = false;
            }
        }
    }

    if (!request)
        alert("Seu Navegador não suporta Ajax!");
    else
        return request;
}

/**
* Função para enviar os dados
*/
function PesquisarUsuario(dados_usuario) {

    // Declaração de Variáveis
    //var dados_usuario      = document.getElementById("dados_usuario").value;
    var resultado_usuario = document.getElementById("resultado_usuario");
    var xmlreq = CriaRequest();

    // Exibi a imagem de progresso
    resultado_usuario.innerHTML = '<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</div>';

    // Iniciar uma requisição
    xmlreq.open("GET", "consultas/cons_usuario.php?dados_usuario=" + dados_usuario, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                resultado_usuario.innerHTML = xmlreq.responseText;
            } else {
                resultado_usuario.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

//Metodo de chamada: onblur="formatanome(this.value)"
function formatanome(nome) {
    var casetxt = nome;

    casetxt = nome.toLowerCase().replace(/(?:^|\s)\S/g, function (capitalize) { return capitalize.toUpperCase(); });

    var PreposM = ["Da", "Do", "Das", "Dos", "A", "E"];
    var prepos = ["da", "do", "das", "dos", "a", "e"];

    for (var i = PreposM.length - 1; i >= 0; i--) {
        casetxt = casetxt.replace(RegExp("\\b" + PreposM[i].replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + "\\b", "g"), prepos[i]);
    }

    var retorno = document.getElementsByClassName("textcase");
    retorno[0].value = casetxt;
}

//Metodo de chamada: oninput="upperCase(event)"
function upperCase(e) {
    var ss = e.target.selectionStart;
    var se = e.target.selectionEnd;
    e.target.value = e.target.value.toUpperCase();
    e.target.selectionStart = ss;
    e.target.selectionEnd = se;
}
//Metodo de chamada: onkeypress="return somenteNumeros(event)"
function somenteNumeros(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    // charCode 8 = backspace   
    // charCode 9 = tab
    if (charCode != 8 && charCode != 9) {
        // charCode 48 equivale a 0   
        // charCode 57 equivale a 9
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#dashPesEmquete').on('submit', function (event) {
        event.preventDefault();

        var dtinicio = document.getElementById("dtinicio").value;
        var dtfim = document.getElementById("dtfim").value;

        graficoEnquete(dtinicio, dtfim);
    });

    $('#nova_senha_exp').on('submit', function (event) {
        event.preventDefault();
        var dados = $("#nova_senha_exp").serialize();

        $.ajax({
            url: pastaRaiz + "pages/modulo/meu_perfil/processa/proc_altera_senha.php",
            method: "POST",
            data: dados,
            dataType: "json",
            //cache:false,
            //processData:false,
            beforeSend: function () {
                $('#SendUpSenha').attr('disabled', 'disabled');
                $('#SendUpSenha').val('Validando...');
            },
            success: function (retorno) {
                //Notificação
                if (retorno.tipo == "success") {
                    //Fechar modal
                    $("#alterarSenhaExpUsuário").modal("hide");

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
                        showConfirmButton: false,
                        timer: 2500
                    });
                }

                $('#nova_senha_exp')[0].reset();
                $('#SendUpSenha').attr('disabled', false);
                $('#SendUpSenha').val('Alterar senha');
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
    });

    // CodeMirror
    if (document.getElementById("codeMirrorDemo")) {
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
    }

    // Summernote
    $('#summernote').summernote({
        tabsize: 2,
        height: 100,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']]
        ]
    });

    $('.pub-destaque').summernote({
        tabsize: 2,
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['fullscreen']]
        ]
    });

    $('.summernote').summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
            ['font', ['strikethrough', 'superscript', 'subscript', 'bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']]
        ]
    });

    $('.artigo-bc').summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
            ['font', ['strikethrough', 'superscript', 'subscript', 'bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['height', ['height']],
            ['view', ['fullscreen']]
        ]
    });

    $('.informativo').summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'style']],
            ['font', ['strikethrough', 'superscript', 'subscript', 'bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['height', ['height']],
            ['view', ['fullscreen']]
        ]
    });

    $("#tbcargos").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    window.location.href = "../../../pages/modulo/controle_de_acesso/cadastrar/cad_cargo";
                }
            }]
    }).buttons().container().appendTo('#tbcargos_wrapper .col-md-6:eq(0)');

    $("#tbdepartamento").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    window.location.href = "../../../pages/modulo/controle_de_acesso/cadastrar/cad_departamento";
                }
            }]
    }).buttons().container().appendTo('#tbdepartamento_wrapper .col-md-6:eq(0)');

    $("#tbgrupos").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    window.location.href = "../../../pages/modulo/controle_de_acesso/cadastrar/cad_grupo";
                }
            }]
    }).buttons().container().appendTo('#tbgrupos_wrapper .col-md-6:eq(0)');

    $("#tbperfisacesso").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    window.location.href = "../../../pages/modulo/controle_de_acesso/cadastrar/cad_permissao";
                }
            }]
    }).buttons().container().appendTo('#tbperfisacesso_wrapper .col-md-6:eq(0)');

    $("#tbunidade").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    window.location.href = "../../../pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
                }
            }]
    }).buttons().container().appendTo('#tbunidade_wrapper .col-md-6:eq(0)');

    $("#tbPermissoes").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#tbPermissoes_wrapper .col-md-6:eq(0)');

    $("#moduloSys").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    $('#cadModulo').modal('show');
                }
            }]
    }).buttons().container().appendTo('#moduloSys_wrapper .col-md-6:eq(0)');

    $("#operacoesSys").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    $('#cadOperacao').modal('show');
                }
            }]
    }).buttons().container().appendTo('#operacoesSys_wrapper .col-md-6:eq(0)');

    $("#contratos").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
            {
                text: 'Novo',
                action: function (e, dt, node, config) {
                    location.replace("../../../pages/modulo/sistema/cadastrar/cad_contrato");
                }
            }]
    }).buttons().container().appendTo('#contratos_wrapper .col-md-6:eq(0)');

    //Initialize Select2 Elements
    $('.select2').select2();

    $('.trumbowyg-pub').trumbowyg({
        lang: "pt-br",
        removeformatPasted: true,
        btnsDef: {
            // Create a new dropdown
            image: {
                dropdown: ['insertImage', 'base64', 'upload', 'noembed'],
                ico: 'insertImage'
            }
        },
        // Redefine the button pane
        btns: [
            ['viewHTML'],
            ['insertAudio'],
            ['historyUndo', 'historyRedo'],
            ['fontfamily'],
            ['fontsize'],
            ['foreColor', 'backColor'],
            ['highlight'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['image'], // Our fresh created dropdown
            // ['upload'],
            ['table', 'tableCellBackgroundColor', 'tableBorderColor'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['lineheight'],
            ['horizontalRule'],
            ['removeformat'],
            ['emoji'],
            ['fullscreen']
        ],
        plugins: {
            fontsize: {
                sizeList: [
                    //'5px',
                    //'7px',
                    //'8px',
                    '10px',
                    '12px',
                    '14px',
                    '16px',
                    '18px',
                    '20px',
                    '22px',
                    '24px',
                    '26px',
                    '28px',
                    '30px'
                ],
                allowCustomSize: true
            },
            lineheight: {
                sizeList: [
                    '14px',
                    '18px',
                    '22px'
                ]
            },
            resizimg: {
                minSize: 64,
                step: 16,
            },
            tagClasses: {
                table: 'table',
            },
            // Add imagur parameters to upload plugin for demo purposes
            upload: {
                serverPath: pastaRaiz + 'pm-access-adm/pages/modulo/administracao-do-site/upload.php',
                fileFieldName: 'image',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                urlPropertyName: 'file',
                success: function (data, trumbowyg, $modal, values) {
                    // Usa o texto alternativo (alt) que vem da modal
                    var altText = values.alt || '';

                    // Insere a imagem com a legenda formatada
                    var html = '<figure class="image-with-caption">' +
                        '<img src="' + data.file + '" alt="' + altText + '">' +
                        (altText ? '<figcaption>' + altText + '</figcaption>' : '') +
                        '</figure>';

                    trumbowyg.execCmd('insertHTML', html);
                },
                error: function () {
                    console.error('Erro no upload da imagem');
                }
            }
        }
    });


    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $("#money").maskMoney({ prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
    //CNPJ
    $('#cnpj').inputmask({
        mask: ['99999999999999'],
        keepStatic: true
    });
    //Telefone
    $('.tel').inputmask({
        mask: ['(99)99999-9999'],
        keepStatic: true
    });
    //Money Euro
    $('[data-mask]').inputmask();

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY hh:mm A'
        }
    });
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'LT'
    });

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox();

    //Colorpicker
    $('.my-colorpicker1').colorpicker();
    //color picker with addon
    $('.my-colorpicker2').colorpicker();

    $('.my-colorpicker2').on('colorpickerChange', function (event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
});
// BS-Stepper Init
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.bs-stepper')) {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    }
});

if (document.querySelector("#template-foto")) {

    // DropzoneJS Foto Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template-foto");

    previewNode.id = ""

    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone("#actions-foto", { // Make the whole body a dropzone
        url: "cadastrar/processa/upload_midias.php", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        paramName: "file", // Nome do parâmetro para o upload
        maxFiles: 100,
        acceptedFiles: "image/*",
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    })

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function () { myDropzone.enqueueFile(file) }
    })

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    // Captura o evento "sending" e adiciona campos extras ao envio
    myDropzone.on("sending", function (file, xhr, formData) {
        // Adiciona os dados do formulário que devem ser enviados junto com as imagens
        formData.append("legenda", document.getElementById("legenda").value);
        formData.append("post_id", post_id);
    });

    myDropzone.on("queuecomplete", function () {
        //alert("Formulário e imagens enviados com sucesso!");
        post_id = 0;

        Swal.fire({
            icon: "info",
            title: "Galeria gerada",
            text: "imagens enviados com sucesso!",
            showConfirmButton: false,
            timer: 2000
        });
        // Opcional: limpar o formulário e o Dropzone
        //document.getElementById('meuFormulario').reset();
        myDropzone.removeAllFiles(); // Limpar a área Dropzone após o upload
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.

    document.querySelector("#actions-foto .cancel").onclick = function () {
        myDropzone.removeAllFiles(true)
    }
}

// DropzoneJS Foto End
//Funções para buscar cep
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('uf').value = ("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        //alert("CEP não encontrado.");
        Swal.fire({
            icon: 'info',
            title: 'Oops...',
            text: 'CEP não encontrado.'
        });
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            //alert("Formato de CEP inválido.");
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Formato de CEP inválido.'
            });
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//Fim das Funções para buscar cep

//função para pegar o plano e preencher no select os modelos de planos no modulo sistema 
function Select_plano(valor) {
    if (valor) {
        $('#modelo_plano').hide();
        document.getElementById('valor_contrato').value = '';
        $.ajax({ // ajax
            url: "../../../../lib/lib_consultas.php?planoa=" + valor,
            dataType: "json",
            success: function (dado) {
                var options = '<option value="">Selecione um modelo</option>';
                for (var i = 0; dado.length > i; i++) {
                    options += '<option value="' + dado[i].idmodeloplano + '">' + dado[i].nome_mod_plano + '</option>';
                }
                $('#modelo_plano').html(options).show();
            }
        });
    } else {
        $('#modelo_plano').html('<option value="">Selecione um modelo</option>');
    }
};

function Select_valor_plano(id) {
    if (id) {
        $.ajax({ // ajax
            url: "../../../../lib/lib_consultas.php?planoa=" + id,
            dataType: "json",
            success: function (dado) {
                var valor_contrato = '';
                for (var i = 0; dado.length > i; i++) {
                    valor_contrato += dado[i].valor_plano;
                }
                document.getElementById('valor_contrato').value = valor_contrato;
            }
        });
    } else {
        $('#valor_contrato').hide();
    }
}

function closePrint() {
    document.body.removeChild(this.__container__);
}

function setPrint() {
    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
    this.contentWindow.focus(); // Required for IE
    this.contentWindow.print();
}

function imprimir() {
    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.border = "0";
    oHiddFrame.src = "print/print.php";
    document.body.appendChild(oHiddFrame);
}

function gerarRelatorio(relatorio) {
    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.border = "0";
    //Modelo de relatório
    if (relatorio == "Enquete") {
        var dataInicioEnquete = $("#dataInicioEnquete").val();
        var dataFimEnquete = $("#dataFimEnquete").val();
        var contrato = $("#contrato").val();
        var modelo = $("#modelo").val();

        if (dataInicioEnquete == "" || dataFimEnquete == "" || contrato == "" || modelo == "") {
            alert("Necessario preencher todos os campos");
        } else {
            //modelo de relatorio
            if (modelo == 1) {
                oHiddFrame.src = "relatorio/GerarEnquete.php?dtinicio=" + dataInicioEnquete + "&dtfim=" + dataFimEnquete + "&contrato=" + contrato;
                document.body.appendChild(oHiddFrame);
            } else if (modelo == 2) {
                oHiddFrame.src = "relatorio/GerarEnqueteDepoimento.php?dtinicio=" + dataInicioEnquete + "&dtfim=" + dataFimEnquete + "&contrato=" + contrato;
                document.body.appendChild(oHiddFrame);
            }
        }
    }

}

function graficoEnquete(dtinicio = '', dtfim = '') {
    $.ajax({
        method: "GET",
        url: 'relatorio/grafico_enquete.php?dt_inicio=' + dtinicio + '&dt_fim=' + dtfim,
        dataType: "json",
        success: function (data) {
            options_tma.series[0].data = data;
            new Highcharts.Chart('grafEnquete', options_tma);
            //console.log(data);
        }
    });

    var periodo;
    var inicio = dtinicio.split('-').reverse().join('/');
    var fim = dtfim.split('-').reverse().join('/');

    if (dtinicio == "" && dtfim == "") {
        periodo = 'Realizado em ' + dataAtual;
    } else {
        periodo = 'Realizado entre ' + inicio + ' à ' + fim;
    }

    options_tma = {
        chart: {
            type: 'bar'
        },
        colors: ['#28a745', '#007bff', '#17a2b8', '#ffc107', '#dc3545'],
        title: {
            text: 'Pesquisa de avaliação do sistema'
        },
        subtitle: {
            text: periodo
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Resultado da avaliação'
            }
        },
        legend: {
            enabled: true
        },
        tooltip: {
            pointFormat: 'Pontuação <b>{point.y} </b>'
        },
        series: [{
            name: 'Pontuação',
            data: [],
            dataLabels: {
                enabled: true,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    }
}