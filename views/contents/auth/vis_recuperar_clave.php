<?php
$status_form = 1;
$cedula = null;
$id = null;
$pregun1 = $pregun2 = $respues1 = $respues2 = null;
$result =  null;

if (isset($_POST['ope'])) {
	require_once("./models/m_auth.php");
	$model = new m_auth();

	switch ($_POST['ope']) {
		case 'form1':

			$result = $model->FindUser($_POST['cedula']);
			if (isset($result['view']) && $result['view'] == "sign_in") $this->Redirect("auth/login", "err/05AUTH");

			if ($result['status']) {
				$status_form = $result['next'];
				$cedula = $result['cedula'];
				$id = $result['id'];
				$pregun1 = $result['pregun1'];
				$pregun2 = $result['pregun2'];
			}
			break;

		case 'form2':

			$result = $model->ValidarRespuestas($_POST);
			if ($result['status']) {
				$cedula = $result['cedula'];
				$id = $result['id'];
				$status_form = $result['next'];
			}
			break;

		case 'form3':
			$result = $model->resetPassword($_POST);
			if ($result['status']) $status_form = $result['next'];
			break;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/generalStyles.css">
	<?php if ($status_form == 1) { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/olvidarC.css">
	<?php } else { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/preguntaS.css">
	<?php  } ?>
	<title>Recupración de contraseña</title>
</head>

<body>
	<div class="full-content">
		<div class="theme-toggler">
			<span class="material-symbols-sharp active inactive">light_mode</span>
			<span class="material-symbols-sharp">dark_mode</span>
		</div>
		<?php if ($status_form == 1) { ?>
			<!-- busqueda de usuario -->
			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="post" class="section__input-content" id="forgot-password">
						<h1 for="">Recuperacion de contraseña</h1>
						<div class="input-content__div-input">
							<input class="input" id="cedulaR" type="text" placeholder="Cédula de la persona" name="cedula">
							<span><i class="fas fa-user"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn btn-recuperar" id="btn-recuperar" type="submit" name="ope" value="form1">Recuperar</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de nuevo usuario</a>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 2) { ?>
			<!-- preguntas de seguridad -->
			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="question-content">
						<h1 for="recuperacionC">Recuperacion de contraseña</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="user_id" readonly value="<?php echo $id; ?>">
							<input class="input" name="cedula" id="cedula" value="<?php echo $cedula; ?>" type="text" placeholder="Cédula de la persona">
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="hidden" name="pregunta1" readonly value="<?php echo $pregun1['id_pregun']; ?>">
							<input type="text" class="input" id="" value="<?php echo $pregun1['des_pregun']; ?>" placeholder="Primera pregunta de seguridad (*)" readonly>
							<span><i class="fas fa-question"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="text" class="input" id="" name="respuesta1" placeholder="Primera respuesta de seguridad (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="hidden" name="pregunta2" readonly value="<?php echo $pregun2['id_pregun']; ?>">
							<input type="text" class="input" id="" name="pregunta2" value="<?php echo $pregun2['des_pregun']; ?>" placeholder="Segunda pregunta de seguridad (*)" readonly>
							<span><i class="fas fa-question"></i></span>
						</div>
						<div class="input-content__div-input last-child">
							<input type="text" class="input" id="" name="respuesta2" placeholder="Segunda respuesta de seguridad (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn" name="ope" value="form2" type="submit">Recuperar</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de nuevo usuario</a>
							<a class="back" id="RecEmail" href="<?php echo constant("URL"); ?>auth/email_recovery?id=<?php echo $_POST['cedula']; ?>">Recuperación con Email</a>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 3) { ?>
			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="question-content">
						<h1 for="recuperacionC">Recuperacion de contraseña</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="user_id" readonly value="<?php echo $id; ?>">
							<input class="input" name="cedula" id="cedula" value="<?php echo $cedula; ?>" readonly type="text" placeholder="Cédula de la persona">
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="password" class="input" id="password" name="password" placeholder="Nueva contraseña (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>

						<div class="input-content__div-input last-child">
							<input type="password" class="input" id="" name="password2" placeholder="Repita su nueva contraseña (*)">
							<span><i class="fas fa-reply"></i></span>
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

						<div class="input__btn-content">
							<button class="btn-content__btn" name="ope" value="form3" id="btn" type="button">Recuperar clave</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de nuevo usuario</a>
							<a class="back" id="RecEmail" href="<?php echo constant("URL"); ?>auth/email_recovery?id=<?php echo $_POST['cedula']; ?>">Recuperación con Email</a>
						</div>
					</form>
				</div>
			</div>
		<?php  } ?>
		<!-- cambio de clave -->
	</div>

	<?php $this->GetComplement("scripts"); ?>
	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/toggleMode.js"></script>
	<?php if ($status_form == 1) { ?>
		<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/olvidar.js"></script>
	<?php } else { ?>
		<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/preguntaS.js"></script>
	<?php } ?>


	<?php
	if (isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']);

	if ($status_form == 3) { ?>
		<script>
			$("#btn").click(async () => {
				if ($("#question-content").valid()) $("#question-content").submit();
			})
			$("#reloadCaptcha").click(function() {
				var captchaImage = $('#captcha').attr('src');
				captchaImage = captchaImage.substring(0, captchaImage.lastIndexOf("?"));
				captchaImage = captchaImage + "?rand=" + Math.random() * 1000;
				$('#captcha').attr('src', captchaImage);
			});

			$("#question-content").validate({
				rules: {
					password: {
						required: true,
						minlength: 8,
						maxlength: 20,
					},
					password2: {
						required: true,
						minlength: 8,
						maxlength: 20,
						equalTo: "#password",
					},
					respuesta1: {
						required: true,
						minlength: 5,
						maxlength: 60,
					},
					respuesta2: {
						required: true,
						minlength: 5,
						maxlength: 60,
					},
					captcha_input: {
						required: true,
						maxlength: 4,
						minlength: 4,
						remote: "<?php echo constant("URL"); ?>controller/c_auth.php?ope=captcha"
					}
				},
				messages: {
					password: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
					},
					password2: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un caracter especial, 8 caracteres Mínimo)",
						equalTo: "Las Contraseñas Ingresadas NO Coinciden"
					},
					respuesta1: {
						required: "Este campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
					respuesta2: {
						required: "Este campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
					captcha_input: {
						required: "Este campo es obligatorio",
						maxlength: "Maximo 4 caracteres",
						minlength: "Minimo 4 caracteres",
						remote: "El codigo ingresado no es valido"
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
	<?php } ?>
</body>

</html>