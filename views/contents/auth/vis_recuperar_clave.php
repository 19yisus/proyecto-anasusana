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
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/plugins/toastr/toastr.min.css">
	<?php if ($status_form == 1) { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/olvidarC.css">
	<?php } else { ?>
		<link rel="stylesheet" href="<?php echo constant("URL"); ?>views/css_nuevo/preguntaS.css">
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
					<form action="#" method="POST" class="section__input-content" id="forgot-password">
						<h1 for="">Recuperacion de Contraseña</h1>
						<div class="input-content__div-input">
							<input class="input" id="cedulaR" type="text" placeholder="Cédula de la Persona" name="cedula">
							<span><i class="fas fa-user"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn btn-recuperar" id="btn-recuperar" type="submit" name="ope" value="form1">Recuperar</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de Nuevo Usuario</a>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 2) { ?>
			<!-- preguntas de seguridad -->
			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="POST" autocomplete="off" class="section__input-content" id="question-content">
						<h1 for="recuperacionC">Recuperacion de Contraseña</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="user_id" readonly value="<?php echo $id; ?>">
							<input class="input" name="cedula" id="cedula" value="<?php echo $cedula; ?>" type="text" placeholder="Cédula de la persona">
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="hidden" name="pregunta1" readonly value="<?php echo $pregun1['id_pregun']; ?>">
							<input type="text" class="input" id="" value="<?php echo $pregun1['des_pregun']; ?>" placeholder="Primera Pregunta de Seguridad (*)" readonly>
							<span><i class="fas fa-question"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="text" class="input" id="" autocomplete="off" name="respuesta1" placeholder="Primera Respuesta de Seguridad (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>
						<div class="input-content__div-input">
							<input type="hidden" name="pregunta2" readonly value="<?php echo $pregun2['id_pregun']; ?>">
							<input type="text" class="input" id="" name="pregunta2" value="<?php echo $pregun2['des_pregun']; ?>" placeholder="Segunda Pregunta de Seguridad (*)" readonly>
							<span><i class="fas fa-question"></i></span>
						</div>
						<div class="input-content__div-input last-child">
							<input type="text" class="input" id="" autocomplete="off" name="respuesta2" placeholder="Segunda Respuesta de Seguridad (*)">
							<span><i class="fas fa-reply"></i></span>
						</div>

						<div class="input__btn-content">
							<button class="btn-content__btn" id="btn" name="ope" value="form2" type="submit">Recuperar</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de Nuevo Usuario</a>
							<a class="back" id="RecEmail" href="<?php echo constant("URL"); ?>auth/email_recovery?id=<?php echo $_POST['cedula']; ?>">Recuperación con Email</a>
						</div>
					</form>
				</div>
			</div>
		<?php } else if ($status_form == 3) { ?>
			<div class="content__section">
				<div class="section__registerNU">
					<form action="#" method="POST" class="section__input-content" id="password-content">
						<h1 for="recuperacionC">Recuperacion de Contraseña</h1>
						<div class="input-content__div-input">
							<input type="hidden" name="user_id" readonly value="<?php echo $id; ?>">
							<input class="input" name="cedula" id="cedula" value="<?php echo $cedula; ?>" readonly type="text" placeholder="Cédula de la Persona">
							<span><i class="fas fa-user"></i></span>
						</div>
						<div class="input-content__div-input" style="margin-bottom: 10px;">
							<input type="password" class="input" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off" name="password" placeholder="Nueva Contraseña (*)">
							<span class="" id="viewPassword"><i class="fas fa-eye"></i></span>
						</div>

						<div class="input-content__div-input last-child" style="margin-bottom: 30px;">
							<input type="password" class="input" id="password2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off" name="password2" placeholder="Repita su Nueva Contraseña (*)">
							<span class="" id="viewPassword2"><i class="fas fa-eye"></i></span>
						</div>

						<div class="row">
							<label class="col-md-4 control-label"> <img style="border: 1px solid #D3D0D0" src="<?php echo constant("URL"); ?>views/contents/auth/captcha/captcha.php?rand=<?php echo rand(); ?>" id='captcha'></label>

							<div class="col-md-8"><br>
								<a href="javascript:void(0)" id="reloadCaptcha">Recargar Código</a>
							</div>
						</div>

						<div class="input-content__div-input last-child" style="margin-bottom: 17px;">
							<input class="input" id="captcha_input" type="password" name="captcha_input" placeholder="Captcha" maxlength="4">
						</div>


						<div class="content-requirement" style="margin:auto;">
							<span>La Contraseña debe Contener</span>
							<ul class="requirement-list">
								<li>
									<i class="fa-solid fa-times"></i>
									<p>Al menos 8 Caracteres de Longitud</p>
								</li>
								<li>
									<i class="fa-solid fa-times"></i>
									<p>Al Menos 1 Mayuscula (A...Z)</p>
								</li>
								<li>
									<i class="fa-solid fa-times"></i>
									<p>Al Menos 1 Minuscula (a...z)</p>
								</li>
								<li>
									<i class="fa-solid fa-times"></i>
									<p>Al Menos 1 Caracter Especial (!...$)</p>
								</li>
								<li>
									<i class="fa-solid fa-times"></i>
									<p>Al Menos 1 Numero (0...9)</p>
								</li>
							</ul>
						</div>

						<div class="input__btn-content">
							<input type="hidden" name="ope" value="form3">
							<button class="btn-content__btn" name="ope" id="btn" type="submit">Recuperar Clave</button>
						</div>

						<div class="input__return">
							<span>
								<a class="back" id="backIn" href="<?php echo constant("URL"); ?>auth/login">Inicio</a>
							</span>
							<a class="back" id="backRNU" href="<?php echo constant("URL"); ?>auth/sign_in">Registro de Nuevo Usuario</a>
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
		<script>
			$("#forgot-password").validate({
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
						required: "Campo Vacío",
						number: "Debe ser un Numero",
						minlength: "Cédula Inválida",
						maxlength: "Cédula Inválida",
					},
				},
			});
		</script>
	<?php } else if ($status_form == 2) { ?>
		<script>
			$("#question-content").validate({
				rules: {
					respuesta1: {
						required: true,
					},
					respuesta2: {
						required: true,
					},
				},
				messages: {
					respuesta1: {
						required: "Campo Vacío"
					},
					respuesta2: {
						required: "Campo Vacío"
					},
				},
			});
		</script>
	<?php } else { ?>
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
						$("#btn-registrar").attr("disabled", false)
					} else {
						requirementItem.firstElementChild.className = 'fa-solid fa-times';
						requirementItem.classList.remove('valid');
						$("#btn-registrar").attr("disabled", true)
					}
				})
			})

			document.querySelector("#password-content").addEventListener("submit", (e) => {
				e.preventDefault();
				if ($("#password-content").validate()) $("#password-content").submit();
			});

			$("#password-content").validate({
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
						pattern: "Se debe de Ingresar una Clave más Segura",
					},
					password2: {
						required: "Este Campo es Obligatorio",
						minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
						maxlength: "Máximo de 20 caracteres para una Contraseña",
						pattern: "Se debe de Ingresar una Clave más Segura",
						equalTo: "Las Contraseñas Ingresadas NO Coinciden"
					},
					respuesta1: {
						required: "Este Campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
					respuesta2: {
						required: "Este Campo es Obligatorio",
						minlength: "Su respuesta no cumple con el minimo requerido (5 caracteres)",
						maxlength: "Su respuesta excede el maximo requerido (60 caracteres)",
					},
					captcha_input: {
						required: "Este Campo es Obligatorio",
						maxlength: "Maximo 4 Caracteres",
						minlength: "Minimo 4 Caracteres",
						remote: "El Codigo Ingresado no es Valido"
					}
				},
			});
		</script>
	<?php } ?>
	<?php if (isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']); ?>
</body>

</html>