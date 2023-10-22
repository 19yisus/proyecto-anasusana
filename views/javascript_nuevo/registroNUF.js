
$(document).ready(() => {


    jQuery.validator.addMethod("passwordsecure", function(value, e) {
        return this.optional(e) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/i.test(value);
    }, 'Contraseña inválida');
    
    $('#register_userN').click(async e =>{
        if ($('#formRU__register').valid()){
            e.preventDefault();
            Swal.fire(
                '¡Registrado!',
                '¡Registro de nuevo usuario confirmado!',
                'success'
            );
            $(location).attr('href', '../views/login.html');
        }
        
    })

    $('#formRU__register').validate({
        rules: {
            pregunta1: {
                required: true
            },
            pregunta2: {
                required: true
            },
            respuesta1: {
                required: true
            },
            respuesta2: {
                required: true
            },
            password: {
                required: true,
                passwordsecure: true
            },
            password2: {
                required: true,
                equalTo:'#password',
                passwordsecure: true 
            }
        },
        messages: {
            pregunta1: {
                required: 'Selecciona una opcion'
            },
            respuesta1: {
                required:'Campo vacío'
            },
            respuesta2: {
                required:'Campo vacío'
            },
            password: {
                required: 'Campo vacío', 
            },
            password2: {
                required: 'Campo vacío',
                equalTo: 'Las contraseñas no coinciden'
            }
        }
    })

    $('#viewPassword').on('click', function() {
        $('#password').attr('type', function(index, attr) {
            $('#viewPassword i').toggleClass('fa-eye-slash').toggleClass('fa-eye');
            return attr == 'text'? 'password' : 'text';
        })
      })
      $('#viewPassword2').on('click', function() {
        $('#password2').attr('type', function(index, attr) {
            $('#viewPassword2 i').toggleClass('fa-eye-slash').toggleClass('fa-eye');
            return attr == 'text'? 'password' : 'text';
        })
      })
})


