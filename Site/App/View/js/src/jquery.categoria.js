function addCategoria(id, descricao) {
    if (descricao !== "") {
        $.ajax({
            type: "POST",
            url: "/categoria_produto/save",
            data: {
                id: id,
                descricao: descricao
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

function getCategoriaById(id) {
    $.ajax({
        type: "GET",
        url: "/categoria_produto/get-by-id?id=" + id,
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

function deleteCategoria(id) {
    $.ajax({
        type: "GET",
        url: "/categoria_produto/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function loadTableCategoria() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function () {    
    loadTableCategoria();

    $('.btn-edit').click(function (event) {
        getCategoriaById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteCategoria(event.target.id);

        window.location.reload(true);
    })
})