$(document).ready(() => {


    $('#btn-recuperar').click(async e =>{
        if ($('#question-content').valid()){
            e.preventDefault();
            Swal.fire(
                '¡Verificado!',
                '¡Cedula confirmada exitosamente!',
                'success'
              )
          $(location).attr('href, .././views./preguntaS.html')
        }
    })

    $('#question-content').validate({
        rules: {
            respuesta1: {
                required: true,
            },
            respuesta2: {
                required: true
            }
        },
        messages: {
            respuesta1: {required: 'Campo vacío'},
            respuesta2:{required:'Campo vacío'}
        }
    })
})


