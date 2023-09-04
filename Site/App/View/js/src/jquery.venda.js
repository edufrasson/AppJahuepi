

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
        switch ($('#forma_pagamento').val()) {
          case 'CARTAO':
            adicionarPagamento(last_id_venda, valor_total, $('.qnt_parcelas').val(), $('#forma_pagamento').val(), $('#select-taxa-credito').val())
            break
  
          case 'DEBITO':
            adicionarPagamento(last_id_venda, valor_total, $('.qnt_parcelas').val(), $('#forma_pagamento').val(), $('#select-taxa-debito').val())
            break
  
          case 'MANUAL':
            adicionarPagamento(last_id_venda, valor_total, $('.qnt_parcelas').val(), $('#forma_pagamento').val(), $('#taxa-boleto').val())
            break
        }
      },
      error: function (result) {
        swal({ title: "Erro!", text: "Erro interno ao adicionar o produto na venda. Tente Novamente", icon: "error", button: "OK" })
      }
    })
  } else
    swal({ title: "Erro!", text: "Preencha todos os campos! Tente Novamente", icon: "error", button: "OK" })

}

/** 
 *  Requisição para insert na tabela de Pagamento
 */

function adicionarPagamento(id_venda, valor_total, qnt_parcelas, forma_pagamento, taxa) {
  if (id_venda != false && valor_total != false && qnt_parcelas != false && forma_pagamento != false && id_venda != false) {
    $.ajax({
      type: "POST",
      url: "/pagamento/save",
      data: {
        id_venda: id_venda,
        valor_total: valor_total,
        qnt_parcelas: qnt_parcelas,
        forma_pagamento: forma_pagamento,
        taxa: taxa
      },
      dataType: 'json',
      success: function (result) {
        if (result.response_data != false)
          produtos_relacionados = true;


      },
      error: function (result) {
        produtos_relacionados = false;
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
            <td class="actions-list">                
                <box-icon name="trash" color="#e8ac07" id="${result.response_data.id}" class="btn-icon btn-delete-list"></box-icon>
            </td>
           </tr>`)

      $('.btn-delete-list').click(function (event) {
        console.log("chegou aqui")

        lista_produtos.splice(lista_produtos.findIndex(produto => produto.id_produto == result.response_data.id), 1);

        $(this).closest("tr").remove(); // You can remove row like this

        //window.location.reload(true);
      })

    },
    error: function (result) {
      alert("erro");
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
  $('#valor_liquido_credito').val((valor_total - (valor_total * valor_taxa)))

  $('#valor_taxa_debito').val((valor_taxa * 100))
  $('#valor_liquido_debito').val((valor_total - (valor_total * valor_taxa)))
}

function updateParcelasValue(qnt_parcelas) {
  $('.valor_bruto_parcela').val(valor_total / qnt_parcelas)
  $('.valor_liquido_parcela').val(($('#valor_liquido_credito').val() / qnt_parcelas) == 0 ? $('#valor_liquido_debito').val() / qnt_parcelas : $('#valor_liquido_credito').val() / qnt_parcelas)
}

/* 
  Função Inicial da Página
*/

$(document).ready(function () {

  /* 
    Funções dos botões da tabela
  */

  $('.btn-edit').click(function (event) {
    getLoginById(event.target.id);
  })

  $('.btn-delete').click(function (event) {
    deleteLoginById(event.target.id);

    //window.location.reload(true);
  })

  $('#adicionarProduto').click(function () {
    reloadTableProduct();
  })

  $('#forma_pagamento').change(function () {
    updateTotalValue();
    switch ($('#forma_pagamento').val()) {

      case 'CARTAO':
        $('#modal-credito').removeClass('d-none')
        $('#modal-debito').addClass('d-none')
        $('#modal-boleto').addClass('d-none')
        $('#select-taxa-credito').change(function () {
          updateTaxasValue($('#select-taxa-credito').val());
        })
        break;


      case 'MANUAL':
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').addClass('d-none')
        $('.modal-boleto').removeClass('d-none')

        break;

      case 'DEBITO':
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').removeClass('d-none')
        $('.modal-boleto').addClass('d-none')
        $('#select-taxa-debito').change(function () {
          updateTaxasValue($('#select-taxa-debito').val());
        })
        break;

      default:
        $('.modal-credito').addClass('d-none')
        $('.modal-debito').addClass('d-none')
        $('.modal-boleto').addClass('d-none')
        break;
    }
  })



  $('.qnt_parcelas').change(() => {
    updateParcelasValue($('.qnt_parcelas').val())
  })

  /* 
    Função que chama todas as requisições necessárias para inserir uma venda completa

    - Tabela Venda OK
    - Tabela Produto_Venda OK
    - Tabela Pagamento 
  */
  $('#finalizarVenda').click(async () => {
    await inserirVenda($('#data_venda').val(), $('#id').val())

    if (venda_inserida != false) {
      valor = await relacionarProdutoVenda(last_id_venda, lista_produtos)
      console.log(produtos_relacionados)
    } else {
      swal({ title: "Erro!", text: "Erro interno ao adicionar a venda. Tente Novamente", icon: "error", button: "OK" })
    }
    setInterval(5000)
 



  })

})
