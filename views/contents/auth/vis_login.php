<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/login.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/generalStyles.css">
  <title>Login</title>
</head>

<body class="hold-transition login-page" id="fondo">
  <div class="full-content">
    <div class="theme-toggler">
      <span class="material-symbols-sharp active inactive">light_mode</span>
      <span class="material-symbols-sharp">dark_mode</span>
    </div>

    <div class="content__section" id="inicio">
      <div class="full__subcontent full-content__one">
        <div class="box-content img-toggler">
          <img src="<?php echo constant("URL"); ?>views/images/logo.svg" alt="" srcset="" class="logo">
        </div>
      </div>
      <div class="full__subcontent full-content__two">
        <form action="<?php echo constant("URL"); ?>controller/c_auth.php" autocomplete="off" method="post" id="login-content" class="input-content">
          <div class="input-subcontent">
            <input class="input" type="text" id="cedula" name="cedula" placeholder="Usuario">
            <span><i class="fas fa-user"></i></span>
          </div>

          <div class="input-subcontent">
            <input class="input" id="password" type="password" name="password" placeholder="Password">
            <span class="" id="viewPassword"><i class="fas fa-eye"></i></span>
          </div>


          <div class="btn-content">
            <input type="hidden" name="ope">
            <button class="btn-content__btn" id="btn" onclick="ope.value = this.value" value="Login" type="button">Iniciar Sesion</button>
          </div>
          <div class="content-two__forgot">
            <a class="olvidasteTC" href="<?php echo constant("URL"); ?>auth/recuperar_clave">¿Olvidaste tu contraseña?</a>
            <a class="registrarse" href="<?php echo constant("URL"); ?>auth/sign_in">Registrarse</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- <div class="login-box">
    <div class="login-logo">
      <img src="<?php //echo constant("URL"); 
                ?>views/images/logo.jpg" style="width:15rem;" alt="Logo" class="img-fluid rounded mx-auto d-block">
    </div>
  
    <div class="card align-middle">
      <div class="card-body login-card-body rounded">
        <p class="login-box-msg">Inicio de Sesión</p>
        <form action="<?php //echo constant("URL"); 
                      ?>controller/c_auth.php" autocomplete="off" method="post" id="formulario" class="needs-validation" novalidate>
          <div class="input-group mb-3">
            <input type="number" class="form-control" name="cedula" placeholder="Cédula de la Persona">
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
              <button type="button" onclick="ope.value = this.value" value="Login" class="btn btn-warning btn-block" id="btn">Ingresar</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?php //echo constant("URL"); 
                    ?>auth/recuperar_clave">Olvidé mi Contraseña</a>
        </p>
        <p class="mb-0">
          <a href="<?php //echo constant("URL"); 
                    ?>auth/sign_in" class="text-center">Registro de Nuevo Usuario</a>
        </p>
      </div>
    </div>
  </div> -->
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/jquery.js"></script>
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/jquery.validate.js"></script>
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/sweetAlert.js"></script>
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/toggleMode.js"></script>
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/login.js"></script>
  <?php $this->GetComplement("scripts"); ?>
  <script>
    $("#btn").click(async () => {
      if ($("#login-content").valid()) $("#login-content").submit();
    })

    $("#login-content").validate({
      rules: {
        cedula: {
          required: true,
          minlength: 7,
          maxlength: 8,
          number: true,
        },
        password: {
          required: true,
          minlength: 8,
          maxlength: 50,
        }
      },
      messages: {
        cedula: {
          required: "Este Campo es Obligatorio",
          minlength: "Mínimo 7 caracteres numéricos para la cédula",
          maxlength: "Máximo 8 caracteres numéricos para la cédula",
          number: "Sólo se Aceptan Números",
        },
        password: {
          required: "Este Campo es Obligatorio",
          minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
          maxlength: "Máximo de 50 caracteres para una Contraseña",
          pattern: "Se debe de ingresar una Clave mas segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un caracter especial, 8 caracteres mínimo)",
        }
      },
      errorElement: "span",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        element.closest(".input-group").append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  </script>
</body>

</html>