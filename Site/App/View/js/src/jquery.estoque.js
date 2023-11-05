function addEstoque(id, descricao, preco, quantidade, codigo_barra) {
    if (descricao !== "") {
        $.ajax({
            type: "POST",
            url: "/estoque/save",
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

function getEstoqueById(id) {
    $.ajax({
        type: "GET",
        url: "/estoque/get-by-id?id=" + id,
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

function deleteEstoque(id) {
    $.ajax({
        type: "GET",
        url: "/estoque/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function loadTableEstoque() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
    $('.action-container').delay(1000).removeClass("off");
  
}

$(document).ready(function () {    

    loadTableEstoque();

    $('#situacao').change(()=>{$('#situacao').val() == 'COMPRA' ? $('.estoque-compra').removeClass("off") : $('.estoque-compra').addClass("off")})

    $('.btn-edit').click(function (event) {
        getEstoqueById(event.target.id);
    })

    $('.btn-delete').click(async function (event) {
        await swal({
            title: "Excluir registro",
            text: "Você tem certeza que deseja apagar esse registro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((isConfirm) => {
            if (isConfirm) {
                deleteEstoque(event.target.id);// Executa a função quando o usuário clica em OK   
                window.location.reload(true);     
            } else {
              swal("Cancelado", "Seu registro não foi excluído.", "error");
            }
        }); 
    })

    
})