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
        url: "/venda/get-produtos?id=" + id_venda,
        dataType: 'json',
        success: async (result) => {            
            result.response_data.forEach(element => {
                $('#tableProdutos').append(`<tr> 
                <td> ${element.descricao} </td> 
                <td> ${Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(element.valor_unit.toString())} </td> 
                <td> ${element.quantidade} </td>        
               
               </tr>`)
            })
        },
        error: () => {
            console.log(' :( ')
        }

    })
}

function getAllParcelas(id_venda) {
    $.ajax({
        type: "GET",
        url: "/venda/get-parcelas?id=" + id_venda,
        dataType: 'json',
        success: async (result) => {            
            result.response_data.forEach(element => {
                $('#tableParcelas').append(`<tr> 
                <td> ${element.indice} </td> 
                <td> ${Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(element.valor_parcela.toString())} </td> 
                <td> ${element.data_parcela} </td>        
                <td> ${element.status} </td>        
               
               </tr>`)
            })
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
        event.preventDefault();
        $('#tableProdutos').empty();

        getAllProducts(event.target.id);     
        
    })

    $('.open-parcelas').click(function (e) { 
        e.preventDefault();
        $('#tableParcelas').empty();

        getAllParcelas(e.target.id);     
    });

    $('.btn-edit').click(function (event) {
        getVendaById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteVenda(event.target.id);

        window.location.reload(true);
    })
})