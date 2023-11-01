<?php
$status_form = 1;
$cedula = null;
$id = null;
$preguntas = [];

if (isset($_POST['ope'])) {
	require_once("./models/m_auth.php");
	$model = new m_auth();

	switch ($_POST['ope']) {
		case 'form1':
			$result = $model->FindUser($_POST['cedula']);

			if ($result['status']) {

				if ($result['view'] == "recuperar_clave") $this->Redirect("auth/login", "err/04AUTH");

				$preguntas = $model->Get_Preguntas();
				$status_form = $result['next'];
				$cedula = $result['cedula'];
				$id = $result['id'];
			}
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
	<!-- Toastr -->
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/toastr/toastr.min.css">
	<?php if ($status_form == 1) { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/registroNU.css">
	<?php } else { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/registroNUF.css">
	<?php  } ?>
	<title>Registro de nuevo usuario</title>
</head>

<body>

	<div class="full-content">

		<div class="theme-toggler">
			<span class="material-symbols-sharp active inactive">light_mode</span>
			<span class="material-symbols-sharp">dark_mode</span>
		</div>
		<?php if ($status_form == 1) { ?>
			<div class="content__section active">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="register-content">
						<h1>Registro de nuevo usuario</h1>
						<div class="input-content__div-input">
							<input class="input" id="cedulaR" type="text" placeholder="Cédula de la persona" name="cedula" required>
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
		<?php }
		if ($status_form == 2) { ?>
			<div class="content__section">
				<div class="section__formRU">
					<h1 class="register__title">Registro de nuevo usuario</h1>

					<form action="<?php echo constant("URL"); ?>controller/c_auth.php" method="post" class="formRU__register" id="formRU__register">

						<div class="register__container-input">
							<div class="container__div-input">
								<input type="hidden" name="user_id" value="<?php echo $id; ?>">
								<input type="text" class="input" id="cedula" name="cedula" value="<?php echo $cedula; ?>" readonly>
								<span><i class="fas fa-user"></i></span>
							</div>
							<div class="container-camposO">
								<span class="camposO">Todos los campos con (<span class="asterisco">*</span>), son obligatorios</span>
							</div>
						</div>
						<div class="register__container-input select">
							<div class="container__div-input">
								<select name="pregunta1" onchange="Get_respuestas('#respues_1', this.value)">
									<option value="">Elige una pregunta (*)</option>
									<?php foreach ($preguntas as $pregunta1) {
										$id_pregun1 = $pregunta1['id_pregun'];
									?>
										<option value="<?php echo $id_pregun1; ?>"><?php echo $pregunta1['des_pregun']; ?></option>
									<?php } ?>
								</select>
								<span><i class="fas fa-angle-down"></i></span>
							</div>
							<div class="container__div-input">
								<select name="pregunta2" id="pregun2">
									<option value="">Elige una pregunta (*)</option>
									<?php foreach ($preguntas as $pregunta2) {
										$id_pregun2 = $pregunta2['id_pregun'];
									?>
										<option value="<?php echo $id_pregun2; ?>"><?php echo $pregunta2['des_pregun']; ?></option>
									<?php } ?>
								</select>
								<span><i class="fas fa-angle-down"></i></span>
							</div>
						</div>
						<div class="register__container-input">
							<div class="container__div-input">
								<input type="text" class="input" name="respuesta1" id="respuesta1" placeholder="Primera respuesta de seguridad (*)">
								<span><i class="fas fa-question"></i></span>
							</div>
							<div class="container__div-input">
								<input type="text" class="input" name="respuesta2" id="respuesta2" placeholder="Segunda respuesta de seguridad (*)">
								<span><i class="fas fa-question"></i></span>
							</div>
						</div>
						<div class="register__container-input">
							<div class="container__div-input">
								<input type="password" class="input password" name="password" id="password" placeholder="Ingresa tu contraseña (*)">
								<span class="viewPassword" id="viewPassword"><i class="fas fa-eye"></i></span>
							</div>
							<div class="container__div-input">
								<input type="password" class="input password" name="password2" id="password2" placeholder="Confirma tu contraseña (*)">
								<span class="viewPassword" id="viewPassword2"><i class="fas fa-eye"></i></span>
							</div>
						</div>

						<div class="register__container-input">
							<div class="container__div-input">
								<label class="col-md-4 control-label"> <img style="border: 1px solid #D3D0D0" src="<?php echo constant("URL"); ?>views/contents/auth/captcha/captcha.php?rand=<?php echo rand(); ?>" id='captcha'></label>
							</div>


							<div class="container__div-input">
								<input class="input" id="captcha_input" type="password" name="captcha_input" placeholder="captcha" maxlength="4">
							</div>
						</div>

						<div class="register__btn-content">
							<input type="hidden" name="ope">
							<button class="btn-content__btn" type="button" id="btn-registrar" onclick="ope.value = this.value" value="Register">Registrarse</button>
						</div>

						<div class="input__return">
							<a class="back" id="backRU" href="<?php echo constant("URL"); ?>auth/login">Ya tengo una cuenta</a>
						</div>
					</form>
				</div>
			</div>

		<?php } ?>
	</div>
	<!-- /.login-box -->
	<?php
	$this->GetComplement("scripts");
	if (isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']);
	?>

	<script src="<?php echo constant("URL"); ?>views/javascript_nuevo/toggleMode.js"></script>
	<?php if ($status_form == 1) { ?>
		<script>
			$("#register-content").validate({
				rules: {
					cedula: {
						required: true,
						number: true,
						minlength: 7,
						maxlength: 8,
					},
				},
				messages: {
					cedula: {
						required: "Campo vacío",
						number: "Debe ser un numero",
						minlength: "Cédula inválida",
						maxlength: "Cédula inválida",
					},
				},
			});
		</script>
	<?php }
	if ($status_form == 2) { ?>
		<script>
			$("#formRU__register").validate({
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
					cedula: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo 7 caracteres Numéricos para la Cédula",
						maxlength: "Maximo 8 caracteres Numéricos para la Cédula",
						number: "Sólo se Aceptan Números",
					},
					password: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
					},
					password2: {
						required: "Este campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura ( Al menos 1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
						equalTo: "Las Contraseñas Ingresadas NO Conciden"
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
			});
		</script>
	<?php } ?>
	<script>
		// $("#btn").click(async () => {
		// 	if ($("#formRU__register").valid()) $("#formRU__register").submit();
		// })

		const Get_respuestas = (id_element, id_pregun) => {
			if (id_element != "#respues_2") {
				$(`#pregun2 option[value!='${id_pregun}']`).attr("disabled", false);
				$(`#pregun2 option[value='${id_pregun}']`).attr("disabled", true);
				Get_respuestas('#respues_2', $('#pregun2').val())
			}
		}
	</script>
</body>

</html>