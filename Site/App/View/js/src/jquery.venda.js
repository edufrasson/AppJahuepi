lista_produtos = Array();
lista_parcelas = Array();

var usarLeitor;
var valor_parcelas = 0;
var qnt_parcelas = 0;
var valor_total = 0;

var last_id_venda = false;
var verifica_parcelas = true;
var venda_inserida = false;
var produtos_relacionados = false;

function resetLoading() {
  $("#defaultLabelButton").show();
  $(".loading-button").hide();
}

/*
  Requisição para inserir a venda
*/
function inserirVenda(data_venda, id) {
  if (data_venda !== "") {
    $("#defaultLabelButton").hide();
    $(".loading-button").removeClass("d-none");
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
        resetLoading();
      },
    });
  } else {
    console.log("caiu no erro que nao era pra ter acontecido");
    resetLoading();
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
            $("#data_venda_credito").val(),
            $("#valor_liquido_credito").val(),
            null,
            parseFloat($("#valor_taxa_credito").val())
          );
          break;
        case "DEBITO":
          console.log($("#select-taxa-debito").val());
          adicionarPagamento(
            last_id_venda,
            valor_total,
            1,
            $("#forma_pagamento").val(),
            $("#data_venda_debito").val(),
            $("#valor_liquido_debito").val(),
            null,
            parseFloat($("#valor_taxa_debito").val())
          );
          break;
        case "BOLETO":
          console.log(lista_parcelas);
          adicionarPagamento(
            last_id_venda,
            valor_total,
            $("#qnt_parcelas_boleto").val(),
            $("#forma_pagamento").val(),
            $("#data_venda_boleto").val(),
            $("#valor_liquido_boleto").val(),
            lista_parcelas,
            null
          );
          break;
        case "DINHEIRO":
          adicionarPagamento(
            last_id_venda,
            valor_total,
            1,
            $("#forma_pagamento").val(),
            $("#data_venda_dinheiro").val(),
            valor_total,
            null,
            null
          );
          break;
      }
    },
    error: function (result) {
      resetLoading();
      swal({
        title: "Erro!",
        text: "Erro interno ao adicionar o produto na venda. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    },
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
      $("#defaultLabelButton").show();
      $(".loading-button").hide();
      swal({
        title: "Sucesso!",
        text: "Venda cadastrada com sucesso!",
        icon: "success",
        button: "OK",
      });
    },
    error: function (result) {
      resetLoading();
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
  data_venda,
  valor_liquido,
  lista_parcelas_prop = null,
  taxa = null
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
        data_venda: data_venda,
        valor_liquido: valor_liquido,
        arr_parcelas: JSON.stringify(lista_parcelas_prop),
        taxa: taxa,
      },
      dataType: "json",
      success: function (result) {
        // Verificando se a venda era de um orçamento
        if ($("#id_orcamento").val() != "") {
          registrarVendaOrcamento($("#id_orcamento").val());
        }

        console.log(result);

        if (result.response_data == true) {
          baixaEstoque(last_id_venda);
        }
      },
      error: function (result) {
        resetLoading();
        swal({
          title: "Erro!",
          text: "Ocorreu um erro ao adicionar pagamento da venda! Tente Novamente",
          icon: "error",
          button: "OK",
        });
      },
    });
  } else {
    resetLoading();
    console.log("caiu no erro que nao era pra ter acontecido 3");
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

async function reloadTableProductById() {
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

        // Resetando quantidade
        $("#quantidade").val("");

        // Função que retira os produtos da lista de compras
        $(".btn-delete-list").click(function () {
          lista_produtos.splice(
            lista_produtos.findIndex(
              (produto) => produto.id_produto == result.response_data.id
            ),
            1
          );
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

async function reloadTableProductByCodigo() {
  if ($("#codigo_barra").val() == 0 || $("#codigo_barra").val() == "") {
    swal({
      title: "Erro!",
      text: "Insira um código de barras válido!",
      icon: "error",
      button: "OK",
    });
  } else {
    $.ajax({
      type: "GET",
      url: "/produto/get-by-codigo?codigo=" + $("#codigo_barra").val(),
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
          if (result.response_data != null) {
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

            // Resetando quantidade
            $("#quantidade").val("");

            // Função que retira os produtos da lista de compras
            $(".btn-delete-list").click(function () {
              lista_produtos.splice(
                lista_produtos.findIndex(
                  (produto) => produto.id_produto == result.response_data.id
                ),
                1
              );
            });
          } else {
            swal({
              title: "Erro!",
              text: "Produto não encontrado! Tente novamente.",
              icon: "error",
              button: "OK",
            });
          }
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

function adicionarProduto() {
  // Verificando se o input não está vazio
  if (
    $("#quantidade").val() != null &&
    $("#quantidade").val() != 0 &&
    $("#quantidade").val() != ""
  ) {
    if (
      $("#codigo_barra").hasClass("d-none") == false &&
      localStorage.getItem("usarLeitor") == "true"
    )
      reloadTableProductByCodigo();
    else reloadTableProductById();
  } else {
    swal({
      title: "Erro!",
      text: "Preencha corretamente a quantidade de produto desejada!",
      icon: "error",
      button: "OK",
    });
  }
}

/* 
  Função Inicial da Página
*/

$(document).ready(function () {
  /* 
    Funções dos botões da tabela
  */

  $("#adicionarProduto").click(function () {
    adicionarProduto();
  });

  $("#forma_pagamento").change(function () {
    updateTotalValue();
    switch ($("#forma_pagamento").val()) {
      case "CREDITO":
        $("#modal-credito").removeClass("d-none");
        $("#modal-debito").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $("#modal-boleto").addClass("d-none");

        $("#ajustarParcela").addClass("d-none");
        $("#finalizarVenda").removeClass("d-none");

        $("#select-taxa-credito").change(function () {
          updateTaxasValue($("#select-taxa-credito").val());
        });
        break;

      case "BOLETO":
        $(".modal-credito").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").removeClass("d-none");

        $("#qnt_parcelas_boleto").change(() => {
          if ($("#qnt_parcelas_boleto").val() > 12) {
            $("#qnt_parcelas_boleto").val(12);
            updateParcelasBoleto(12);
          } else updateParcelasBoleto($("#qnt_parcelas_boleto").val());
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

        $("#ajustarParcela").addClass("d-none");
        $("#finalizarVenda").removeClass("d-none");

        $("#select-taxa-debito").change(function () {
          updateTaxasValue($("#select-taxa-debito").val());
        });
        break;

      case "DINHEIRO":
        $(".modal-credito").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").addClass("d-none");
        $(".modal-dinheiro").removeClass("d-none");

        $("#ajustarParcela").addClass("d-none");
        $("#finalizarVenda").removeClass("d-none");

        $("#select-taxa-debito").change(function () {
          updateTaxasValue($("#select-taxa-debito").val());
        });
        break;
      default:
        $(".modal-credito").addClass("d-none");
        $(".modal-debito").addClass("d-none");
        $(".modal-boleto").addClass("d-none");
        $(".modal-dinheiro").addClass("d-none");
        $("#ajustarParcela").addClass("d-none");
        $("#finalizarVenda").removeClass("d-none");
        break;
    }
  });

  $(".qnt_parcelas").change(() => {
    if (
      ($("#forma_pagamento").val() == "DEBITO" &&
        $("#select-taxa-debito").val() == "") ||
      ($("#forma_pagamento").val() == "CREDITO" &&
        $("#select-taxa-credito").val() == "")
    ) {
      swal({
        title: "Erro!",
        text: "Selecione uma taxa primeiro!",
        icon: "error",
        button: "OK",
      });

      $(".valor_bruto_parcela").val("");
      $(".valor_liquido_parcela").val("");
      $("#valor_liquido_debito").val("");
      $(".qnt_parcelas").val("");
    } else {
      if ($(".qnt_parcelas").val() > 12) {
        $(".qnt_parcelas").val(12);
        updateParcelasValue(12);
      } else updateParcelasValue($(".qnt_parcelas").val());
    }
  });

  /* 
    Função que chama todas as requisições necessárias para inserir uma venda completa
  */
  $("#finalizarVenda").click(async () => {
    $("#defaultLabelButton").hide();
    $(".loading-button").removeClass("d-none");
    switch ($("#forma_pagamento").val()) {
      case "CREDITO":
        await inserirVenda($("#data_venda_credito").val(), $("#id").val());
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
      resetLoading()
      swal({
        title: "Erro!",
        text: "Erro interno ao adicionar a venda. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    }
    
  });

  // Funções executadas ao abrir a página

  if (localStorage.getItem("usarLeitor") == "true") {
    $("#usar_leitor").prop("checked", true);
    $(".select-container").addClass("d-none");
    $(".container-codigo-barra").removeClass("d-none");
    $("#codigo_barra").focus();
  } else {
    console.log("caiu no false");
    console.log(localStorage.getItem("usarLeitor"));
    $("#usar_leitor").prop("checked", false);
    $(".select-container").removeClass("d-none");
    $(".container-codigo-barra").addClass("d-none");
  }

  $("#codigo_barra").change(() => {
    $("#quantidade").focus();
  });

  $("#quantidade").keypress((event) => {
    console.log("caiu no evento");

    if (event.key == "Enter") {
      adicionarProduto();
    }
  });

  $("#usar_leitor").mousedown(function () {
    if (this.checked) {
      usarLeitor = false;
      localStorage.setItem("usarLeitor", false);
      $(".select-container").removeClass("d-none");
      $(".container-codigo-barra").addClass("d-none");
    } else {
      usarLeitor = true;
      localStorage.setItem("usarLeitor", true);
      $(".select-container").addClass("d-none");
      $(".container-codigo-barra").removeClass("d-none");
    }
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
