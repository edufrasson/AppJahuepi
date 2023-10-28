<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
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

            tableData.addColumn('date', 'Mês')
            tableData.addColumn('number', 'Faturamento')
            
            /*var dataArray = [
              ['Faturamento', 'Mês' ],
            ];*/
            console.log(jsonData)
            for (var i = 0; i < jsonData.length; i++){
                console.log(jsonData[i].mes)
                tableData.addRow([parseFloat(jsonData[i].total_entrada), jsonData[i].mes]);
                
            }
              
            
            var options = {
              title: 'Faturamento por M',
              is3D: true,
            };

           
            var chart = new google.visualization.ColumnChart(document.getElementById('faturamento-mes'));
                chart.draw(tableData, options);
          }
      });
    }
</script>