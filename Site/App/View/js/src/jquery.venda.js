lista_produtos = Array();
lista_parcelas = Array();

var valor_parcelas = 0;
var qnt_parcelas = 0;
var valor_total = 0;

var last_id_venda = false;
var verifica_parcelas = true;
var venda_inserida = false;
var produtos_relacionados = false;

/*
  Requisição para inserir a venda
*/
function inserirVenda(data_venda, id) {
  console.log("caiu na funcao");

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

function registrarVendaOrcamento(id_orcamento) {
  $.ajax({
    type: "POST",
    url: "/orcamento/confirm-venda",
    data: {
      id: id_orcamento,
    },
    dataType: "json",
    success: function (result) {
      console.log(result);
    },
    error: function (result) {
      console.log(result);
    },
  });
}

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
        switch ($("#forma_pagamento").val()) {
          case "CREDITO":
            adicionarPagamento(
              last_id_venda,
              valor_total,
              $(".qnt_parcelas").val(),
              $("#forma_pagamento").val(),
              $("#select-taxa-credito").val(),
              $("#data_venda").val(),
              $("#valor_liquido_credito").val()
            );
            break;
          case "DEBITO":
            console.log($("#select-taxa-debito").val());
            adicionarPagamento(
              last_id_venda,
              valor_total,
              1,
              $("#forma_pagamento").val(),
              $("#select-taxa-debito").val(),
              $("#data_venda").val(),
              $("#valor_liquido_debito").val()
            );
            break;
          case "BOLETO":
            console.log(lista_parcelas);
            adicionarPagamento(
              last_id_venda,
              valor_total,
              $("#qnt_parcelas_boleto").val(),
              $("#forma_pagamento").val(),
              $("#taxa-boleto").val(),
              $("#data_venda").val(),
              $("#valor_liquido_boleto").val(),
              lista_parcelas
            );
            break;
          case "DINHEIRO":
            adicionarPagamento(
              last_id_venda,
              valor_total,
              1,
              $("#forma_pagamento").val(),
              null,
              $("#data_venda").val(),
              valor_total
            );
            break;
        }
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
        text: "Erro interno ao realizar baixa no estoque. Tente Novamente",
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
  valor_liquido,
  lista_parcelas_prop = null
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
        arr_parcelas: JSON.stringify(lista_parcelas_prop),
      },
      dataType: "json",
      success: function (result) {
        // Verificando se a venda era de um orçamento
        if ($("#id_orcamento").val() != "") {
          registrarVendaOrcamento($("#id_orcamento").val());
        }

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
      // Verificando se há produto no estoque
      if (
        parseInt($("#quantidade").val()) > result.response_data.saldo_estoque
      ) {
        swal({
          title: "Erro!",
          text: "Não há estoque suficiente para cadastrar essa quantidade! Reposição necessária.",
          icon: "error",
          button: "OK",
        });
      } else {
        // Recalculando valores
        valor_total += $("#quantidade").val() * result.response_data.preco;
        lista_produtos.push({
          id_produto: result.response_data.id,
          quantidade: $("#quantidade").val(),
          valor_unit: result.response_data.preco,
          descricao: result.response_data.descricao,
        });

        // Adicionando produto no carrinho de compra
        $("#tableProduto").append(`<tr> 
       <td> ${result.response_data.descricao} </td> 
       <td> ${Intl.NumberFormat("pt-BR", {
         style: "currency",
         currency: "BRL",
       }).format(result.response_data.preco.toString())} </td>
       <td> ${$("#quantidade").val()} </td> 
       <td> ${result.response_data.codigo_barra} </td>             
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
      }
    },
    error: function (result) {
      swal({
        title: "Erro!",
        text: "Ocorreu um erro ao adicionar produto na venda! Tente Novamente",
        icon: "error",
        button: "OK",
      });
    },
  });
}

/**
 * Funções para atualizar os valores na modal de pagamento
 */

function updateTotalValue(qnt_parcelas = null) {
  $(".valor_total").val(valor_total.toFixed(2));
}

function updateTaxasValue(valor_taxa) {
  $("#valor_taxa_credito").val(valor_taxa * 100);
  $("#valor_liquido_credito").val(
    (valor_total - valor_total * valor_taxa).toFixed(2)
  );

  $("#valor_taxa_debito").val(valor_taxa * 100);
  $("#valor_liquido_debito").val(
    (valor_total - valor_total * valor_taxa).toFixed(2)
  );
  $("#valor_liquido_boleto").val((valor_total - valor_taxa).toFixed(2));
}

function updateParcelasValue(qnt_parcelas) {
  $(".valor_bruto_parcela").val((valor_total / qnt_parcelas).toFixed(2));
  $(".valor_liquido_parcela").val(
    $("#valor_liquido_credito").val() / qnt_parcelas == 0
      ? ($("#valor_liquido_debito").val() / qnt_parcelas).toFixed(2)
      : ($("#valor_liquido_credito").val() / qnt_parcelas).toFixed(2)
  );
}

function updateParcelasBoleto(qnt_parcelas_prop) {
  $("#valor_bruto_parcela_boleto").val(
    (valor_total / qnt_parcelas_prop).toFixed(2)
  );
  valor_parcelas = (valor_total / qnt_parcelas_prop).toFixed(2);
  $("#valor_liquido_parcela_boleto").val(
    ($("#valor_liquido_boleto").val() / qnt_parcelas_prop).toFixed(2)
  );

  qnt_parcelas = qnt_parcelas_prop;
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

  $("#forma_pagamento").change(function () {
    updateTotalValue();
    switch ($("#forma_pagamento").val()) {
      case "CREDITO":
        $("#modal-credito").removeClass("d-none");
        $("#modal-debito").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $("#modal-boleto").addClass("d-none");
        $("#select-taxa-credito").change(function () {
          updateTaxasValue($("#select-taxa-credito").val());
        });
        break;

      case "BOLETO":
        $(".modal-credito").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").removeClass("d-none");
        $("#taxa-boleto").change(function () {
          updateTaxasValue($("#taxa-boleto").val());
        });
        $("#qnt_parcelas_boleto").change(() => {
          updateParcelasBoleto($("#qnt_parcelas_boleto").val());
        });

        $("#finalizarVenda").addClass("d-none");
        $("#ajustarParcela").removeClass("d-none");

        // Função executada ao iniciar ajuste de parcelas
        $("#ajustarParcela").click(() => {
          if (
            $("#qnt_parcelas_boleto").val() != 0 ||
            $("#qnt_parcelas_boleto").val() != ""
          ) {
            // Fazendo aparecer a tela de ajuste de parcelas
            $("#botaoVoltar").removeClass("d-none");
            $(".container-forma-pagamento").addClass("d-none");
            $("#ajustarParcela").addClass("d-none");
            $("#finalizarVenda").removeClass("d-none");
            $(".title-parcelas").removeClass("d-none");
            $("#modalPagamentoCompraTitle").addClass("d-none");
            $(".initial-values").addClass("d-none");
            qnt_parcelas = $("#qnt_parcelas_boleto").val();

            // Adicionando na div as parcelas correspondentes ao num de parcelas
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
                      <input class="form-control" type="text" name="valor_parcela_disabled" id="valor_parcela_disabled${i}" value="${valor_parcelas}"disabled>
                    </div>                
                    <div class="input-container"> 
                      <label> Data de recebimento</label><br>
                      <input class="form-control" type="date" name="data_recebimento" id="data_recebimento${i}">
                    </div>              
                  </div>
                  <hr class="hr"> 
                </div>`
              );
            }
            $(".ajustes-parcela").removeClass("d-none");

            // Botão de Voltar do Ajuste -> Retorna aos valores iniciais
            $("#botaoVoltar").click(function () {
              $("#botaoVoltar").addClass("d-none");
              $("#ajustarParcela").removeClass("d-none");
              $(".container-forma-pagamento").removeClass("d-none");
              $("#finalizarVenda").addClass("d-none");
              $("#modalPagamentoVendaTitle").removeClass("d-none");
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
        break;

      case "DEBITO":
        $(".modal-credito").addClass("d-none");
        $(".modal-debito").removeClass("d-none");
        $(".modal-boleto").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $("#select-taxa-debito").change(function () {
          updateTaxasValue($("#select-taxa-debito").val());
        });
        break;

      case "DINHEIRO":
        $(".modal-credito").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").addClass("d-none");
        $(".modal-dinheiro").removeClass("d-none");
        $("#select-taxa-debito").change(function () {
          updateTaxasValue($("#select-taxa-debito").val());
        });
        break;
      default:
        $(".modal-credito").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        break;
    }
  });

  $(".qnt_parcelas").change(() => {
    updateParcelasValue($(".qnt_parcelas").val());
  });

  /* 
    Função que chama todas as requisições necessárias para inserir uma venda completa
  */
  $("#finalizarVenda").click(async () => {
    switch ($("#forma_pagamento").val()) {
      case "CREDITO":
        await inserirVenda($("#data_venda").val(), $("#id").val());
        break;
      case "DEBITO":
        await inserirVenda($("#data_venda_debito").val(), $("#id").val());
        break;
      case "BOLETO":
        console.log("caiu no boleto");
        for (let i = 1; i <= qnt_parcelas; i++) {
          if ($(`#data_recebimento${i}`).val() == "") verifica_parcelas = false;
        }
        console.log("passou a primeira");

        if (verifica_parcelas != false) {
          console.log("passou o segundo if");
          for (let i = 1; i <= qnt_parcelas; i++) {
            lista_parcelas.push({
              indice: i,
              valor_parcela: (valor_total / qnt_parcelas).toFixed(2),
              data_parcela: $(`#data_recebimento${i}`).val(),
            });
          }
          console.log(lista_parcelas);

          await inserirVenda($("#data_venda_boleto").val(), $("#id").val());
        }

        break;
      case "DINHEIRO":
        await inserirVenda($("#data_venda_dinheiro").val(), $("#id").val());
        break;
    }

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

  $(".btn-orcamento").click(() => {
    console.log("caiu orcamento");
    $("#valor_total").val(valor_total.toFixed(2));

    $("#valor_total_formatado").val(
      Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
        valor_total
      )
    );
    $("#arr_produtos").val(JSON.stringify(lista_produtos));
    const option = {
      year: "numeric",
      month: "long" || "short" || "numeric",
      day: "numeric",
    };
    const locale = "pt-br";
    const data = new Date().toLocaleDateString(locale, option);
    console.log(data);
    $("#data_dia").val(data);
  });

  if ($("#id_orcamento").val() != "") {
    console.log($("#id_orcamento").val());
    $.ajax({
      type: "GET",
      url: "/orcamento/get-produtos",
      data: {
        id: $("#id_orcamento").val(),
      },
      dataType: "json",
      success: function (result) {
        console.log(result);
        result.response_data.forEach((element) => {
          lista_produtos.push({
            id_produto: element.id_produto,
            quantidade: element.quantidade,
            valor_unit: element.preco,
            descricao: element.descricao,
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
