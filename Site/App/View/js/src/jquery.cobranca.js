function getCompraById(id) {
    $.ajax({
      type: "GET",
      url: "/compra/get-by-id?id=" + id,
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
  
  function deleteCompra(id) {
    $.ajax({
      type: "GET",
      url: "/Compra/delete?id=" + id,
      dataType: "json",
      success: function (result) {
        console.log(result);
      },
      error: function (result) {
        console.log(result);
      },
    });
  }
  
  function getAllProducts(id_compra) {
    $.ajax({
      type: "GET",
      url: "/compra/get-produtos?id=" + id_compra,
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
      },
      error: () => {
        console.log(" :( ");
      },
    });
  }
  
  function getAllParcelas(id_compra) {
    $.ajax({
      type: "GET",
      url: "/Compra/get-parcelas?id=" + id_compra,
      dataType: "json",
      success: async (result) => {
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
                      <a href="/Compra/confirm-parcela?id=${
                        element.id
                      }" class="btn btn-danger btnPagarCobranca">Pagar</a>
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
          
        });
      },
      error: () => {
        console.log(" :( ");
      },
    });
  }
  
  function loadTableCompra() {
    $(".spinner-border").delay(1000).hide();
    $(".table-style").delay(1000).removeClass("off");
  }
  
  $(document).ready(function () {
    loadTableCompra();
  
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
      getCompraById(event.target.id);
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
          deleteCompra(event.target.id); // Executa a função quando o usuário clica em OK
          window.location.reload(true);
        } else {
          swal("Cancelado", "Seu registro não foi excluído.", "error");
        }
      });
    });
  });
  