<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/login.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/generalStyles.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/toastr/toastr.min.css">
  <style>
    .captcha-image {
      background-color: white;
    }

    .section__nuevaC .content-requirement {
      width: 330px;
      margin-top: 20px;
    }

    .content-requirement span:nth-child(1) {
      font-size: 1.2rem;
    }

    .content-requirement .requirement-list {
      margin-top: 20px;
    }

    .requirement-list li {
      list-style: none;
      font-size: 1rem;
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .requirement-list li i {
      font-size: 1.2rem;
      color: #c02424;
      width: 20px;
    }

    .requirement-list li span {
      font-size: 1.1rem;
    }

    .requirement-list li.valid i {
      color: #16922b;
    }

    .requirement-list li.valid span {
      color: #999999;
    }
  </style>
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
            <input class="input" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password" name="password" placeholder="Password">
            <span class="" id="viewPassword"><i class="fas fa-eye"></i></span>
          </div>

          <div class="row">
            <label class="col-md-4 control-label"> <img style="border: 1px solid #D3D0D0" src="<?php echo constant("URL"); ?>views/contents/auth/captcha/captcha.php?rand=<?php echo rand(); ?>" id='captcha'></label>

            <div class="col-md-8"><br>
              <a href="javascript:void(0)" id="reloadCaptcha">Recargar codigo</a>
            </div>
          </div>

          <div class="input-subcontent">
            <input class="input" id="captcha_input" type="password" name="captcha_input" placeholder="captcha" maxlength="4">
          </div>

          <div class="content-requirement">
            <span>La contraseña debe contener</span>
            <ul class="requirement-list">
              <li>
                <i class="fa-solid fa-times"></i>
                <p>Al menos 8 caracteres de longitud</p>
              </li>
              <li>
                <i class="fa-solid fa-times"></i>
                <p>Al menos 1 mayuscula (A...Z)</p>
              </li>
              <li>
                <i class="fa-solid fa-times"></i>
                <p>Al menos 1 minuscula (a...z)</p>
              </li>
              <li>
                <i class="fa-solid fa-times"></i>
                <p>Al menos 1 caracter especial (!...$)</p>
              </li>
              <li>
                <i class="fa-solid fa-times"></i>
                <p>Al menos 1 numero (0...9)</p>
              </li>
            </ul>
          </div>

          <div class="btn-content">
            <input type="hidden" name="ope">
            <button class="btn-content__btn" id="form-btn__submit" onclick="ope.value = this.value" value="Login" type="button">Iniciar Sesion</button>
          </div>
          <div class="content-two__forgot">
            <a class="olvidasteTC" href="<?php echo constant("URL"); ?>auth/recuperar_clave">¿Olvidaste tu contraseña?</a>
            <a class="registrarse" href="<?php echo constant("URL"); ?>auth/sign_in">Registrarse</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- <script src="<?php //echo constant("URL"); 
                    ?>views/javascript_nuevo/jquery.js"></script>
  <script src="<?php //echo constant("URL"); 
                ?>views/javascript_nuevo/jquery.validate.js"></script>
  <script src="<?php //echo constant("URL"); 
                ?>views/javascript_nuevo/sweetAlert.js"></script> -->
  <?php $this->GetComplement("scripts"); ?>
  <script src="<?php echo constant("URL"); ?>views/javascript_nuevo/toggleMode.js"></script>
  <script>
    const passwordInput = document.querySelector('#password');
    const requirementList = document.querySelectorAll('.requirement-list li');

    const requirements = [{
        regex: /.{8,}/,
        index: 0
      },
      {
        regex: /[A-Z]/,
        index: 1
      },
      {
        regex: /[a-z]/,
        index: 2
      },
      {
        regex: /[^A-Za-z0-9]/,
        index: 3
      },
      {
        regex: /[0-9]/,
        index: 4
      },
    ]

    passwordInput.addEventListener('keyup', e => {
      requirements.forEach(item => {
        const isValid = item.regex.test(e.target.value);
        const requirementItem = requirementList[item.index];

        if (isValid) {
          requirementItem.firstElementChild.className = 'fa-solid fa-check';
          requirementItem.classList.add('valid');
          $("#btn_recuperar").attr("disabled", false)
        } else {
          requirementItem.firstElementChild.className = 'fa-solid fa-times';
          requirementItem.classList.remove('valid');
          $("#btn_recuperar").attr("disabled", true)
        }
      })
    })

    document.querySelector("#login-content").addEventListener("submit", (e) => {
      e.preventDefault();
      if ($("#login-content").validate()) $("#login-content").submit();
    });

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
        },
        captcha_input: {
          required: true,
          maxlength: 4,
          minlength: 4,
          remote: "<?php echo constant("URL"); ?>controller/c_auth.php?ope=captcha"
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
        },
        captcha_input: {
          required: "Este campo es obligatorio",
          maxlength: "Maximo 4 caracteres",
          minlength: "Minimo 4 caracteres",
          remote: "El codigo ingresado no es valido"
        }
      },
    });

    $("#form-btn__submit").click(async (e) => {
      if ($("#login-content").valid()) $("#login-content").submit();
    });

    // $("#login-content").validate({
    //   rules: {
    //     cedula: {
    //       required: true,
    //       minlength: 7,
    //       maxlength: 8,
    //       number: true,
    //     },
    //     password: {
    //       required: true,
    //       minlength: 8,
    //       maxlength: 50,
    //     },
    //     captcha_input: {
    //       required: true,
    //       maxlength: 4,
    //       minlength: 4,
    //       remote: "<?php //echo constant("URL"); 
                      ?>controller/c_auth.php?ope=captcha"
    //     }
    //   },
    //   messages: {
    //     cedula: {
    //       required: "Este Campo es Obligatorio",
    //       minlength: "Mínimo 7 caracteres numéricos para la cédula",
    //       maxlength: "Máximo 8 caracteres numéricos para la cédula",
    //       number: "Sólo se Aceptan Números",
    //     },
    //     password: {
    //       required: "Este Campo es Obligatorio",
    //       minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
    //       maxlength: "Máximo de 50 caracteres para una Contraseña",
    //       pattern: "Se debe de ingresar una Clave mas segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un caracter especial, 8 caracteres mínimo)",
    //     },
    //     captcha_input: {
    //       required: "Este campo es obligatorio",
    //       maxlength: "Maximo 4 caracteres",
    //       minlength: "Minimo 4 caracteres",
    //       remote: "El codigo ingresado no es valido"
    //     }
    //   },
    //   errorElement: "span",
    //   errorPlacement: function(error, element) {
    //     error.addClass("invalid-feedback");
    //     element.closest(".input-subcontent").append(error);
    //   },
    //   highlight: function(element, errorClass, validClass) {
    //     $(element).addClass('is-invalid');
    //   },
    //   unhighlight: function(element, errorClass, validClass) {
    //     $(element).removeClass('is-invalid');
    //   }
    // });
  </script>
</body>

</html>