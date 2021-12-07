<?php
  $status_form = 1;
  $cedula = null;
  $id = null;
  $pregun1 = null;
  $pregun2 = null;
  $result =  null;

  if(isset($_POST['ope'])){
    require_once("./models/m_auth.php");
    $model = new m_auth();
    
    switch($_POST['ope']){
      case 'form1':
        
        $result = $model->FindUser($_POST['cedula']);    
        if($result['status']){
          $status_form = $result['next'];
          $cedula = $result['cedula'];
          $id = $result['id'];
          $pregun1 = $result['pregun1'];
          $pregun2 = $result['pregun2'];
        }
      break;

      case 'form2':

        $result = $model->ValidarRespuestas($_POST);
        if($result['status']){
          $cedula = $result['cedula'];
          $id = $result['id'];
          $status_form = $result['next'];
        }
      break;

      case 'form3':
        $result = $model->resetPassword($_POST);
        if($result['status']) $status_form = $result['next'];
      break;
    }
  }
?>
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
        <p class="login-box-msg">Recuperacion de contraseña</p>
        
        <?php if($status_form == 1){?>
        <form action="#" method="post">
          <div class="input-group mb-3">
            <input type="number" class="form-control" name="cedula" placeholder="Cedula de la persona" require>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" name="ope" value="form1" class="btn btn-primary btn-block">Consultar</button>
            </div>
          </div>
        </form>
        <?php }else if($status_form == 2){?>
        <form action="#" method="post">
          <div class="input-group mb-3">
            <input type="hidden" name="id" readonly value="<?php echo $id;?>">
            <input type="number" class="form-control" name="cedula" value="<?php echo $cedula;?>" placeholder="Cedula de la persona" readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="respuesta1" placeholder="<?php echo $pregun1;?> ?">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="respuesta2" placeholder="<?php echo $pregun1;?> ?">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" name="ope" value="form2" class="btn btn-primary btn-block">Enviar respuestas</button>
            </div>
          </div>
        </form>
        <?php }else if($status_form == 3){?>
        <form action="#" id="formulario" method="post" class="needs-validation" novalidate>
          <div class="input-group mb-3">
            <input type="hidden" name="id" readonly value="<?php echo $id;?>">
            <input type="number" class="form-control" name="cedula" value="<?php echo $cedula;?>" placeholder="Cedula de la persona" readonly>
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
          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" name="ope" value="form3" class="btn btn-primary btn-block">Enviar datos</button>
            </div>
          </div>
        </form>
        <?php }?>
        <p class="mb-1">
          <a href="<?php echo constant("URL");?>auth/login">Login</a>
        </p>
        <p class="mb-0">
          <a href="<?php echo constant("URL");?>auth/sign_in" class="text-center">Registro de nuevo usuario</a>
        </p>
      </div>
    </div>
  </div>
  <?php $this->GetComplement("scripts"); ?>
  
  <?php 
    if(isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']);

    if($status_form == 3){?>
    <script>
      $("#formulario").validate({
        rules:{
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
  <?php }?>
</body>
</html>