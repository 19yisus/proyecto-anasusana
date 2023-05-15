<?php
	$status_form = 1;
	$cedula = $_GET['id'];
  $email = null;
	$id = null;
	$pregun1 = null;
	$pregun2 = null;
	$result =  null;

	if(isset($_POST['ope'])){
		require_once("./models/m_auth.php");
		$model = new m_auth();

		switch($_POST['ope']){
			case 'form1':

				$result = $model->VerificarCorreo($_POST['cedula'],$_POST['email']);
				if(isset($result['view']) && $result['view'] == "sign_in") $this->Redirect("auth/login","err/05AUTH");

				if($result['status']){
					$status_form = $result['next'];
					$cedula = $_POST['cedula'];
					$email = $_POST['email'];
					$id = $result['id_user'];
				}
			break;

			case 'form2':

				$result = $model->ValidacionCodigo($_POST);
				if($result['status']){
					$cedula = $cedula;
					$id = $result['id_user'];
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
<body class="hold-transition login-page" id="fondo">
	<div class="login-box">
		<div class="login-logo">
			<!-- <img src="<?php //echo constant("URL");?>views/images/logo.jpeg" alt="Logo" class="img-fluid rounded mx-auto d-block"> -->
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body rounded">
				<p class="login-box-msg">Recuperación de Contraseña por Email</p>
				<?php if($status_form == 1){?>
          <!-- Se requiere el correo para confirmar que sea correcto -->
				<form action="#" method="post" autocomplete="off">
					<div class="input-group mb-3">
						<input type="number" class="form-control" maxlength="8" value="<?php echo $cedula;?>" name="cedula" placeholder="Cédula de la Persona" readonly>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
          <div class="input-group mb-3">
						<input type="email" class="form-control" name="email" placeholder="Ingrese su correo para confirmarlo">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-12">
							<button type="submit" name="ope" value="form1" class="btn btn-warning btn-block">Consultar</button>
						</div>
					</div>
				</form>
				<?php }else if($status_form == 2){?>
          <!-- Se requiere el código enviado al correo para recuperar contraseña -->
				<form action="#" method="post" autocomplete="off">
          <div class="input-group mb-3">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="number" class="form-control" maxlength="8" value="<?php echo $cedula;?>" name="cedula" placeholder="Cédula de la Persona" readonly>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
          <div class="input-group mb-3">
						<input type="password" class="form-control" name="code" maxlength="8" minlength="8" placeholder="Ingrese su código de seguridad">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-12">
							<button type="submit" name="ope" value="form2" class="btn btn-warning btn-block">Enviar</button>
						</div>
					</div>
				</form>
				<?php }else if($status_form == 3){?>
				<form action="#" id="formulario" method="post" class="needs-validation" autocomplete="off" novalidate>
					<div class="input-group mb-3">
						<input type="hidden" name="user_id" readonly value="<?php echo $id;?>">
						<input type="number" class="form-control" name="cedula" value="<?php echo $cedula;?>" placeholder="Cédula de la persona" readonly>
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
						<input type="password" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" class="form-control" placeholder="Confirmar Contraseña">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-12">
							<button type="submit" name="ope" value="form3" class="btn btn-warning btn-block">Enviar Datos</button>
						</div>
					</div>
				</form>
				<?php }?>
				<p class="mb-1">
					<a href="<?php echo constant("URL");?>auth/login">Inicio</a>
				</p>
				<p class="mb-0">
					<a href="<?php echo constant("URL");?>auth/sign_in" class="text-center">Registro de Nuevo Usuario</a>
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
					},
					respuesta1:{
						required: true,
						minlength: 5,
						maxlength: 60,
					},
					respuesta2:{
						required: true,
						minlength: 5,
						maxlength: 60,
					}
				},
				messages:{
					password:{
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más segura (1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
					},
					password2:{
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura (1 Mayúscula, 1 Minúscula, 1 Número y un caracter especial, 8 caracteres Mínimo)",
						equalTo: "Las Contraseñas Ingresadas NO Coinciden"
					},
					respuesta1:{
						required: "Este campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
					respuesta2:{
						required: "Este campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
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
