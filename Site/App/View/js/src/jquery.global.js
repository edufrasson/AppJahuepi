$(document).ready(function(){
    $('.table-style').DataTable({       
        "language": {
            "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 - 0 de 0 registros",
            "infoFiltered":   "(Filtrado em _MAX_ registros totais)",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
            "search": "Pesquisar:",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "zeroRecords": "Nenhum registro encontrado!",
          }       
    });

    
})