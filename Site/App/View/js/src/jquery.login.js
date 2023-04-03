var isVisible = false;

$(document).ready(function(){
    $('#verSenha').click(() => {
        if(isVisible == false){
            $("#senha").prop("type", "text");
            isVisible = true;
        }else{
            $("#senha").prop("type", "password");
            isVisible = false;
        }
    })
})