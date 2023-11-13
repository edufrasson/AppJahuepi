lista_produtos = Array();
var usarLeitor;
var valor_total = 0;
var valor_parcelas = 0;
var last_id_compra = false;
var qnt_parcelas = false;
var verifica_parcelas = true;
var compra_inserida = false;
var produtos_relacionados = false;

/*
  Requisição para inserir a compra
*/
function inserirCompra(data_compra, id, qnt_parcela, id_fornecedor, valor_compra, arr_parcelas) {
  if (data_compra !== "") {
    $.ajax({
      type: "POST",
      url: "/compra/save",
      async: false,
      data: {
        id: id,
        data_compra: data_compra,
        qnt_parcela: qnt_parcela,
        id_fornecedor: id_fornecedor,
        valor_compra: valor_compra,
        arr_parcelas: JSON.stringify(arr_parcelas)
      },
      dataType: "json",
      success: function (result) {
        console.log("compra deu bom:");
        console.log(result.response_data);
        last_id_compra = result.response_data.id;
        compra_inserida = true;
        console.log(lista_produtos)
        relacionarProdutoCompra(last_id_compra, lista_produtos);
      },
      error: function (result) {
        console.log(`erro na compra: ${result}`);
        last_id_compra = false;
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
  Requisição para insert na tabela assoc de produto_compra
*/

function relacionarProdutoCompra(id_compra, lista_produtos) {
  if (id_compra != false && lista_produtos != null) {
    $.ajax({
      type: "POST",
      url: "/produto_compra/save",
      data: {
        id_compra: id_compra,
        lista_produtos: JSON.stringify(lista_produtos),
      },
      dataType: "json",
      success: function (result) {
        baixaEstoque(last_id_compra)
      },
      error: function (result) {
        console.log(result);
        swal({
          title: "Erro!",
          text: "Erro interno ao adicionar o produto na compra. Tente Novamente",
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

function baixaEstoque(id_compra) {
  $.ajax({
    type: "POST",
    url: "/produto_compra/baixa_estoque",
    data: {
      id_compra: id_compra,
    },
    dataType: "json",
    success: function (result) {
      swal({
        title: "Sucesso!",
        text: "Compra cadastrada com sucesso!",
        icon: "success",
        button: "OK",
      });
    },
    error: function (result) {
      console.log(result)
      swal({
        title: "Erro!",
        text: "Erro interno ao adicionar ao baixar estoque. Tente Novamente",
        icon: "error",
        button: "OK",
      });
    },
  });
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
      console.log(result)

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
       <td class="actions-list-compra d-flex justify-content-center">                
           <box-icon name="trash" color="#e8ac07" id="${result.response_data.id
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

async function reloadTableProductByCodigo() {
  $.ajax({
    type: "GET",
    url: "/produto/get-by-codigo?codigo=" + $("#codigo_barra").val(),
    dataType: "json",
    success: async function (result) {
      // Recalculando valores
      console.log(result)

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
       <td class="actions-list-compra d-flex justify-content-center">                
           <box-icon name="trash" color="#e8ac07" id="${result.response_data.id
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

  valor_parcelas = Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
  }).format(valor_parcelas);
}

/* 
  Função Inicial da Página
*/

$(document).ready(function () {
  /* 
    Funções dos botões da tabela
  */

  $("#adicionarProduto").click(function () {
    if ($('#codigo_barra').hasClass('d-none') == false && usarLeitor == true)
      reloadTableProductByCodigo();
    else
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
      // Fazendo aparecer a tela de ajuste de parcelas
      $("#botaoVoltar").removeClass("d-none");
      $("#ajustarParcelas").addClass("d-none");
      $("#adicionarCompra").removeClass("d-none");
      $(".title-parcelas").removeClass("d-none");
      $("#modalPagamentoCompraTitle").addClass("d-none");
      $(".initial-values").addClass("d-none");
      qnt_parcelas = $("#qnt_parcelas").val();
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
        );
      }
      $(".ajustes-parcela").removeClass("d-none");

      // Botão de Voltar do Ajuste -> Retorna aos valores iniciais
      $("#botaoVoltar").click(function () {
        $("#botaoVoltar").addClass("d-none");
        $(".title-parcelas").addClass("d-none");
        $("#ajustarParcelas").removeClass("d-none");
        $("#adicionarCompra").addClass("d-none");
        $("#modalPagamentoCompraTitle").removeClass("d-none");
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


  // Verificando o local storage do leitor
  if (localStorage.getItem('usarLeitor') == 'true') {
    console.log('caiu no true')
    console.log(localStorage.getItem('usarLeitor'))
    $('#usar_leitor').prop('checked', true)
    $(".select-container-produto").addClass("d-none");
    $(".container-codigo-barra").removeClass("d-none");
  } else {
    console.log('caiu no false')
    console.log(localStorage.getItem('usarLeitor'))
    $('#usar_leitor').prop('checked', false)
    $(".select-container-produto").removeClass("d-none");
    $(".container-codigo-barra").addClass("d-none");
  }

  $("#usar_leitor").mousedown(function () {
    if (this.checked) {
      usarLeitor = false
      localStorage.setItem('usarLeitor', false)
      $(".select-container-produto").removeClass("d-none");
      $(".container-codigo-barra").addClass("d-none");

    } else {
      usarLeitor = true
      localStorage.setItem('usarLeitor', true)
      $(".select-container-produto").addClass("d-none");
      $(".container-codigo-barra").removeClass("d-none");

    }
  });


  /* 
    Função que chama todas as requisições necessárias para inserir uma compra completa
  */

  $("#adicionarCompra").click(async () => {
    for (let i = 1; i <= qnt_parcelas; i++) {
      if ($(`#data_vencimento${i}`).val() == "") verifica_parcelas = false;
    }

    if (verifica_parcelas != false) {
      let arr_parcelas = Array();
      for (let i = 1; i <= qnt_parcelas; i++) {
        arr_parcelas.push(
          {
            indice: i,
            valor_cobranca: (valor_total / qnt_parcelas).toFixed(2),
            data_cobranca: $(`#data_vencimento${i}`).val()
          }
        )
      }

      await inserirCompra(
        $("#data_compra").val(),
        $("#id").val(),
        qnt_parcelas,
        $("#id_fornecedor").val(),
        valor_total,
        arr_parcelas
      );


      setInterval(5000);
    } else {
      swal({
        title: "Erro!",
        text: "Verifique se todas as parcelas foram ajustadas!",
        icon: "error",
        button: "OK",
      });
    }
  });
});
