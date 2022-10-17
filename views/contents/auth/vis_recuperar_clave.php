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
				if(isset($result['view']) && $result['view'] == "sign_in") $this->Redirect("auth/login","err/05AUTH");

				if($result['status']){
					$status_form = $result['next'];
					$cedula = $result['cedula'];
					$id = $result['id'];
					$pregun1 = $result['pregun1'];
					$pregun2 = $result['pregun2'];
					$respues1 = $result['respues1'];
					$respues2 = $result['respues2'];
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
<body class="hold-transition login-page" id="fondo">
	<div class="login-box">
		<div class="login-logo">
			<img src="<?php echo constant("URL");?>views/images/logo.jpeg" alt="Logo" class="img-fluid rounded mx-auto d-block">
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body rounded">
				<p class="login-box-msg">Recuperación de Contraseña</p>

				<?php if($status_form == 1){?>
				<form action="#" method="post">
					<div class="input-group mb-3">
						<input type="number" class="form-control" maxlength="8" name="cedula" placeholder="Cédula de la Persona" require>
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
				<form action="#" method="post">
					<div class="input-group mb-3">
						<input type="hidden" name="user_id" readonly value="<?php echo $id;?>">
						<input type="number" class="form-control" name="cedula" value="<?php echo $cedula;?>" placeholder="Cédula de la Persona" readonly>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="mb-3 form-group">
						<label for="">Primera Pregunta de Seguridad</label>
						<select name="pregunta1" id="" class="custom-select" required>
							<option value="<?php echo $pregun1['id_pregun']; ?>"><?php echo $pregun1['des_pregun'];?></option>
						</select>
					</div>
					<div class="mb-3 form-group">
						<label for="">Primera Respuesta</label>
						<select name="respuesta1" id="respues_1" class="custom-select" required>
							<option value="">Seleccione una Respuesta</option>
							<?php foreach($respues1 as $respues){?>
								<option value="<?php echo $respues['id_respues'];?>"><?php echo $respues['des_respues'];?></option>
							<?php }?>
						</select>
					</div>
					<div class="mb-3 form-group">
						<label for="">Segunda Pregunta de Seguridad</label>
						<select name="pregunta2" id="" class="custom-select" required>
							<option value="<?php echo $pregun2['id_pregun']; ?>"><?php echo $pregun2['des_pregun'];?></option>
						</select>
					</div>
					<div class="mb-3 form-group">
						<label for="">Segunda Respuesta</label>
						<select name="respuesta2" id="respues_2" class="custom-select" required>
							<option value="">Seleccione una Respuesta</option>
							<?php foreach($respues2 as $respues){?>
								<option value="<?php echo $respues['id_respues'];?>"><?php echo $respues['des_respues'];?></option>
							<?php }?>
						</select>
					</div>
					<div class="row mb-2">
						<div class="col-12">
							<button type="submit" name="ope" value="form2" class="btn btn-warning btn-block">Enviar Respuestas</button>
						</div>
					</div>
				</form>
				<?php }else if($status_form == 3){?>
				<form action="#" id="formulario" method="post" class="needs-validation" novalidate>
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
