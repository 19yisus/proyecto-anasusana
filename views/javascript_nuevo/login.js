$(document).ready(() => {


  $("#form-btn__submit").click(async (e) => {
    if ($("#login-content").valid()) {
      e.preventDefault();
      Swal.fire("¡Bienvenido!", "¡Inicio de sesión exitoso!", "success");
    }
  });

  $("#login-content").validate({
    rules: {
      username: {
        required: true,
        minlength: 3,
        lettersonly: true,
      },
      password: {
        required: true,
        minlength: 8,
        passwordsecure: true,
      },
    },
    messages: {
      username: {
        required: "Campo vacío",
        minlength: "No es un nombre válido",
      },
      password: {
        required: "Campo vacío",
        minlength: "Contraseña inválida",
      },
    },
  });
});
