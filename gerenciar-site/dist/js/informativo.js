$(function () {
  $('#formDataInformativo').on('submit', function (event) {
    event.preventDefault();

    $.ajax({
      url: "../cadastrar/processa/proc_cad_informativo.php",
      method: "POST",
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $('#btnSendInformativo').attr('disabled', 'disabled');
        $('#btnSendInformativo').text('Aguarde...');
      },
      success: function (retorno) {
        //Notificação
        //$('#message_usuario').html(data);
        Swal.fire({
          icon: retorno.tipo,
          title: retorno.titulo,
          text: retorno.msg,
          showConfirmButton: false,
          timer: 3000
        });


        $('#btnSendInformativo').attr('disabled', false);
        $('#btnSendInformativo').text('Salvar');
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: "error",
          title: "Erro interno",
          text: xhr.responseText,
          showConfirmButton: true,
          //timer: 2000
        });
        $('#btnSendInformativo').attr('disabled', false);
        $('#btnSendInformativo').text('Salvar');
      }
    });
  });

  $('#formDataEditInformativo').on('submit', function (event) {
    event.preventDefault();

    $.ajax({
      url: "../editar/processa/proc_edit_informativo.php",
      method: "POST",
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $('#btnSendInformativo').attr('disabled', 'disabled');
        $('#btnSendInformativo').text('Aguarde...');
      },
      success: function (retorno) {
        //Notificação
        //$('#message_usuario').html(data);
        Swal.fire({
          icon: retorno.tipo,
          title: retorno.titulo,
          text: retorno.msg,
          showConfirmButton: false,
          timer: 3000
        });


        $('#btnSendInformativo').attr('disabled', false);
        $('#btnSendInformativo').text('Salvar');
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: "error",
          title: "Erro interno",
          text: xhr.responseText,
          showConfirmButton: true,
          //timer: 2000
        });
        $('#btnSendInformativo').attr('disabled', false);
        $('#btnSendInformativo').text('Salvar');
      }
    });
  });

  $('#formDataAnexo').on('submit', function (event) {
    event.preventDefault();

    $.ajax({
      url: "../cadastrar/processa/proc_cad_anexo.php",
      method: "POST",
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $('#btnAnexo').attr('disabled', 'disabled');
        $('#btnAnexo').text('Aguarde...');
      },
      success: function (retorno) {
        //Notificação
        //$('#message_usuario').html(data);

        if (retorno.tipo == "success") {
          $('#novoAnexo').modal('hide');  
          loadAnexos(retorno.info);
        }

        Swal.fire({
          icon: retorno.tipo,
          title: retorno.titulo,
          text: retorno.msg,
          showConfirmButton: false,
          timer: 3000
        });


        $('#btnAnexo').attr('disabled', false);
        $('#btnAnexo').text('Salvar');
      },
      error: function (xhr, status, error) {
        Swal.fire({
          icon: "error",
          title: "Erro interno",
          text: xhr.responseText,
          showConfirmButton: true,
          //timer: 2000
        });
        $('#btnAnexo').attr('disabled', false);
        $('#btnAnexo').text('Salvar');
      }
    });
  });

});


$("#btnNovaCategoria").click(function () {
  Swal.fire({
    title: 'Nova categoria',
    input: 'text',
    inputAttributes: {
      autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Salvar',
    showLoaderOnConfirm: true,
    preConfirm: (cat) => {
      return fetch('../cadastrar/processa/proc_cad_categoria.php', { // Altere para o caminho do seu arquivo PHP
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'categoria=' + encodeURIComponent(cat) // Enviar o nome de usuário como parâmetro
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText);
          }

          return response.json();
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          );
        });
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        icon: result.value.tipo,
        title: result.value.titulo,
        text: result.value.msg,
        timer: 1500
      });
      list_categorias_select();
    }
  });
});

function list_categorias_select() {

  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("categoria");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  //list.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';

  // Iniciar uma requisição
  xmlreq.open("GET", "../consultas/categorias_select.php", true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
}

if (document.getElementById("categoria")) {
  list_categorias_select();
}

function list_categorias_modal() {

  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("listCategorias");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';

  // Iniciar uma requisição
  xmlreq.open("GET", "../consultas/categorias_modal.php", true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
}

function editCategoriaModal(id, categoria) {

  $("#mdListCategorias").modal("hide");

  Swal.fire({
    title: 'Editar categoria',
    input: 'text',
    inputValue: categoria,
    inputAttributes: {
      autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Salvar',
    showLoaderOnConfirm: true,
    preConfirm: (cat) => {
      return fetch('../editar/processa/proc_edit_categoria.php', { // Altere para o caminho do seu arquivo PHP
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'categoria=' + encodeURIComponent(cat) + '&id=' + encodeURIComponent(id)// Enviar o nome de usuário como parâmetro
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText);
          }

          return response.json();
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          );
        });
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        icon: result.value.tipo,
        title: result.value.titulo,
        text: result.value.msg,
        timer: 1500
      });
      list_categorias_select();
      list_categorias_modal();
    }
  });
};

