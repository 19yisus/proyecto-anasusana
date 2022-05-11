<?php
	$status_form = 1;
	$cedula = null;
	$id = null;
	$preguntas = [];

	if(isset($_POST['ope'])){
		require_once("./models/m_auth.php");
		$model = new m_auth();

		switch($_POST['ope']){
			case 'form1':
				$result = $model->FindUser($_POST['cedula']);

				if($result['status']){

					if($result['view'] == "recuperar_clave") $this->Redirect("auth/login","err/04AUTH");

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
<?php $this->GetHeader(); ?>
<body class="hold-transition login-page bg-primary">
	<div class="login-box">
		<div class="login-logo">
			<img src="<?php echo constant("URL");?>views/images/logo.jpeg" alt="Logo" class="img-fluid rounded mx-auto d-block">
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body rounded">
				<p class="login-box-msg">Registro de Nuevo Usuario</p>
				<?php if($status_form == 1){?>
				<form action="#" method="post">
					<div class="input-group mb-3">
						<input type="number" class="form-control" name="cedula" placeholder="Cédula de la Persona" required>
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
				<form action="<?php echo constant("URL");?>controller/c_auth.php" id="formulario" method="post" class="needs-validation" novalidate>
					<div class="input-group mb-3">
						<input type="hidden" name="user_id" value="<?php echo $id;?>">
						<input type="number" name="cedula" class="form-control" placeholder="Cédula" value="<?php echo $cedula; ?>" readonly>
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

					<div class="mb-3 form-group">
						<label for="">Primera Pregunta de Seguridad</label>
						<select name="pregunta1" class="custom-select" id="" onchange="Get_respuestas('#respues_1', this.value)">
							<option value="">Seleccione una Pregunta</option>
							<?php foreach($preguntas as $pregunta1){
								$id_pregun1 = $pregunta1['id_pregun'];
								?>
								<option value="<?php echo $id_pregun1; ?>"><?php echo $pregunta1['des_pregun'];?></option>
							<?php }?>
						</select>
					</div>

					<div class="mb-3 form-group">
						<label for="">Primera Respuesta</label>
						<select name="respuesta1" class="custom-select" id="respues_1">
							<option value="">Seleccione una Respuesta</option>
						</select>
					</div>

					<div class="mb-3 form-group">
						<label for="">Segunda Pregunta de Seguridad</label>
						<select name="pregunta2" id="pregun2" class="custom-select" id="">
							<option value="">Seleccione una Pregunta</option>
							<?php foreach($preguntas as $pregunta2){
								$id_pregun2 = $pregunta2['id_pregun'];
								?>
								<option value="<?php echo $id_pregun2; ?>"><?php echo $pregunta2['des_pregun'];?></option>
							<?php }?>
						</select>
					</div>

					<div class="mb-3 form-group">
						<label for="">Segunda Respuesta</label>
						<select name="respuesta2" class="custom-select" id="respues_2">
							<option value="">Seleccione una Respuesta</option>
						</select>
					</div>

					<div class="row">
						<div class="col-12 mb-2">
							<input type="hidden" name="ope">
							<button type="button" id="btn" onclick="ope.value = this.value" value="Register" class="btn btn-warning btn-block">Registrar</button>
						</div>
					</div>
				</form>
				<?php }?>
				<p class="mb-0">
					<a href="<?php echo constant("URL");?>auth/login" class="text-center">Ya tengo Cuenta</a>
				</p>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
	<?php
		$this->GetComplement("scripts");
		if(isset($result['message'])) $this->ObjMessage->MensajePersonal($result['message']);
	?>
	<script>
		$("#btn").click( async () =>{ if($("#formulario").valid()){ $("#formulario").submit(); }})

		const Get_respuestas = (id_element, id_pregun) => {
			fetch(`<?php echo constant("URL");?>controller/c_auth.php?ope=Get_respuesta&id=${id_pregun}`)
			.then( response => response.json())
			.then( datos => {

				$(`${id_element} option[value!='']`).remove();

				datos.data.forEach( dato => {
					$(id_element).append(`<option value='${dato.id_respues}'>${dato.des_respues}</option>`)
				})

				if(id_element != "#respues_2"){
					$(`#pregun2 option[value!='${id_pregun}']`).attr("selected", true);
					$(`#pregun2 option[value!='${id_pregun}']`).attr("disabled", false);
					$(`#pregun2 option[value='${id_pregun}']`).attr("disabled", true);

					Get_respuestas('#respues_2', $('#pregun2').val())
				}

			}).catch( Err => console.error(Err))
		}

		$("#formulario").validate({
			rules:{
				user_id:{
					required: true,
					minlength: 7,
					maxlength: 8,
					number: true,
				},
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
				user_id:{
					required: "Este campo es Obligatorio",
					minlength: "Mínimo 7 caracteres Numéricos para la Cédula",
					maxlength: "Maximo 8 caracteres Numéricos para la Cédula",
					number: "Sólo se Aceptan Números",
				},
				password:{
					required: "Este campo es Obligatorio",
					minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
					maxlength: "Máximo de 20 caracteres para una Contraseña",
					pattern: "Se debe de Ingresar una Clave más Segura (1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
				},
				password2:{
					required: "Este campo es Obligatorio",
					minlength: "Mínimo de 8 caracteres para Ingresar una Contraseña",
					maxlength: "Máximo de 20 caracteres para una Contraseña",
					pattern: "Se debe de Ingresar una Clave más Segura (1 Mayúscula, 1 Minúscula, 1 Número y un Caracter Especial, 8 caracteres Mínimo)",
					equalTo: "Las Contraseñas Ingresadas NO Conciden"
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
</body>
</html>
