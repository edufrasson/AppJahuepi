lista_produtos = Array();
var valor_total = 0
var last_id_venda = false;
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
      dataType: 'json',
      success: function (result) {
        last_id_venda = result.response_data.id
        venda_inserida = true
        console.log("venda deu bom:")
        console.log(result.response_data)
      },
      error: function (result) {
        console.log("erro na venda:")
        last_id_venda = false

      }
    });
  } else {
    swal({ title: "Erro!", text: "Preencha todos os campos! Tente Novamente", icon: "error", button: "OK" })
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
      dataType: 'json',
      success: function (result) {
        produtos_relacionados = true;
        switch ($('#forma_pagamento').val()) {
          case 'CREDITO':
            adicionarPagamento(last_id_venda, valor_total, $('.qnt_parcelas').val(), $('#forma_pagamento').val(), $('#select-taxa-credito').val(), $('#data_venda').val(), $('#valor_liquido_credito').val())
            break
          case 'DEBITO':
            console.log($('#select-taxa-debito').val())
            adicionarPagamento(last_id_venda, valor_total, 1, $('#forma_pagamento').val(), $('#select-taxa-debito').val(), $('#data_venda').val(), $('#valor_liquido_debito').val())
            break
          case 'BOLETO':
            adicionarPagamento(last_id_venda, valor_total, $('#qnt_parcelas_boleto').val(), $('#forma_pagamento').val(), $('#taxa-boleto').val(), $('#data_venda').val(), $('#valor_liquido_boleto').val())
            break
          case 'DINHEIRO':
            adicionarPagamento(last_id_venda, valor_total, 1, $('#forma_pagamento').val(), null, $('#data_venda').val(), valor_total)
            break
        }
      },
      error: function (result) {
        console.log(result)
        swal({ title: "Erro!", text: "Erro interno ao adicionar o produto na venda. Tente Novamente", icon: "error", button: "OK" })
      }
    })
  } else
    swal({ title: "Erro!", text: "Preencha todos os campos! Tente Novamente", icon: "error", button: "OK" })

}

function baixaEstoque(id_venda) {
  $.ajax({
    type: "POST",
    url: "/produto_venda/baixa_estoque",
    data: {
      id_venda: id_venda
    },
    dataType: 'json',
    success: function (result) {
      swal({ title: "Sucesso!", text: "Venda cadastrada com sucesso!", icon: "success", button: "OK" })
    },
    error: function (result) {
      swal({ title: "Erro!", text: "Erro interno ao adicionar a venda. Tente Novamente", icon: "error", button: "OK" })
    }
  })
}

/** 
 *  Requisição para insert na tabela de Pagamento
 */

function adicionarPagamento(id_venda, valor_total, qnt_parcelas, forma_pagamento, taxa, data_venda, valor_liquido) {
  if (id_venda != false && valor_total != false && qnt_parcelas != false && forma_pagamento != false && id_venda != false) {
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
        valor_liquido: valor_liquido
      },
      dataType: 'json',
      success: function (result) {
        console.log(result.response_data);
        if (result.response_data == true) {
          baixaEstoque(last_id_venda)
        };
      },
      error: function (result) {
        swal({ title: "Erro!", text: "Ocorreu um erro ao adicionar pagamento da venda! Tente Novamente", icon: "error", button: "OK" })
        console.log(result)
      }
    })
  } else {
    swal({ title: "Erro!", text: "Preencha todos os campos! Tente Novamente", icon: "error", button: "OK" })
  }
}

/**
 * Requisição para adicionar os produtos na tabela
 */

function reloadTableProduct() {
  $.ajax({
    type: "GET",
    url: "/produto/get-by-id?id=" + $('#id_produto').val(),
    dataType: 'json',
    success: function (result) {
      valor_total += ($('#quantidade').val() * result.response_data.preco)
      lista_produtos.push({ id_produto: result.response_data.id, quantidade: $('#quantidade').val(), valor_unit: result.response_data.preco })

      $('#tableProduto').append(`<tr> 
            <td> ${result.response_data.descricao} </td> 
            <td> ${Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(result.response_data.preco.toString())} </td>
            <td> ${$('#quantidade').val()} </td> 
            <td> ${result.response_data.codigo_barra} </td> 
            <td> ${result.response_data.categoria} </td> 
            <td class="actions-list-venda d-flex justify-content-center">                
                <box-icon name="trash" color="#e8ac07" id="${result.response_data.id}" class="btn-icon btn-delete-list"></box-icon>
            </td>
           </tr>`)

      // Função que retira os produtos da lista de compras 
      $('.btn-delete-list').click(function() {        
        lista_produtos.splice(lista_produtos.findIndex(produto => produto.id_produto == result.response_data.id), 1);
        $(this).closest("tr").remove(); // Removendo linha do elemento da tabela
      })

    },
    error: function (result) {
      swal({ title: "Erro!", text: "Ocorreu um erro ao adicionar produto na venda! Tente Novamente", icon: "error", button: "OK" })
    }
  })
}

