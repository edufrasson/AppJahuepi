function loadTableProduto() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

$(document).ready(function () {    
    loadTableProduto();   

    $('.btn-edit').click(function (event) {
        getLoginById(event.target.id);
    })

    $('.btn-delete').click(function (event) {
        deleteLogin(event.target.id);

        window.location.reload(true);
    })
})
