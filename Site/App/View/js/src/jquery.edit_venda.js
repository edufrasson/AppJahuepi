var valor_total = 0;
var lista_produtos = Array();

function deleteProduto(id_prod){
    
}

$(document).ready(function () {
    $('.btn-delete-list').click(async function (event) {
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
                produto_deletado = lista_produtos.find((e) => e.id_produto == event.target.id)
                lista_produtos = lista_produtos.filter((e) => e.id_produto == event.target.id)
                $(this).closest("tr").remove(); // Removendo linha do elemento da tabela
                   
            } else {
              swal("Cancelado", "Seu registro não foi excluído.", "error");
            }
        }); 
    })

    

    $('#adicionarProduto').click(function(){

    })

    if ($("#id_venda").val() != "") {
        console.log($("#id_venda").val());
        $.ajax({
          type: "GET",
          url: "/produto_venda/get-by-id",
          data: {
            id: $("#id_venda").val(),
          },
          dataType: "json",
          success: function (result) {
            console.log(result);
            result.response_data.forEach((element) => {
              lista_produtos.push({
                id_produto: element.id_produto,
                quantidade: element.quantidade,
                valor_unit: element.preco,
                codigo_barra: element.codigo_barra,
                descricao: element.descricao,
              });
    
              valor_total += element.quantidade * element.preco;
            });
          },
          error: function (result) {
            console.log(result);
          },
        });
    }

})