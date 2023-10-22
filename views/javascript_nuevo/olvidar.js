$(document).ready(() => {


    $('#btn-recuperar').click(async e =>{
        if ($('#forgot-password').valid()){
            Swal.fire(
                '¡Verificado!',
                '¡Cedula confirmada exitosamente!',
                'success'
              )
          $(location).attr('href', '../views/login.html')
        }
    })

    $('#forgot-password').validate({
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