var valor_total = 0;
var lista_produtos = Array();
var lista_parcelas = Array();

function deleteProduto(id_prod) {}

$(document).ready(function () {
  $(".btn-delete-list").click(async function (event) {
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
        produto_deletado = lista_produtos.find(
          (e) => e.id_produto == event.target.id
        );
        lista_produtos = lista_produtos.filter(
          (e) => e.id_produto == event.target.id
        );
        $(this).closest("tr").remove(); // Removendo linha do elemento da tabela
      } else {
        swal("Cancelado", "Seu registro não foi excluído.", "error");
      }
    });
  });
  $("#qnt_parcela").change(function () {});

  $("#adicionarProduto").click(function () {
    if ($("#id_produto").val() == "" || $("#quantidade").val() == "") {
      swal({
        title: "Erro!",
        text: "Preencha todos os campos! Tente Novamente",
        icon: "error",
        button: "OK",
      });
    } else {
      $.ajax({
        type: "GET",
        url: "/produto/get-by-id?id=" + $("#id_produto").val(),
        dataType: "json",
        success: function (result) {
          console.log(result);
          if (
            lista_produtos.some((e) => e.id_produto == result.response_data.id)
          ) {
            swal({
              title: "Erro!",
              text: "Produto já adicionado na venda!",
              icon: "error",
              button: "OK",
            });
          } else {
            lista_produtos.push({
              id_produto: result.response_data.id_produto,
              quantidade: $("#quantidade").val(),
              valor_unit: result.response_data.preco,
              codigo_barra: result.response_data.codigo_barra,
              descricao: result.response_data.descricao,
            });
           
            valor_total +=
            $("#quantidade").val() * result.response_data.preco;

            // Alterando os valores totais
            $('#valor_total').val(valor_total)  
            if($('#taxa').val() == null || $('#taxa').val() == "" || $('#taxa').val() == 0){
              $('#valor_liquido').val(valor_total)  
            }else{
              $('#valor_liquido').val(((valor_total) - (valor_total * ($('#taxa').val() / 100))).toFixed(2))  
            }
             

            // Adicionando produto no carrinho de compra
            $("#tableProduto").append(`<tr> 
                <td> ${result.response_data.descricao} </td> 
                <td> ${result.response_data.preco} </td>
                <td> ${$("#quantidade").val()} </td> 
                <td> ${result.response_data.codigo_barra} </td>             
                <td class="actions-list-venda d-flex justify-content-center">                
                    <box-icon name="trash" color="#e8ac07" id="${
                      result.response_data.id
                    }" class="btn-icon btn-delete-list"></box-icon>
                </td>
              </tr>`);
          }
        },
        error: function (result) {
          console.log(result);
        },
      });
    }
  });

  if ($("#id_venda").val() != "") {
    console.log($("#id_venda").val());
    $.ajax({
      type: "GET",
      url: "/produto_venda/get-by-id",
      data: {
        id: $("#id_venda").val(),
      },
      dataType: "json",
      success: function (result) {
        console.log(result);
        result.response_data.forEach((element) => {
          lista_produtos.push({
            id_produto: element.id_produto,
            quantidade: element.quantidade,
            valor_unit: element.preco,
            codigo_barra: element.codigo_barra,
            descricao: element.descricao,
          });

          valor_total += element.quantidade * element.preco;
        });
      },
      error: function (result) {
        console.log(result);
      },
    });

    $.ajax({
      type: "GET",
      url: "/venda/get-parcelas",
      data: {
        id: $("#id_venda").val(),
      },
      dataType: "json",
      success: function (result) {
        console.log(result);
        result.response_data.forEach((element) => {
          lista_parcelas.push({
            id_parcela: element.id_parcela,
            indice: element.indice,
            data_parcela: element.date_parcela,
            data_recebimento: element.date_recebimento,
            status: element.status,
          });

          valor_total += element.quantidade * element.preco;
        });
      },
      error: function (result) {
        console.log(result);
      },
    });
  }
});
