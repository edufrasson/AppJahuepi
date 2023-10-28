

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

function addUsuario(id, email, senha) {
    if (email !== "" && senha !== "") {
        $.ajax({
            type: "POST",
            url: "/login/save",
            data: {
                id: id,
                email: email,
                senha: senha
            },
            dataType: 'json',
            success: function (result) {
                console.log(result.response_data)
            },
            error: function (result) {
                console.log(result)
            }
        });
    }else{
        alert("Digite todos os campos!")
    }
}

function getUsuarioById(id) {
    $.ajax({
        type: "GET",
        url: "/login/get-by-id?id=" + id,
        dataType: 'json',
        success: function (result) {
            $('#txtEmail').val(result.response_data.email);
            $('#txtSenha').val(result.response_data.senha)
            $('#id').val(result.response_data.id);
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function deleteLogin(id) {
    $.ajax({
        type: "GET",
        url: "/login/delete?id=" + id,
        dataType: 'json',
        success: function (result) {
            console.log(result)
        },
        error: function (result) {
            console.log(result)
        }
    });
}

function loadTableLogin() {   
    $('.spinner-border').delay(1000).hide();
    $('.table-style').delay(1000).removeClass("off");
  
}

function validarSenha() {  
    if ( $('#txtSenha').val() != $('#txtConfirmarSenha').val()) {
      $('#txtConfirmarSenha').addClass("border border-danger")
      return false;
    } 
    else 
    {
      return true;
    }
  }

$(document).ready(function () {    
    loadTableLogin();

    $('#adicionarUsuario').click(() => {
        var condicao = validarSenha()
        if (condicao == true){
            addUsuario($('#id').val(), $('#txtEmail').val(), $('#txtSenha').val())
            window.location.reload(true);
        }else
            swal({
                title: "Erro!",
                text: "As senhas não batem!",
                icon: "error"
            })
            //$('#error').text("As senhas não batem!")
    })

    $('.btn-edit').click(function (event) {
        getLoginById(event.target.id);
    })

    $('.btn-delete').click(async function (event) {
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
                deleteLogin(event.target.id);// Executa a função quando o usuário clica em OK   
                window.location.reload(true);     
            } else {
              swal("Cancelado", "Seu registro não foi excluído.", "error");
            }
        }); 
    })
})

