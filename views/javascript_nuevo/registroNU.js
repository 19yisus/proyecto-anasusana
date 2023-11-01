$(document).ready(() => {
  $("#btn-registrar").click(async (e) => {
    if ($("#register-content").valid()) {
      e.preventDefault();
      Swal.fire(
        "¡Registrado!",
        "¡Registro de nuevo usuario confirmado!",
        "success"
      );
    }
  });

});
