lista_produtos = Array();
var valor_total = 0;
var valor_parcelas = 0;
var qnt_parcelas = false;
var venda_inserida = false;
var produtos_relacionados = false;

/*
  Requisição para inserir a venda
*/
function inserirVenda(data_venda, id) {
  if (data_venda !== "") {
    $.ajax({
      type: "POST",
      url: "/venda/save",
      async: false,
      data: {
        id: id,
        data_venda: data_venda,
      },
      dataType: "json",
      success: function (result) {
        last_id_venda = result.response_data.id;
        venda_inserida = true;
        console.log("venda deu bom:");
        console.log(result.response_data);
      },
      error: function (result) {
        console.log("erro na venda:");
        last_id_venda = false;
      },
    });
  } else {
    swal({
      title: "Erro!",
      text: "Preencha todos os campos! Tente Novamente",
      icon: "error",
      button: "OK",
    });
  }
}

/*
  Requisição para insert na tabela assoc de produto_venda
*/

function relacionarProdutoVenda(id_venda, lista_produtos) {
  if (id_venda != false && lista_produtos != null) {
    $.ajax({
      type: "POST",
      url: "/produto_venda/save",
      data: {
        id_venda: id_venda,
        lista_produtos: JSON.stringify(lista_produtos),
      },
      dataType: "json",
      success: function (result) {
        produtos_relacionados = true;
      },
      error: function (result) {
        console.log(result);
        swal({
          title: "Erro!",
          text: "Erro interno ao adicionar o produto na venda. Tente Novamente",
          icon: "error",
          button: "OK",
        });
      },
    });
  } else
    swal({
      title: "Erro!",
      text: "Preencha todos os campos! Tente Novamente",
      icon: "error",
      button: "OK",
    });
}

function baixaEstoque(id_venda) {
  $.ajax({
    type: "POST",
    url: "/produto_venda/baixa_estoque",
    data: {
      id_venda: id_venda,
    },
    dataType: "json",
    success: function (result) {
      swal({
        title: "Sucesso!",
        text: "Venda cadastrada com sucesso!",
        icon: "success",
        button: "OK",
      });
    },
    error: function (result) {
      swal({
        title: "Erro!",
        text: "Erro interno ao adicionar a venda. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    },
  });
}

/**
 *  Requisição para insert na tabela de Pagamento
 */

function adicionarPagamento(
  id_venda,
  valor_total,
  qnt_parcelas,
  forma_pagamento,
  taxa,
  data_venda,
  valor_liquido
) {
  if (
    id_venda != false &&
    valor_total != false &&
    qnt_parcelas != false &&
    forma_pagamento != false &&
    id_venda != false
  ) {
    $.ajax({
      type: "POST",
      url: "/pagamento/save",
      data: {
        id_venda: id_venda,
        valor_total: valor_total,
        qnt_parcelas: qnt_parcelas,
        forma_pagamento: forma_pagamento,
        taxa: taxa,
        data_venda: data_venda,
        valor_liquido: valor_liquido,
      },
      dataType: "json",
      success: function (result) {
        console.log(result.response_data);
        if (result.response_data == true) {
          baixaEstoque(last_id_venda);
        }
      },
      error: function (result) {
        swal({
          title: "Erro!",
          text: "Ocorreu um erro ao adicionar pagamento da venda! Tente Novamente",
          icon: "error",
          button: "OK",
        });
        console.log(result);
      },
    });
  } else {
    swal({
      title: "Erro!",
      text: "Preencha todos os campos! Tente Novamente",
      icon: "error",
      button: "OK",
    });
  }
}

/**
 * Requisição para adicionar os produtos na tabela
 */

async function reloadTableProduct() {
  $.ajax({
    type: "GET",
    url: "/produto/get-by-id?id=" + $("#id_produto").val(),
    dataType: "json",
    success: async function (result) {
      // Recalculando valores
      valor_total += $("#quantidade").val() * $("#valor_unitario").val();
      lista_produtos.push({
        id_produto: result.response_data.id,
        quantidade: $("#quantidade").val(),
        valor_unit: $("#valor_unitario").val(),
      });

      // Adicionando produto no carrinho de compra
      $("#tableProduto").append(`<tr> 
       <td> ${result.response_data.descricao} </td> 
       <td> ${Intl.NumberFormat("pt-BR", {
         style: "currency",
         currency: "BRL",
       }).format($("#valor_unitario").val().toString())} </td>
       <td> ${$("#quantidade").val()} </td>                    
       <td class="actions-list-venda d-flex justify-content-center">                
           <box-icon name="trash" color="#e8ac07" id="${
             result.response_data.id
           }" class="btn-icon btn-delete-list"></box-icon>
       </td>
      </tr>`);

      // Função que retira os produtos da lista de compras
      $(".btn-delete-list").click(function () {
        lista_produtos.splice(
          lista_produtos.findIndex(
            (produto) => produto.id_produto == result.response_data.id
          ),
          1
        );
        $(this).closest("tr").remove(); // Removendo linha do elemento da tabela
      });
    },
  });
}

/**
 * Funções para atualizar os valores na modal de pagamento
 */

function updateTotalValue(qnt_parcelas = null) {
  $(".valor_total").val(
    Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
      valor_total
    )
  );
}

function updateParcelasValue(qnt_parcelas) {
  valor_parcelas = (valor_total / qnt_parcelas).toFixed(2);
  $("#valor_parcela").val(
    Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
      valor_parcelas
    )
  );

  valor_parcelas = Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
    valor_parcelas
  )
}

