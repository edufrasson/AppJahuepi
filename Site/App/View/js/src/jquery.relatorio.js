var arrayProdutos = Array();
var arrayParcelas = Array();

function getVendaById(id) {
    $.ajax({
        type: "GET",
        url: "/venda/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtNome').val(result.response_data.descricao);
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteVenda(id) {
    $.ajax({
        type: "GET",
        url: "/venda/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function getAllProducts(id_venda) {
    $.ajax({
        type: "GET",
        url: "/venda/get-produtos?id_venda=" + id_venda,
        dataType: 'json',
        success: async (result) => {
            arrayProdutos = result.response_data
        },
        error: () => {
            console.log(' :( ')
        }

    })
}

function loadTableVenda() {
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");

}


$(document).ready(function () {
    loadTableVenda();

    $('.open-produtos').click((event) => {
        getAllProducts(event.target.id);
        arrayProdutos.forEach(element => {
            $('#tableProdutos').append(`<tr> 
            <td> ${element.descricao} </td> 
            <td> ${Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(element.valor_unit.toString())} </td> 
            <td> ${element.quantidade} </td>         
            <td class="actions-list">                
                <box-icon name="trash" color="#e8ac07" id="${element.id}" class="btn-icon btn-delete-list"></box-icon>
            </td>
           </tr>`)
        })
    })

    $('.btn-edit').click(function (event) {
        getVendaById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteVenda(event.target.id);

        window.location.reload(true);
    })
})