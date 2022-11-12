<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
	<div class="wrapper" id="VueApp">
		<?php
		$this->titleContent = "Registro de Salida de Productos";

		$this->GetComplement("navbar");
		// $this->GetComplement("sidebar");
		require_once("./models/m_entrada_salida.php");
		require_once("./models/m_persona.php");
		require_once("./models/m_comedor.php");
		require_once("./models/m_jornada.php");

		$model_salida = new m_entrada_salida();
		$NextId_inventario = $model_salida->NextId("S");

		$model_comedor = new m_comedor();
		$datosComedor = $model_comedor->Get_todos_comedor(1);

		$model_person = new m_persona();
		$person2 = $model_person->Get_Personas();

		$model_jornada = new m_jornada();
		$datos_jornada = $model_jornada->Get_jornada_hoy();

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
									<h3 class="card-title">Formulario de Registro de Salidas </h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form id="formulario" action="<?php echo constant("URL"); ?>controller/c_entrada_salida.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
									<div class="card-body">
										<div class="row">
											<div class="col-3">
												<div class="form-group">
													<label for="id_invent">Número de Operación</label>
													<input type="text" name="id_invent" id="id_invent" readonly value="<?php echo $NextId_inventario; ?>" class="form-control">
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="concept_invent">Concepto de Operación(<span class="text-danger text-md">*</span>)</label>
													<select name="concept_invent" v-model="motivo_salida" id="concept_invent" class="custom-select">
														<option value="">Seleccione una Opción</option>
														<option value="O">Consumo</option>
														<option value="V">Vencimiento</option>
														<option value="R">Rechazo</option>
													</select>
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="comedor_id_invent">Comedor(<span class="text-danger text-md">*</span>)</label>
													<select name="comedor_id_invent" id="comedor_id_invent" class="custom-select" readonly>
														<option value="">Seleccione una Opción</option>
														<?php foreach ($datosComedor as $comedor) { ?>
															<option value="<?php echo $comedor['id_comedor']; ?>"><?php echo $comedor['nom_comedor']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="recibe_person_id_invent">¿Quién Recibe Esto?(<span class="text-danger text-md">*</span>)</label>
													<select name="recibe_person_id_invent" id="recibe_person_id_invent" class="custom-select special_select2">
														<option value="">Seleccione a una Persona</option>
														<?php foreach ($person2 as $persona) { ?>
															<option value="<?php echo $persona['id_person']; ?>"><?php echo $persona['tipo_person'] . "-" . $persona['cedula_person'] . " " . $persona['nom_person']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<!-- <div class="col-3">
												<div class="form-group">
													<label for="orden_invent">N° Orden</label>
													<input type="text" maxlength="20" name="orden_invent" id="orden_invent" class="form-control" placeholder="Ingrese el Número de Orden">
												</div>
											</div> -->

										</div>
										<div class="row">
											<div class="col-3" v-show="motivo_salida == 'O'">
												<div class="form-group">
													<label for="">Jornada(<span class="text-danger text-md">*</span>)</label>
													<select v-bind:disabled="motivo_salida != 'O'" v-model="jornada_id" name="jornada_id_invent" id="" class="form-control" v-on:change="consultar_jornada">
														<option value="">Seleccione una opción</option>
														<?php foreach ($datos_jornada as $item) { ?>
															<option value="<?php echo $item['id_jornada']; ?>"><?php echo $item['titulo_jornada']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="fecha_invent">Fecha de la Operación(<span class="text-danger text-md">*</span>)</label>
													<input type="datetime-local" name="fecha_invent" id="" class="form-control" max="<?php echo $this->thisDateMoreOneHour(); ?>" value="<?php echo $this->DateNow("Y-m-d H:i"); ?>">
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<input type="hidden" min="0" name="cantidad_invent" id="cant_ope" class="form-control" readonly :value="cantidad_productos">
													<label for="observacion_invent">Observación</label>
													<textarea name="observacion_invent" minlength="4" maxlength="120" id="" cols="30" rows="2" class="form-control" placeholder="Ingrese una Observacion para esta Operación"></textarea>
												</div>
											</div>
											<input type="hidden" v-bind:disabled="motivo_salida != 'O'" name="des_comidas" v-model="des_menu">
											<input type="hidden" v-bind:disabled="motivo_salida != 'O'" name="cantidad" v-model="cant_menu">
											<input type="hidden" v-bind:disabled="motivo_salida != 'O'" name="nom_comidas" v-model="nom_menu">

											<div class="d-none" v-for="(item, index) in productos" :key="index">
												<input type="hidden" class="id_input" name="id_product[]" :value="item.code">
												<input type="hidden" class="cant_input" name="cantidad_product[]" :value="item.cantidad">
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div class="card card-dark">
													<div class="card-header">
														<h4 class="card-title">Productos en esta Operación</h4>
													</div>
													<div class="card-body">
														<table id="dataTable" class="table table-bordered table-striped">
															<thead>
																<tr>
																	<th>Código</th>
																	<th>Descripción</th>
																	<th>Cantidad</th>
																</tr>
															</thead>
															<tbody>
																<tr v-for="(item, index) in productos" :key="index">
																	<td>{{ item.code }}</td>
																	<td>{{ item.nom_product }}</td>
																	<td>{{ item.cantidad }}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.card-body -->
									<div class="card-footer">
										<input type="hidden" name="ope">
										<button type="button" v-bind:disabled="enviar_condicion == false" id="btn" onclick="ope.value = this.value" value="Salida" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Salida</button>
										<button type="button" v-bind:disabled="jornada_id != '' " class="btn btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus-square"></i> Agregar Productos</button>
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

		<?php
		$this->GetComplement("footer");
		$this->GetComplement("scripts");
		require_once("./views/contents/salidas/modal.php");
		?>
	</div>
	<!-- ./wrapper -->
	<script>
		new Vue({
			el: '#VueApp',
			data: {
				productos: [
					// {code: "",nom_product: "", cantidad: 0, limite_stock: 0},
				],
				enviar_condicion: true,
				motivo_salida: "",
				jornada_id: "",
				des_menu: "",
				cant_menu: "",
				nom_menu: ""
			},
			methods: {
				Duplicar: function(product = []) {
					if (product['id_product'] != undefined) {
						this.productos.push({
							code: product['id_product'],
							nom_product: product['nom_product'],
							cantidad: product['consumo'],
							limite_stock: (parseInt(product['stock_product']) - parseInt(product['stock_minimo_product']))
						}, )
						return false;
					}

					let datos = this.productos[this.productos.length - 1];
					if (typeof datos == "undefined") {
						this.productos.push({
							code: "",
							nom_product: "",
							cantidad: 0,
							limite_stock: 0
						}, );
						return false;
					}

					if (datos.cantidad > 0 && datos.code != "") {
						this.productos.push({
							code: "",
							nom_product: "",
							cantidad: 0,
							limite_stock: 0
						}, )
					} else {
						Toast.fire({
							icon: "error",
							title: "Selecciona un Producto y su Cantidad para Proceder"
						});
					}

				},
				Disminuir: function(codigo) {
					this.productos[codigo].cantidad = parseInt(this.productos[codigo].cantidad);
					this.productos[codigo].cantidad -= 1;
					if (this.productos[codigo].cantidad === 0 || this.productos[codigo].cantidad < 0) this.productos.splice(codigo, 1);
				},
				consulta_limite_stock: async function(e) {
					let resultado = await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Consultar_producto&id_producto=${this.productos[e.target.dataset.index].code}`)
						.then(response => response.json()).then(res => res.data).catch(Err => console.error(Err));
					this.productos[e.target.dataset.index].limite_stock = (resultado.stock_product - resultado.stock_minimo_product);
				},
				async consultar_jornada() {
					if(this.jornada_id == ''){
						this.limpiarProductos();
						return false;
					}
					await fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php?ope=Consultar_jornada&id_jornada=${this.jornada_id}`)
						.then(response => response.json())
						.then(({
							data
						}) => {
							this.limpiarProductos()
							this.enviar_condicion = true;
							let datos_menu = data[1];

							datos_menu.forEach(item => {
								let stock = parseInt(item.stock_product),
									consumo = parseInt(item.consumo),
									minimo_stock = parseInt(item.stock_minimo_product);

								if (
									consumo < stock && (stock - consumo) > minimo_stock
								) {
									this.Duplicar(item);
								} else {
									this.Fn_mensaje_error(`No se tiene la capacidad para cubrir esta jornada, no hay suficiente ${item.nom_product}!`);
									this.enviar_condicion = false;
									setTimeout( () => {
										this.limpiarProductos()
									},100)
									return false;
								}
							})
						}).catch(error => console.error(error));
				},
				limpiarProductos() { 
					this.productos = []; 
				},
				resetProductos: function() {
					while (this.productos.length > 0) {
						this.Disminuir(this.productos.length - 1)
					}
				},
				ConsultarName: async function(e) {
					if (e.target.value == ".") return;

					if (this.CodigosDuplicados(e.target)) {
						this.Fn_mensaje_error("No se puede Seleccionar un Producto Dos veces en la Misma Operación!");
						return;
					}
					await this.consulta_limite_stock(e);
					await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Consultar_producto&id_producto=${this.productos[e.target.dataset.index].code}`)
						.then(response => response.json()).then(data => {
							this.productos[e.target.dataset.index].nom_product = data.data.nom_product;
							this.productos[e.target.dataset.index].cantidad = 0;
						}).catch(error => console.error(error));
				},
				CodigosDuplicados(element) {
					let contador = 0;
					this.productos.forEach(item => {
						if (parseInt(item.code) == parseInt(element.value)) contador += 1
					})
					if (contador > 1) {
						this.productos[element.dataset.index].code = "";
						$(`#${element.id} option[value='.']`).attr('selected', true);
					}
					return contador > 1;
				},
				validaCantidad: function(element) {
					if (this.productos[element.target.dataset.index].code == "") {
						this.Fn_mensaje_error("Primero Selecciona un Producto para Consultar su Disponibilidad");
						return;
					}
					if (parseInt(element.target.max) == 0) {
						this.Fn_mensaje_error("No hay Stock para este Producto");
						this.productos[element.target.dataset.index].cantidad = 0;
						return;
					}

					if (parseInt(element.target.value) > parseInt(element.target.max)) {
						this.productos[element.target.dataset.index].cantidad = this.productos[element.target.dataset.index].limite_stock;
						this.Fn_mensaje_error("No puedes Sobrepasar la cantidad en Stock de este Producto");
					}
				},
				Fn_mensaje_error: function(sms) {
					Toast.fire({
						icon: "error",
						title: `${sms}`,
						timer: 3000
					});
				}
			},
			computed: {
				cantidad_productos: function() {
					if (this.productos.length === 0) return 0;
					let array = this.productos.map(element => parseInt(element.cantidad));
					let total = array.reduce((item1, item2) => item1 + item2, 0);
					return total;
				}
			}
		});

		$("#btn").click(async () => {
			if ($("#formulario").valid()) {
				let status_inputs = true;

				document.querySelectorAll(".id_input").forEach(item => {
					if (item.value == "") status_inputs = false;
				});

				document.querySelectorAll(".cant_input").forEach(item => {
					if (parseInt(item.value) == 0) status_inputs = false;
				});

				if (!status_inputs) return Toast.fire({
					icon: "error",
					title: "Los Datos de los Productos están Incompletos"
				});

				if ($("#cant_ope").val() == 0) return Toast.fire({
					icon: "error",
					title: "Debes de Ingresar Productos para Realizar esta Operación"
				});

				let res = await Confirmar();
				if (res) $("#formulario").submit();
			}
		})

		$("#formulario").validate({
			rules: {
				comedor_id_invent: {
					required: true,
				},
				orden_invent: {
					number: true,
					required: false,
					maxlength: 20,
				},
				person_id_invent: {
					required: true,
				},
				recibe_person_id_invent: {
					required: true,
				},
				observacion_invent: {
					required: false,
					minlength: 4,
					maxlength: 120,
				},
				cantidad_invent: {
					required: true,
					min: 1,
				},
				concept_invent: {
					required: true,
				},
				fecha_invent: {
					required: true,
				}
			},
			messages: {
				comedor_id_invent: {
					required: "Debe se seleccionar un Comedor",
				},
				orden_invent: {
					required: "El Número de Orden es Requerido",
					number: "Sólo se Aceptan Números",
					maxlength: "Máximo 20 caracteres Numéricos",
				},
				person_id_invent: {
					required: "Debe Seleecionar un Proveedor",
				},
				recibe_person_id_invent: {
					required: "Debe Seleccionar quién Recibe los Productos",
				},
				observacion_invent: {
					required: "La Observación para esta operación es Necesaria",
					minlength: "La Observación puede ser de Mínimo 4 Caracteres",
					maxlength: "Máximo 120 caracteres",
				},
				cantidad_invent: {
					required: "Es Necesario tener al menos 1 Producto para esta Operación",
					min: "Mínimo 1 producto",
				},
				concept_invent: {
					required: "Seleccione el Concepto para esta Operación",
				},
				fecha_invent: {
					required: "La Fecha de esta Operación es Necesaria",
					max: "Esta Fecha no puede superar la Fecha y Hora actual",
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
	</script>

</html>