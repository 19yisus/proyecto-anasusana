<?php
$status_form = 1;
$cedula = $_GET['id'];
$email = null;
$id = null;
$pregun1 = null;
$pregun2 = null;
$result =  null;

if (isset($_POST['ope'])) {
	require_once("./models/m_auth.php");
	$model = new m_auth();

	switch ($_POST['ope']) {
		case 'form1':

			$result = $model->VerificarCorreo($_POST['cedula'], $_POST['email']);
			if (isset($result['view']) && $result['view'] == "sign_in") $this->Redirect("auth/login", "err/05AUTH");

			if ($result['status']) {
				$status_form = $result['next'];
				$cedula = $_POST['cedula'];
				$email = $_POST['email'];
				$id = $result['id_user'];
			}
			break;

		case 'form2':

			$result = $model->ValidacionCodigo($_POST);
			if ($result['status']) {
				$cedula = $cedula;
				$id = $result['id_user'];
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
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/registroNU.css">
	<link rel="stylesheet" href="<?php echo constant("URL");?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?php echo constant("URL");?>views/plugins/toastr/toastr.min.css">
	<title>Recuperación por correo</title>
</head>

<body>
	<div class="full-content">

		<div class="theme-toggler">
			<span class="material-symbols-sharp active inactive">light_mode</span>
			<span class="material-symbols-sharp">dark_mode</span>
		</div>
		<?php if ($status_form == 1) { ?>
			<!-- Se requiere el correo para confirmar que sea correcto -->
			<div class="content__section active">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="register-content">
						<h1>verificación de correo</h1>
						<div class="input-content__div-input">
							<input class="input" id="cedula" type="number" value="<?php echo $cedula; ?>" placeholder="Verifica tu correo" name="cedula" required>
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input class="input" id="email" type="email" placeholder="Verifica tu correo" name="email" required>
							<span><i class="fas fa-user"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn" name="ope" value="form1" type="submit">Consultar</button>
						</div>

						<div class="input__return">
							<a class="back" id="backRC" href="<?php echo constant("URL"); ?>auth/login">Ya tengo una cuenta</a>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 2) { ?>
			<!-- Se requiere el código enviado al correo para recuperar contraseña -->
			<div class="content__section active">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="register-content">
						<h1>verificación de código</h1>
						<div class="input-content__div-input">
						<input type="hidden" name="id" readonly value="<?php echo $id; ?>">
							<input class="input" id="cedula" type="number" value="<?php echo $cedula; ?>" placeholder="Verifica tu correo" name="cedula" required>
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input class="input" id="code" type="password" maxlength="8" placeholder="Ingrese su código de seguridad" name="code" required>
							<span><i class="fas fa-user"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn" name="ope" value="form2" type="submit">Enviar</button>
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
							<input type="hidden" name="id" readonly value="<?php echo $id; ?>">
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

						<div class="input__btn-content">
							<button class="btn-content__btn" name="ope" value="form3" type="submit">Recuperar clave</button>
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
		<?php } ?>
	</div>
	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/jquery.js"></script>
	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/jquery.validate.js"></script>
	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/sweetAlert.js"></script>
	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/toggleMode.js"></script>
	
	<?php $this->GetComplement("scripts"); ?>

	<?php
	if (isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']);

	if ($status_form == 3) { ?>
		<script>
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
					}
				},
				messages: {
					password: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más segura (1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
					},
					password2: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura (1 Mayúscula, 1 Minúscula, 1 Número y un caracter especial, 8 caracteres Mínimo)",
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