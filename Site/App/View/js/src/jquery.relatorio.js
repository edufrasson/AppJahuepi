function getVendaById(id) {
  $.ajax({
    type: "GET",
    url: "/venda/get-by-id?id=" + id,
    dataType: "json",
    success: function (result) {
      $("#txtNome").val(result.response_data.descricao);
      $("#id").val(result.response_data.id);
    },
    error: function (result) {
      console.log(result);
    },
  });
}

function deleteVenda(id) {
  $.ajax({
    type: "GET",
    url: "/venda/delete?id=" + id,
    dataType: "json",
    success: function (result) {
      console.log(result);
    },
    error: function (result) {
      console.log(result);
    },
  });
}

function getAllProducts(id_venda) {
  $(".loading-produto").show();
  $(".table-container-produto").addClass("d-none");
  $.ajax({
    type: "GET",
    url: "/venda/get-produtos?id=" + id_venda,
    dataType: "json",
    success: async (result) => {
      result.response_data.forEach((element) => {
        $("#tableProdutos").append(`<tr> 
                <td> ${element.descricao} </td> 
                <td> ${Intl.NumberFormat("pt-BR", {
                  style: "currency",
                  currency: "BRL",
                }).format(element.valor_unit.toString())} </td> 
                <td> ${element.quantidade} </td>        
               
               </tr>`);
      });

      $(".loading-produto").hide();
      $(".table-container-produto").removeClass("d-none");
    },
    error: () => {
      console.log(" :( ");
    },
  });
}

function getAllParcelas(id_venda) {
  $(".loading-parcela").show();
  $(".table-container-parcela").addClass("d-none");
  $.ajax({
    type: "GET",
    url: "/venda/get-parcelas?id=" + id_venda,
    dataType: "json",
    success: async (result) => {
      /*if(result.response_data[0].tipo_parcela == "BOLETO")
        $('#modalParcelas').addClass("modal-xl")
      else
        $('#modalParcelas').removeClass("modal-xl")*/
      await result.response_data.forEach((element) => {
        $("#tableParcelas").append(`<tr> 
                <td> ${element.indice} </td> 
                <td> ${Intl.NumberFormat("pt-BR", {
                  style: "currency",
                  currency: "BRL",
                }).format(element.valor_parcela.toString())} </td> 
                <td> ${element.data_parcela} </td>        
                <td> ${element.data_recebimento} </td>        
                <td id="status-parcela${element.id}"> ${
          element.status
        } </td>        
                <td class="confirm-container${element.id} d-none">
                    <a href="/venda/confirm-parcela?id=${
                      element.id
                    }" class="btn btn-danger btnConfirmarParcela">Confirmar</a>
                </td>
               </tr>`);
        switch (element.status) {
          case "PENDENTE":
            $(`#status-parcela${element.id}`).css("color", "#Dab13d");
            break;
          case "CONFIRMADO":
            $(`#status-parcela${element.id}`).css("color", "#228c0c");
            break;
          case "ATRASO":
            $(`#status-parcela${element.id}`).css("color", "#8c1a0c");
            break;
        }
        element.tipo_parcela == "BOLETO" && element.status != "CONFIRMADO"
          ? $(`.confirm-container${element.id}`).removeClass("d-none")
          : $(`.confirm-container${element.id}`).addClass("d-none");
      });
      $(".loading-parcela").hide();
      $(".table-container-parcela").removeClass("d-none");
    },
    error: () => {
      console.log(" :( ");
    },
  });
}

function loadTableVenda() {
  $(".spinner-border").delay(1000).hide();
  $(".table-style").delay(1000).removeClass("off");
}

$(document).ready(function () {
  loadTableVenda();

  $("#filtro_ano").change(() => {
    if ($("#filtro_ano").val() != "") {
      let link = "/relatorio?ano=" + $("#filtro_ano").val();
      $("#btnFiltrar").attr("href", link);
    } else $("#btnFiltrar").attr("href", "/relatorio");
  });
  $("#filtro_mes").change(() => {
    if ($("#filtro_ano").val() != "" && $("#filtro_mes").val() != "") {
      let link =
        "/relatorio?ano=" +
        $("#filtro_ano").val() +
        "&mes=" +
        $("#filtro_mes").val();
      $("#btnFiltrar").attr("href", link);
    }

    if ($("#filtro_ano").val() != "" && $("#filtro_mes").val() == "") {
      let link = "/relatorio?ano=" + $("#filtro_ano").val();
      $("#btnFiltrar").attr("href", link);
    }
  });

  $("#btnFiltrar").click(() => {
    if ($(this).attr("href") == "#") {
      swal({
        title: "Erro!",
        text: "Selecione corretamente os valores dos filtros. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    }
  });

  $(".open-produtos").click((event) => {
    event.preventDefault();
    $("#tableProdutos").empty();

    getAllProducts(event.target.id);
  });

  $(".open-parcelas").click(function (e) {
    e.preventDefault();
    $("#tableParcelas").empty();

    getAllParcelas(e.target.id);
  });

  $(".btn-edit").click(function (event) {
    getVendaById(event.target.id);
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
        deleteVenda(event.target.id); // Executa a função quando o usuário clica em OK
        window.location.reload(true);
      } else {
        swal("Cancelado", "Seu registro não foi excluído.", "error");
      }
    });
  });
});
