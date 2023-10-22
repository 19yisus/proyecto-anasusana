$(document).ready(() =>{

    jQuery.validator.addMethod("lettersonly", function(value, e) {
        return this.optional(e) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
      }, 'No es un nombre válido');
    
    jQuery.validator.addMethod("passwordsecure", function(value, e) {
        return this.optional(e) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/i.test(value);
    }, 'Contraseña inválida');
    
      

    $('#form-btn__submit').click(async e =>{
        if ($('#login-content').valid()){
            e.preventDefault();
            Swal.fire(
                '¡Bienvenido!',
                '¡Inicio de sesión exitoso!',
                'success'
            );
        }
        
    })

    $('#login-content').validate({
        rules: {
            username : {
                required: true,
                minlength: 3,
                lettersonly: true
            },
            password : {
                required: true,
                minlength: 8,
                passwordsecure: true
            }
        },
        messages: {
            username: {
                required: 'Campo vacío',
                minlength: 'No es un nombre válido',
            },
            password: {
                required: 'Campo vacío',
                minlength: 'Contraseña inválida'
            }
        },
    });



    $('#viewPassword').on('click', function() {
        $('#password').attr('type', function(index, attr) {
            $('#viewPassword i').toggleClass('fa-eye-slash').toggleClass('fa-eye');
            return attr == 'text'? 'password' : 'text';
        })
      })
    
})