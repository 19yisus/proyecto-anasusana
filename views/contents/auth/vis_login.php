<!DOCTYPE html>
<html lang="en">
<?php $this->GetHeader(); ?>
<body class="hold-transition login-page" id="fondo">
  <div class="login-box">
    <div class="login-logo">
      <img src="<?php echo constant("URL");?>views/images/logo.jpeg" alt="Logo" class="img-fluid rounded mx-auto d-block">
    </div>
    <!-- /.login-logo -->
    <div class="card align-middle">
      <div class="card-body login-card-body rounded">
        <p class="login-box-msg">Inicio de sesion</p>
        <form action="<?php echo constant("URL");?>controller/c_auth.php" method="post" id="formulario" class="needs-validation" novalidate>
          <div class="input-group mb-3">
            <input type="number" class="form-control" name="cedula" placeholder="Cedula de la persona">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" class="form-control" name="password" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <input type="hidden" name="ope">
              <button type="button" onclick="ope.value = this.value" value="Login" class="btn btn-warning btn-block" id="btn">Login</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?php echo constant("URL");?>auth/recuperar_clave">Olvide mi contraseña</a>
        </p>
        <p class="mb-0">
          <a href="<?php echo constant("URL");?>auth/sign_in" class="text-center">Registro de nuevo usuario</a>
        </p>
      </div>
    </div>
  </div>
  <?php $this->GetComplement("scripts"); ?>
  <script>
    $("#btn").click( async () =>{ if($("#formulario").valid()) $("#formulario").submit(); })

    $("#formulario").validate({
      rules:{
        user_id:{
          required: true,
          minlength: 7,
          maxlength: 8,
          number: true,
        },
        password:{
          required: true,
          minlength: 8,
          maxlength: 50,
        }
      },
        messages:{
          user_id:{
          required: "Este campo es obligatorio",
          minlength: "Minimo 7 caracteres numericos para la cedula",
          maxlength: "Maximo 8 caracteres numericos para la cedula",
          number: "Solo se aceptan numeros",
        },
        password:{
          required: "Este campo es obligatorio",
          minlength: "Minimo de 8 caracteres para ingresa una contraseña",
          maxlength: "Maximo de 50 caracteres dpara una contraseña",
          pattern: "Se debe de ingresar una clave mas segura (1 Mayuscula, 1 minuscula, 1 numero y un caracter especial, 8 caracteres minimo)",
        }
        },
        errorElement: "span",
        errorPlacement: function (error, element){
            error.addClass("invalid-feedback");
            element.closest(".input-group").append(error);
        },
        highlight: function (element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        }
    });
  </script>
</body>
</html>