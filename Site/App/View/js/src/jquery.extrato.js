function addExtrato(id, valor, dataExtrato)
{
    if(descricao !== "")
    {
        $.ajax({
            type: "POST",
            url: "/extrato/save",
            data: {
                id: id,
                valor: valor,
                dataExtrato: dataExtrato
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

function getExtratoById(id)
{
    $.ajax({
        type: "GET",
        url: "/extrato/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtValor').val(result.response_data.valor);
            $('#txtExtrato').val(result.response_data.dataExtrato);
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteExtrato(id)
{
    $.ajax({
        type: "GET",
        url: "/extrato/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

$(document).ready(function (){
    $('.btn-edit').click(function(event){
        getExtratoById(event.target.id);
    })

    $('.btn-delete').click(function(event){
        deleteExtrato(event.target.id);

        window.location.reload(true);
    })
})