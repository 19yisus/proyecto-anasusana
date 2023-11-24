<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
	<div class="wrapper">
		<?php
		$this->titleContent = "Formulario de Registros de Productos";

		$this->GetComplement("navbar");
		// $this->GetComplement("sidebar");
		require_once("./models/m_marca.php");

		$model_marca = new m_marca();
		$marcas = $model_marca->Get_todos_marcas(1);
		?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php $this->GetComplement("contentHeader"); ?>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Formulario de Registro de Productos</h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form id="formulario" action="<?php echo constant("URL"); ?>controller/c_productos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
									<div class="card-body">
										<div class="row">
											<div class="col-6">
												<div class="form-group">
													<label for="nom_producto">Nombre del Producto(<span class="text-danger text-md">*</span>)</label>
													<input type="text" name="nom_producto" id="nom_producto" placeholder="Ingrese el Nombre del Producto" class="form-control">
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="">Unidad de Medida(<span class="text-danger text-md">*</span>)</label>
													<select name="med_producto" id="med_producto" class="custom-select">
														<option value="">Seleccione una Medida</option>
														<option value="KL">Kilo gramos (KL)</option>
														<option value="GM">Gramos (G)</option>
														<option value="LT">Litros (L)</option>
														<option value="ML">Mililitros (ML)</option>
													</select>
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="">Cantidad de Medida(<span class="text-danger text-md">*</span>)</label>
													<input type="number" name="valor_producto" step="0.01" min="0.01" id="valor_producto" class="form-control" placeholder="Ingrese un Valor">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-3">
												<div class="form-group">
													<label for="">Stock Maximo(<span class="text-danger text-md">*</span>)</label>
													<input type="number" name="stock_maximo_producto" step="1" min="1" id="stock_maximo_producto" class="form-control" placeholder="Ingrese los valores">
												</div>
											</div>
											<div class="col-4">
												<div class="form-group">
													<label for="">Marca del Producto(<span class="text-danger text-md">*</span>)</label>
													<select name="marca_id_producto" id="marca_id_producto" class="custom-select">
														<option value="">Seleccione una Marca</option>
													</select>
												</div>
											</div>
											<div class="col-2">
												<label for="">Peresedero?(<span class="text-danger text-md">*</span>)</label>
												<div class="row">
													<div class="form-check mx-3">
														<input type="radio" name="peresedero_if" id="peresedero_if1" value="1" class="form-check-input">
														<label for="peresedero_if" class="form-check-label">Si</label>
													</div>
													<div class="form-check">
														<input type="radio" name="peresedero_if" id="peresedero_if2" value="0" class="form-check-input" checked>
														<label for="peresedero_if" class="form-check-label">No</label>
													</div>
												</div>
											</div>
											<div class="col-4">
												<label for="">Estado del Producto(<span class="text-danger text-md">*</span>)</label>
												<div class="row">
													<div class="form-check mx-3">
														<input type="radio" name="status_producto" id="status_producto" value="1" class="form-check-input" readonly checked>
														<label for="status_producto" class="form-check-label">Activo</label>
													</div>
													<div class="form-check">
														<input type="radio" name="status_producto" id="status_producto" value="0" class="form-check-input" disabled>
														<label for="status_producto" class="form-check-label">Inactivo</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.card-body -->
									<div class="card-footer">
										<input type="hidden" name="ope">
										<button type="button" title="Botón para registrar" id="btn" onclick="ope.value = this.value" value="Registrar" class="btn btn-primary">
											<i class="fas fa-save"></i>Registrar
										</button>
										<button class="btn btn-success" title="Botón para añadir una nueva marca" data-toggle="modal" data-target="#modal-lg-marca" type="button">Añadir Marcas <i class="fas fa-plus-square"></i></button>
									</div>
								</form>
							</div>
							<!-- /.card -->
						</div>
						<!--/.col (left) -->
						<!--/.col (right) -->
					</div>
					<!-- /.row -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
			
		</div>
		<!-- /.content-wrapper -->
		<?php $this->GetComplement("footer"); ?>
	</div>
	<!-- ./wrapper -->
	<?php
	$this->GetComplement("scripts");
	require_once("./views/contents/productos/modal_marcas.php");
	?>
	<script>
		$("#btn").click(async () => {
			if ($("#formulario").valid()) {
				let res = await Confirmar();
				if (res) $("#formulario").submit();
			}
		})

		const consultarMarcasToSelect = () => {
			fetch(`<?php echo constant("URL"); ?>controller/c_marca.php?ope=Todos_marcas`).then(response => response.json())
				.then(res => {
					$("#marca_id_producto option[value!='']").remove();
					res.data.forEach( i =>{
						console.log(i)
						$("#marca_id_producto").append(`<option value="${i.id_marca}">${i.nom_marca}</option>`)
					})
				}).catch(Err => console.log(Err))
		}

		$("#peresedero_if1").click(() => {
			$("#marca_id_producto").val('');
			$("#marca_id_producto").attr("disabled", "true")
		});

		$("#peresedero_if2").click(() => $("#marca_id_producto").removeAttr("disabled"));

		$("#formulario").validate({
			rules: {
				nom_producto: {
					required: true,
					minlength: 3,
				},
				med_producto: {
					required: true,
				},
				valor_producto: {
					required: true,
					number: true,
				},
				stock_maximo_producto: {
					required: true,
					number: true,
				},
				marca_id_producto: {
					required: true
				}
			},
			messages: {
				nom_producto: {
					required: "Este Campo NO puede estar Vacio",
					minlength: "Debe de Contener al menos 3 Caracteres",
				},
				med_producto: {
					required: "Debe de Seleccionar una Opción",
				},
				valor_producto: {
					required: "Este Campo NO puede estar Vacio",
					number: "Sólo se Aceptan Números"
				},
				stock_maximo_producto: {
					required: "Este Campo NO puede estar Vacio",
					number: "Sólo se Aceptan Números",
				},
				marca_id_producto: {
					required: "Debe de Seleccionar una Opción"
				}
			},
			errorElement: "span",
			errorPlacement: function(error, element) {
				error.addClass("invalid-feedback");
				element.closest(".form-group").append(error);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			}
		});
		consultarMarcasToSelect()
	</script>

</html>