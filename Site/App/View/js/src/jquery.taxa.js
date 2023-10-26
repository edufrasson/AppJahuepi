function addTaxa(id, descricao) {
    if (descricao !== "") {
        $.ajax({
            type: "POST",
            url: "/taxa/save",
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

function getTaxaById(id) {
    $.ajax({
        type: "GET",
        url: "/taxa/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtCodigo').val(result.response_data.codigo);
            $('#txtValor').val(result.response_data.valor * 100);
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteTaxa(id) {
    $.ajax({
        type: "GET",
        url: "/taxa/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function loadTableTaxa() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function () {    
    loadTableTaxa();

    $('.btn-edit-taxa').click(function (event) {
        getTaxaById(event.target.id);
    })

    $('.btn-delete-taxa').click(async function (event) {
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
                deleteTaxa(event.target.id);// Executa a função quando o usuário clica em OK   
                window.location.reload(true);     
            } else {
              swal("Cancelado", "Seu registro não foi excluído.", "error");
            }
        }); 
    })
})