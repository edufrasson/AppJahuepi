function addProduto(id, descricao, preco, quantidade, codigo_barra) {
    if (descricao !== "") {
        $.ajax({
            type: "POST",
            url: "/produto/save",
            data: {
                id: id,
                descricao: descricao,
                preco: preco,
                quantidade: quantidade,
                codigo_barra: codigo_barra
            },
            dataType: 'json',
            success: function (result) {
                console.log(result.response_data)
            },
            error: function (result) {
                console.log(result)
            }
        });
    }
}

function getProdutoById(id) {
    $.ajax({
        type: "GET",
        url: "/produto/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtNome').val(result.response_data.descricao);
            $('#txtPreco').val(result.response_data.preco);
            $('#txtQuantidade').val(result.response_data.quantidade);
            $('#txtCodigo_Barra').val(result.response_data.codigo_barra);
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteProduto(id) {
    $.ajax({
        type: "GET",
        url: "/produto/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function loadTableProduto() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function () {   
   
    

    loadTableProduto();

    $('.btn-edit').click(function (event) {
        getProdutoById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteProduto(event.target.id);

        window.location.reload(true);
    })

    
})