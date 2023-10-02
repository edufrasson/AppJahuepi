function addMovimentacao(id, valor, dataMovimentacao)
{
    if(descricao !== "")
    {
        $.ajax({
            type: "POST",
            url: "/movimentacao/save",
            data: {
                id: id,
                valor: valor,
                dataMovimentacao: dataMovimentacao
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

function getMovimentacaoById(id)
{
    $.ajax({
        type: "GET",
        url: "/movimentacao/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtValor').val(result.response_data.valor);
            $('#txtMovimentacao').val(result.response_data.dataMovimentacao);
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteMovimentacao(id)
{
    $.ajax({
        type: "GET",
        url: "/movimentacao/delete?id=" + id,
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

$(document).ready(function (){
    loadTableCategoria();

    $('.btn-edit').click(function(event){
        getMovimentacaoById(event.target.id);
    })

    $('.btn-delete').click(function(event){
        deleteMovimentacao(event.target.id);

        window.location.reload(true);
    })
})