<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" id="scriptFaturamentoMes">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(loadFaturamentoMes);
    function loadFaturamentoMes()
    {
      $.ajax({
          url: "/movimentacao/faturamento-mes",
          dataType: "JSON",
          success: function(jsonData) 
          {
            console.log(jsonData)
            var tableData = new google.visualization.DataTable();

            tableData.addColumn('string', 'Mês')
            tableData.addColumn('number', 'Total')
            
            /*var dataArray = [
              ['Faturamento', 'Mês' ],
            ];*/
            console.log(jsonData)
            for (var i = 0; i < jsonData.response_data.length; i++){
              console.log(jsonData.response_data[i]) 
                tableData.addRow([jsonData.response_data[i].mes, parseFloat(jsonData.response_data[i].total_entrada)]);
                
            }
              
            
            var options = {
              
              is3D: true,
            };

           
            var chart = new google.visualization.ColumnChart(document.getElementById('faturamento-mes'));
                chart.draw(tableData, options);
          }
      });
    }
</script>

<script type="text/javascript" id="scriptProdutoMaisVendido">    
    google.charts.setOnLoadCallback(loadProdutoMaisVendido);
    function loadProdutoMaisVendido()
    {
      $.ajax({
          url: "/produto/mais-vendido",
          dataType: "JSON",
          success: function(jsonData) 
          {
           
            var tableData = new google.visualization.DataTable();

            
            tableData.addColumn('string', 'Produto')
            tableData.addColumn('number', 'Quantidade')            
            /*var dataArray = [
              ['Faturamento', 'Mês' ],
            ];*/
           
            for (var i = 0; i < jsonData.response_data.length; i++){      
                console.log(jsonData.response_data[i])          
                tableData.addRow( [jsonData.response_data[i].produto, parseFloat(jsonData.response_data[i].quantidade) ]);
                
            }
              
            
            var options = {            
              is3D: false,
            };

           
            var chart = new google.visualization.PieChart(document.getElementById('mais-vendido'));
                chart.draw(tableData, options);
          }
      });
    }
</script>