function delCategoriaModal(id, categoria) {
  Swal.fire({
    title: "Deseja excluir a categoria: " + categoria + "?",
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: "Excluir",
    denyButtonText: `Cancelar`
  }).then((result) => {

    if (result.isConfirmed) {

      fetch('../apagar/processa/proc_del_categoria.php', {
        method: 'POST', // especifica o método HTTP que você quer usar
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded', // define o tipo de conteúdo do corpo da solicitação
          // outras headers, se necessário
        },
        body: 'id=' + encodeURIComponent(id)
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erro na solicitação: ' + response.status);
          }
          return response.json(); // retorna uma Promise que resolve com o corpo da resposta convertido para JSON
        })
        .then(data => {
          // manipule os dados da resposta aqui
          Swal.fire({
            icon: data.tipo,
            title: data.titulo,
            text: data.msg,
            timer: 1500
          });
          list_categorias_select();
          list_categorias_modal();
        })
        .catch(error => {
          // manipule os erros de solicitação aqui
          //console.error('Houve um problema com a solicitação fetch:', error);
          Swal.fire("Houve um problema com a solicitação fetch:", error, "info");
        });

    } else if (result.isDenied) {
      Swal.fire("Operação cancelada", "", "info");
    }
  });
}

$("#table_search_postados").keyup(function () {
  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("tbPostados");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';

  // Iniciar uma requisição
  xmlreq.open("GET", "../consultas/postados.php?buscar=" + $(this).val(), true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
});

$("#custom-tabs-three-postados-tab").click(function () {
  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("tbPostados");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<tr class="text-center"><td colspan="5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';

  // Iniciar uma requisição
  xmlreq.open("GET", "../consultas/postados.php?buscar=' '", true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
});

function loadAnexos(info) {
  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("listAnexos");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<tr class="text-center"><td colspan="4"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Carregando...</td></tr>';

  // Iniciar uma requisição
  xmlreq.open("GET", "../consultas/anexos.php?informativo=" + info, true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
};

function delAqruivo(id) {

  $.ajax({
    url: "../apagar/processa/proc_del_anexo.php",
    method: "POST",
    data: {
      id: id
    },
    dataType: "json",
    success: function (retorno) {
      //Notificação
      //$('#message_usuario').html(data);

      if (retorno.tipo == "success") {
        $('#delAnexo'+retorno.info).modal('hide');  
        loadAnexos(retorno.info);
      }

      Swal.fire({
        icon: retorno.tipo,
        title: retorno.titulo,
        text: retorno.msg,
        showConfirmButton: false,
        timer: 3000
      });

    },
    error: function (xhr, status, error) {

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

function delPostado(id) {

  $.ajax({
    url: "../apagar/processa/proc_del_postado.php",
    method: "POST",
    data: {
      id: id
    },
    dataType: "json",
    success: function (retorno) {
      //Notificação
      //$('#message_usuario').html(data);

      if (retorno.tipo == "success") {
        window.location.href = pastaRaiz +"pages/modulo/informativos/painel/painel_informativo";
      }else{
        Swal.fire({
          icon: retorno.tipo,
          title: retorno.titulo,
          text: retorno.msg,
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
        showConfirmButton: true,
        //timer: 2000
      });

    }
  });
  
}

if (document.getElementById("loadInfos")) {
  buscarInfos(buscar = ' '); 
  loadCatInfos();
}

function buscarInfos(buscar) {
  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("loadInfos");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<div class="col text-center"><span class="spinner-border" role="status" aria-hidden="true"></span>Carregando...</div>';

  // Iniciar uma requisição
  xmlreq.open("GET", "consultas/infos.php?buscar=" + buscar, true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
};

function loadCatInfos() {
  // Declaração de Variáveis
  //var dados_usuario      = document.getElementById("dados_usuario").value;
  var list = document.getElementById("loadCatInfos");
  var xmlreq = CriaRequest();

  // Exibi a imagem de progresso
  list.innerHTML = '<div class="col text-center"><span class="spinner-border" role="status" aria-hidden="true"></span>Carregando...</div>';

  // Iniciar uma requisição
  xmlreq.open("GET", "consultas/categoriasInfos.php", true);

  // Atribui uma função para ser executada sempre que houver uma mudança de ado
  xmlreq.onreadystatechange = function () {

    // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
    if (xmlreq.readyState == 4) {

      // Verifica se o arquivo foi encontrado com sucesso
      if (xmlreq.status == 200) {
        list.innerHTML = xmlreq.responseText;
      } else {
        list.innerHTML = "Erro: " + xmlreq.statusText;
      }
    }
  };
  xmlreq.send(null);
};