/**
 * Funções para atualizar os valores na modal de pagamento
 */

function updateTotalValue(qnt_parcelas = null) {
  $('.valor_total').val(valor_total);
}

function updateTaxasValue(valor_taxa) {
  $('#valor_taxa_credito').val((valor_taxa * 100))
  $('#valor_liquido_credito').val((valor_total - (valor_total * valor_taxa)).toFixed(2))

  $('#valor_taxa_debito').val((valor_taxa * 100))
  $('#valor_liquido_debito').val((valor_total - (valor_total * valor_taxa)).toFixed(2))
  $('#valor_liquido_boleto').val(valor_total - valor_taxa)
}

function updateParcelasValue(qnt_parcelas) {
  $('.valor_bruto_parcela').val((valor_total / qnt_parcelas).toFixed(2)) 
  $('.valor_liquido_parcela').val(($('#valor_liquido_credito').val() / qnt_parcelas) == 0 ? ($('#valor_liquido_debito').val() / qnt_parcelas).toFixed(2) : ($('#valor_liquido_credito').val() / qnt_parcelas).toFixed(2))
}

function updateParcelasBoleto(qnt_parcelas){
  $('#valor_bruto_parcela_boleto').val((valor_total / qnt_parcelas).toFixed(2))
  $('#valor_liquido_parcela_boleto').val((($('#valor_liquido_boleto').val()/ qnt_parcelas).toFixed(2)))
  
}

/* 
  Função Inicial da Página
*/

$(document).ready(function () {

  /* 
    Funções dos botões da tabela
  */

  $('#adicionarProduto').click(function () {
    reloadTableProduct();
  })

  $('#forma_pagamento').change(function () {
    updateTotalValue();
    switch ($('#forma_pagamento').val()) {

      case 'CREDITO':
        $('#modal-credito').removeClass('d-none')
        $('#modal-debito').addClass('d-none')
        $('.modal-dinheiro').addClass('d-none')
        $('#modal-boleto').addClass('d-none')
        $('#select-taxa-credito').change(function () {
          updateTaxasValue($('#select-taxa-credito').val());
        })
        break;


      case 'BOLETO':
        $('.modal-credito').addClass('d-none')
        $('.modal-dinheiro').addClass('d-none')
        $('.modal-debito').addClass('d-none')
        $('.modal-boleto').removeClass('d-none')
        $('#taxa-boleto').change(function () {
          updateTaxasValue($('#taxa-boleto').val());
        })
        $('#qnt_parcelas_boleto').change(() => {
          updateParcelasBoleto($('#qnt_parcelas_boleto').val())
        })
        break;

      case 'DEBITO':
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').removeClass('d-none')
        $('.modal-boleto').addClass('d-none')
        $('.modal-dinheiro').addClass('d-none')
        $('#select-taxa-debito').change(function () {
          updateTaxasValue($('#select-taxa-debito').val());
        })
        break;

      case 'DINHEIRO':
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').addClass('d-none')
        $('.modal-boleto').addClass('d-none')
        $('.modal-dinheiro').removeClass('d-none')
        $('#select-taxa-debito').change(function () {
          updateTaxasValue($('#select-taxa-debito').val());         
        })
        break;
      default:
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').addClass('d-none')
        $('.modal-boleto').addClass('d-none')
        $('.modal-dinheiro').addClass('d-none')
        break;
    }
  })

  $('.qnt_parcelas').change(() => {
    updateParcelasValue($('.qnt_parcelas').val())
  })

  /* 
    Função que chama todas as requisições necessárias para inserir uma venda completa

  */
  $('#finalizarVenda').click(async () => {
    await inserirVenda($('#data_venda').val(), $('#id').val())

    if (venda_inserida != false) {
      valor = await relacionarProdutoVenda(last_id_venda, lista_produtos)
    } else {
      swal({ title: "Erro!", text: "Erro interno ao adicionar a venda. Tente Novamente", icon: "error", button: "OK" })
    }
    setInterval(5000)
  })

})
