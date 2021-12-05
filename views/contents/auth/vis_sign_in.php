<!DOCTYPE html>
<html lang="en">
<?php $this->GetHeader(); ?>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo constant("URL");?>"><b>Iglesia </b>pan de vida</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Registro de nuevo Usuario</p>
        <form action="<?php echo constant("URL");?>controller/c_auth.php" id="formulario" method="post" class="needs-validation" novalidate>
          <div class="input-group mb-3">
            <input type="number" name="user_id" class="form-control" placeholder="Cedula">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" id="password" class="form-control" placeholder="Contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" class="form-control" placeholder="Confirmar contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-2">
              <input type="hidden" name="ope">
              <button type="button" id="btn" onclick="ope.value = this.value" value="Register" class="btn btn-primary btn-block">Registrar</button>
            </div>
          </div>
        </form>
        <p class="mb-0">
          <a href="<?php echo constant("URL");?>auth/login" class="text-center">Ya tengo Cuenta</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <?php $this->GetComplement("scripts"); ?>
  <script>
    $("#btn").click( async () =>{ if($("#formulario").valid()){ $("#formulario").submit(); }})

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
          maxlength: 20,
        },
        password2:{
          required: true,
          minlength: 8,
          maxlength: 20,
          equalTo: "#password",
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
          maxlength: "Maximo de 20 caracteres dpara una contraseña",
          pattern: "Se debe de ingresar una clave mas segura (1 Mayuscula, 1 minuscula, 1 numero y un caracter especial, 8 caracteres minimo)",
        },
        password2:{
          required: "Este campo es obligatorio",
          minlength: "Minimo de 8 caracteres para ingresa una contraseña",
          maxlength: "Maximo de 20 caracteres dpara una contraseña",
          pattern: "Se debe de ingresar una clave mas segura (1 Mayuscula, 1 minuscula, 1 numero y un caracter especial, 8 caracteres minimo)",
          equalTo: "Las contraseñas ingresadas no conciden"
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