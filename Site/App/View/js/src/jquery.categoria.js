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

<<<<<<< HEAD
function loadTableCategoria() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function () {    
    loadTableCategoria();
=======
$(document).ready(function () {
    $('.table-style').DataTable({
        "language": {
            "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 - 0 de 0 registros",
            "infoFiltered": "(Filtrado em _MAX_ registros totais)",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            },
            "search": "Pesquisar:",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "Nenhum registro encontrado!",
        },
        "ajax": {
            "url": "/categoria/get-all"
        }
    });
>>>>>>> c6a5d8ca6c71072b7d9360ea22c352628ce7a3be

    $('.btn-edit').click(function (event) {
        getCategoriaById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteCategoria(event.target.id);

        window.location.reload(true);
    })
})