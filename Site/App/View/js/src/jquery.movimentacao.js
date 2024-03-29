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

function loadTableMovimentacao() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function (){
    loadTableMovimentacao();

    /*$('.btn-edit').click(function(event){
        getMovimentacaoById(event.target.id);
    })*/

      
    $("#filtro_ano").change(() => {
        if ($("#filtro_ano").val() != "") {
          let link = "/relatorio_movimentacao?ano=" + $("#filtro_ano").val();
          $("#btnFiltrar").attr("href", link);
        } else $("#btnFiltrar").attr("href", "/relatorio_movimentacao");
      });
      $("#filtro_mes").change(() => {
        if ($("#filtro_ano").val() != "" && $("#filtro_mes").val() != "") {
          let link =
            "/relatorio_movimentacao?ano=" +
            $("#filtro_ano").val() +
            "&mes=" +
            $("#filtro_mes").val();
          $("#btnFiltrar").attr("href", link);
        }
    
        if ($("#filtro_ano").val() != "" && $("#filtro_mes").val() == "") {
          let link = "/relatorio_movimentacao?ano=" + $("#filtro_ano").val();
          $("#btnFiltrar").attr("href", link);
        }
      });
    
      $("#btnFiltrar").click(() => {
        if ($(this).attr("href") == "#") {
          swal({
            title: "Erro!",
            text: "Selecione corretamente os valores dos filtros. Tente Novamente",
            icon: "error",
            button: "OK",
          });
        }
      });
  

    $('.btn-delete').click(async function(event){
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
                deleteMovimentacao(event.target.id);// Executa a função quando o usuário clica em OK   
                window.location.reload(true);     
            } else {
              swal("Cancelado", "Seu registro não foi excluído.", "error");
            }
        }); 
    })
})