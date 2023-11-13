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
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/toastr/toastr.min.css">
	<style>
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
					<form action="#" method="POST" class="section__input-content" id="verificacion_correo">
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
					<form action="#" method="POST" class="section__input-content" id="verificacion_code">
						<h1>verificación de código</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="id" readonly value="<?php echo $id; ?>">
							<input class="input" id="cedula" type="number" value="<?php echo $cedula; ?>" placeholder="Verifica tu correo" name="cedula" required>
							<span><i class="fas fa-user"></i></span>
						</div>
						<!-- <div class="input-content__div-input">
							<input class="input" id="code" type="password" maxlength="8" placeholder="Ingrese su código de seguridad" name="code" required>
							<span><i class="fas fa-user"></i></span>
						</div> -->
						<div class="input-content__div-input last-child" style="margin-bottom: 30px;">
							<input class="input" id="code" type="password" name="code" placeholder="Ingrese su código de seguridad">
							<!-- <input type="password" class="input" id="" autocomplete="off" id="code" name="code" > -->
							<span class="viewPassword" id="viewPassword3"><i class="fas fa-eye"></i></span>
						</div>

						<div class="input__btn-content" style="margin-bottom: 10px;">
							<input type="hidden" name="ope" value="form2">
							<button class="btn-content__btn" type="submit">Enviar</button>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 3) { ?>

			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="cambio_clave">
						<h1 for="recuperacionC">Recuperacion de contraseña</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="user_id" readonly value="<?php echo $id; ?>">
							<input class="input" name="cedula" id="cedula" value="<?php echo $cedula; ?>" readonly type="text" placeholder="Cédula de la persona">
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="password" class="input" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" placeholder="Nueva contraseña (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>

						<div class="input-content__div-input last-child">
							<input type="password" class="input" id="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password2" placeholder="Repita su nueva contraseña (*)">
							<span><i class="fas fa-reply"></i></span>
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

						<div class="input__btn-content">
							<input type="hidden" name="ope" value="form3">
							<button class="btn-content__btn" id="btn_recuperar" disabled type="submit">Recuperar clave</button>
						</div>

						<div class="input__return">
							<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
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

	if ($status_form == 1) {
	?>
		<script>
			$("#verificacion_correo").validate({
				rules: {
					email: {
						required: true,
						minlength: 10,
						maxlength: 60,
						email: true,
					},
				},
				messages: {
					email: {
						required: "Este Campo NO puede estar Vacio",
						minlength: "Mínimo de 20 caracteres",
						maxlength: "Máximo de 120 caracteres",
						email: "Ingrese un Correo Válido",
					},
				},
			});
		</script>
	<?php
	} else if ($status_form == 2) {
	?>
		<script>
			$("#verificacion_code").validate({
				rules: {
					code: {
						required: true,
						minlength: 8,
						maxlength: 8,
					},
				},
				messages: {
					code: {
						required: "Este Campo NO puede estar Vacio",
						minlength: "Mínimo de 8 caracteres",
						maxlength: "Máximo de 8 caracteres",
					},
				},
			});
		</script>

	<?php
	} else if ($status_form == 3) { ?>
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

			document.querySelector("#cambio_clave").addEventListener("submit", (e) => {
				e.preventDefault();
				if ($("#cambio_clave").validate()) $("#cambio_clave").submit();
			});

			$("#cambio_clave").validate({
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
				}
			});
		</script>
	<?php } ?>
</body>

</html>