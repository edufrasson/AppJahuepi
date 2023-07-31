lista_produtos = Array();


function reloadTableProduct() {
    $.ajax({
        type: "GET",
        url: "/produto/get-by-id?id=" + $('#id_produto').val(),
        dataType: 'json',
        success: function (result) {
          lista_produtos.push({ id_produto: result.response_data.id, quantidade: $('#quantidade').val() })
      
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

$(document).ready(function () {

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

    $('#forma_pagamento').change(function(){
        switch ($('#selectPagamento').val()) {
            case 'CARTAO':
              $('#modal-credito').removeClass('d-none')
              $('#modal-debito').addClass('d-none')
              $('#modal-boleto').addClass('d-none')
              break;     

      
            case 'MANUAL':
              $('#modal-credito').addClass('d-none')
              $('#modal-debito').addClass('d-none')
              $('#modal-boleto').removeClass('d-none')
              break;

            case 'DEBITO':
                $('#modal-credito').addClass('d-none')
                $('#modal-debito').removeClass('d-none')
                $('#modal-boleto').addClass('d-none')
                break;  
      
            default:
              $('#modal-credito').addClass('d-none')
              $('#modal-debito').addClass('d-none')
              $('#modal-boleto').addClass('d-none')
              break;
          }
    })

})
