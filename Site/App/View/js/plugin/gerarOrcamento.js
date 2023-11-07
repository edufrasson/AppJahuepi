function gerarOrcamento(prop) {
  $.ajax({
    type: "GET",
    dataType: "html",
    url: "/template",        
    success: function (html) {
        let orcamento = $('.orcamento').html();
        $('.orcamento').html(html);
        $('.orcamento').find("#nome_cliente").val(prop.nome_cliente)
        $('.orcamento').find("#num_orcamento").val(prop.num_orcamento)
        $('.orcamento').find("#dataDia").val(prop.data)
        $('.orcamento').find("#valor_total").val(prop.valor_total)
        prop.arr_produtos.forEach(produto => {
            $('.orcamento').find("#tableOrcamento").append(
              `
              <tr>
              <td width="76" valign="top">
                <p align="center">${produto.quantidade}</p>
              </td>
              <td width="387" valign="top">
                <p align="center">
                  ${produto.descricao}
                </p>
              </td>
              <td width="104" valign="top">
                ${produto.valor_unit}
              </td>
              <td width="132" valign="top">
                ${produto.valor_unit * produto.quantidade}
              </td>
            </tr>
              `
            )
        });
        
        console.log($('.orcamento').find("#tableOrcamento").val())
        console.log($('.orcamento').html())
    },
    error: function (html) {
      console.log(html);
    },
  });
}