/* 
  Função Inicial da Página
*/

$(document).ready(function () {
  /* 
    Funções dos botões da tabela
  */

  $("#adicionarProduto").click(function () {
    reloadTableProduct();
  });

  $("#qnt_parcelas").change(() => {
    if ($("#qnt_parcelas").val() > 12) {
      $("#qnt_parcelas").val(12);
      updateParcelasValue(12);
    } else updateParcelasValue($("#qnt_parcelas").val());
  });

  $(".btn-pagamento").click(() => {
    updateTotalValue(valor_total);
  });

  $("#ajustarParcelas").click(() => {
    if ($("#qnt_parcelas").val() != 0 || $("#qnt_parcelas").val() != "") {
      $('#botaoVoltar').removeClass("d-none");
      $('.title-parcelas').removeClass("d-none");
      $('#modalPagamentoCompraTitle').addClass("d-none");
      $(".initial-values").addClass("d-none");
      qnt_parcelas = $("#qnt_parcelas").val()
      for (let i = 1; i <= qnt_parcelas; i++) {
        $(".ajustes-parcela").append(
        ` <div class="input-container">    
            <div class="label-container"> 
              <p> Parcela nº ${i}</p>
            </div>                     
            <hr class="hr">            
            <div class="input-row">
              <div class="input-container"> 
                <label> Valor da Parcela</label><br>
                <input class="form-control" type="text" name="valor_parcela_disabled" id="valor_parcela_disabled" value="${valor_parcelas}"disabled>
              </div>                
              <div class="input-container"> 
                <label> Data de Vencimento</label><br>
                <input class="form-control" type="date" name="data_vencimento" id="data_vencimento${i}">
              </div>              
            </div>
            <hr class="hr"> 
          </div>`
        )
      }
      $(".ajustes-parcela").removeClass("d-none");

      $('#botaoVoltar').click(function () { 
        $('#botaoVoltar').addClass("d-none");
        $('.title-parcelas').addClass("d-none");
        $('#modalPagamentoCompraTitle').removeClass("d-none");
        $(".initial-values").removeClass("d-none");
        $(".ajustes-parcela").empty();
        $(".ajustes-parcela").addClass("d-none");

      });
    } else {
      swal({
        title: "Erro!",
        text: "Insira a quantidade de parcelas antes do ajuste!",
        icon: "error",
        button: "OK",
      });
    }
  });

  /* 
    Função que chama todas as requisições necessárias para inserir uma compra completa
  */
  $("#finalizarCompra").click(async () => {
    await inserirCompra($("#data_venda").val(), $("#id").val());

    if (venda_inserida != false) {
      valor = await relacionarProdutoVenda(last_id_venda, lista_produtos);
    } else {
      swal({
        title: "Erro!",
        text: "Erro interno ao adicionar a venda. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    }
    setInterval(5000);
  });
});
