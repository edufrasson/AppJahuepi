lista_produtos = Array();

function loadTableProduto() {
    $('.spinner-border').delay(1000).hide();
    $('.table').delay(1000).removeClass("off");

}

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
                <box-icon name="edit" color="#e8ac07" id="${result.response_data.id}" data-bs-toggle="modal" data-bs-target="#modalProduto" class="btn-icon btn-edit"></box-icon>
                <box-icon name="trash" color="#e8ac07" id="${result.response_data.id}" class="btn-icon btn-delete"></box-icon>
            </td>
           </tr>`)
          
        },
        error: function (result) {
          alert("erro");
        }
      })  
}

$(document).ready(function () {
    loadTableProduto();

    $('.btn-edit').click(function (event) {
        getLoginById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteLogin(event.target.id);

        window.location.reload(true);
    })

    $('#adicionarProduto').click(function () {       
        reloadTableProduct();
    })


})
