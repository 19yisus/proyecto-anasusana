<!-- pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" -->

<div class="">
	<div class="login-logo">
		<!-- <img src="<?php //echo constant("URL");
										?>views/images/logo.jpeg" alt="Logo" class="img-fluid rounded mx-auto d-block"> -->
	</div>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body rounded">
			<p class="login-box-msg">Registro de Nuevo Usuario</p>
			<?php if ($status_form == 1) { ?>
				<form action="#" method="post" autocomplete="off">
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
			<?php } else if ($status_form == 2) { ?>
				<form action="<?php echo constant("URL"); ?>controller/c_auth.php" autocomplete="off" id="formulario" method="post" class="needs-validation" novalidate>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="">Cédula del usuario(<span class="text-danger text-md">*</span>)</label>
								<div class="input-group mb-3">
									<input type="hidden" name="user_id" value="<?php echo $id; ?>">
									<input type="number" name="cedula" class="form-control" placeholder="Cédula" value="<?php echo $cedula; ?>" readonly>
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="">Contraseña(<span class="text-danger text-md">*</span>)</label>
								<div class="input-group mb-3">
									<input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" id="password" class="form-control" placeholder="Contraseña">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="">Confirme su contraseña(<span class="text-danger text-md">*</span>)</label>
								<div class="input-group mb-3">
									<input type="password" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,!@#$%^&*_=+-]).{8,20}$" class="form-control" placeholder="Confirmar Contraseña">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="">Todos los campos con (<span class="text-danger text-md">*</span>), obligatorios</label>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3 form-group">
								<label for="">Primera Pregunta de Seguridad(<span class="text-danger text-md">*</span>)</label>
								<select name="pregunta1" class="custom-select" id="" onchange="Get_respuestas('#respues_1', this.value)">
									<option value="">Seleccione una Pregunta</option>
									<?php foreach ($preguntas as $pregunta1) {
										$id_pregun1 = $pregunta1['id_pregun'];
									?>
										<option value="<?php echo $id_pregun1; ?>"><?php echo $pregunta1['des_pregun']; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="mb-3 form-group">
								<label for="">Primera Respuesta(<span class="text-danger text-md">*</span>)</label>
								<input type="text" name="respuesta1" id="" class="form-control" placeholder="Escriba su respuesta">
							</div>

							<div class="mb-3 form-group">
								<label for="">Segunda Pregunta de Seguridad(<span class="text-danger text-md">*</span>)</label>
								<select name="pregunta2" id="pregun2" class="custom-select" id="">
									<option value="">Seleccione una Pregunta</option>
									<?php foreach ($preguntas as $pregunta2) {
										$id_pregun2 = $pregunta2['id_pregun'];
									?>
										<option value="<?php echo $id_pregun2; ?>"><?php echo $pregunta2['des_pregun']; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="mb-3 form-group">
								<label for="">Segunda Respuesta(<span class="text-danger text-md">*</span>)</label>
								<input type="text" name="respuesta2" id="" class="form-control" placeholder="Escriba su respuesta">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 mb-2">
							<input type="hidden" name="ope">
							<button type="button" id="btn" onclick="ope.value = this.value" value="Register" class="btn btn-warning btn-block">Registrar</button>
						</div>
					</div>
				</form>
			<?php } ?>
			<p class="mb-0">
				<a href="<?php echo constant("URL"); ?>auth/login" class="text-center">Ya tengo Cuenta</a>
			</p>
		</div>
		<!-- /.login-card-body -->
	</div>
</div>