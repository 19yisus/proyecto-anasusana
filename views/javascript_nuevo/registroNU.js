


$(document).ready(() => {

    $('#btn-registrar').click(async e =>{
        if ($('#register-content').valid()){
            e.preventDefault();
            Swal.fire(
                '¡Registrado!',
                '¡Registro de nuevo usuario confirmado!',
                'success'
            );
            $(location).attr('href', '../views/registroNUF.html');
        }
        
    })

    $('#register-content').validate({
        rules: {
            cedulaR: {
                required: true,
                number: true,
                minlength: 7,
                maxlength: 8,
            }
        },
        messages: {
            cedulaR: {
                required: 'Campo vacío',
                number: 'Debe ser un numero',
                minlength: 'Cédula inválida',
                maxlength: 'Cédula inválida',
            }
        }
    })
})

