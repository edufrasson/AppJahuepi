function addProduto(id, descricao, preco, quantidade, codigo_barra, id_categoria) {
  if (descricao !== "") {
    $.ajax({
      type: "POST",
      url: "/produto/save",
      data: {
        id: id,
        descricao: descricao,
        preco: preco,
        quantidade: quantidade,
        codigo_barra: codigo_barra,
        id_categoria: id_categoria
      },
      dataType: "json",
      success: function (result) {
        console.log(result.response_data);
        swal({
            title: "Sucesso!",
            text: "Produto cadastrado com sucesso!",
            icon: "success",
            button: "OK",
          });
      },
      error: function (result) {
        console.log(result);
      },
    });
  }
}

function getProdutoById(id) {
  $.ajax({
    type: "GET",
    url: "/produto/get-by-id?id=" + id,
    dataType: "json",
    success: function (result) {
      $("#txtNome").val(result.response_data.descricao);
      $("#txtPreco").val(result.response_data.preco);
      $("#txtQuantidade").val(result.response_data.quantidade);
      $("#txtCodigo_Barra").val(result.response_data.codigo_barra);
      $("#id").val(result.response_data.id);
    },
    error: function (result) {
      console.log(result);
    },
  });
}

function getProdutoByCodigo(codigo) {
  $.ajax({
    type: "GET",
    url: "/produto/get-count-by-codigo?codigo=" + codigo,
    dataType: "json",
    success: function (result) {
      if (result.response_data.produtos == 0) {
        addProduto(
          $("#id").val(),
          $("#txtNome").val(),
          $("#txtPreco").val(),
          $("#txtQuantidade").val(),
          $("#txtCodigo_Barra").val(),
          $("#id_categoria").val()
        );
      } else {
        swal({
          title: "Erro!",
          text: "Código de Barra já registrado. Tente Novamente",
          icon: "error",
          button: "OK",
        });
      }
    },
    error: function (result) {
      console.log(result);
    },
  });
}

function deleteProduto(id) {
  $.ajax({
    type: "GET",
    url: "/produto/delete?id=" + id,
    dataType: "json",
    success: function (result) {
      console.log(result);
    },
    error: function (result) {
      console.log(result);
    },
  });
}

function loadTableProduto() {
  $(".spinner-border").delay(1000).hide();
  $(".table-style").delay(1000).removeClass("off");
  $(".action-container").delay(1000).removeClass("off");
}

$(document).ready(function () {
  loadTableProduto();

  $("#adicionarProduto").click(() => {
    getProdutoByCodigo($("#txtCodigo_Barra").val());
  });

  $(".btn-edit").click(function (event) {
    getProdutoById(event.target.id);
  });

  $(".btn-delete").click(async function (event) {
    await swal({
      title: "Excluir registro",
      text: "Você tem certeza que deseja apagar esse registro?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Excluir",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false,
      closeOnCancel: false,
    }).then((isConfirm) => {
      if (isConfirm) {
        deleteProduto(event.target.id); // Executa a função quando o usuário clica em OK
        window.location.reload(true);
      } else {
        swal("Cancelado", "Seu registro não foi excluído.", "error");
      }
    });
  });
});
