  function loadTableRelatorio() {
    $(".spinner-border").delay(1000).hide();
    $(".table-style").delay(1000).removeClass("off");
  }
  
  $(document).ready(function () {
    loadTableRelatorio();
  
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

   
  });
  