<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
	<div class="wrapper" id="VueAPP">
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

		$person = $model_person->Get_proveedor();

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
														<option value="R">Remanente</option>
													</select>
												</div>
											</div>
											<div class="col-3">
												<div class="form-group">
													<label for="comedor_id_invent">Comedor(<span class="text-danger text-md">*</span>)</label>
													<input type="hidden" name="comedor_id_invent" id="comedor_id_invent" value="<?php echo $datosComedor[0]['id_comedor']; ?>">
													<input type="text" name="" id="" readonly value="<?php echo $datosComedor[0]['nom_comedor']; ?>" class="form-control">
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
													<input type="hidden" min="1" name="cantidad_invent" id="cant_ope" class="form-control" readonly :value="cantidad_salida">
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
										<!-- INFORMACIÓN GENERAL DEL MENU AL SELECCIONAR LA JORNADA -->
										<!-- {code: "",nom_product: "fasdf", cantidad: 0, limite_stock: 0}, -->
										<div class="row" v-show="valida_jornada_concepto">
											<div class="col-12">
												<div class="card card-success">
													<div class="card-header">
														<h4 class="card-title">
															Información de la jornada |
															Jornada "{{titulo_jornada}} |
															Menú del dia "{{titulo_menu}}" |
															<br>
															Cantidad aproximada de beneficiados: {{cant_aproximada}}
														</h4>
													</div>
													<div class="card-body">
														<table id="dataTable" class="table table-bordered table-striped">
															<thead>
																<tr>
																	<th>Ingredientes</th>
																	<th>Consumo</th>
																	<th>Calculo</th>
																	<th>Total</th>
																</tr>
															</thead>
															<tbody>
																<tr v-for="(item, index) in ingrediente" :key="index">
																	<td>{{ item.nom_product }}</td>
																	<td>{{ item.consumo }} {{ item.med_comida_detalle }}</td>
																	<td>{{cant_aproximada}} beneficiados * {{item.consumo}} {{item.med_comida_detalle}} de consumo => </td>
																	<td>{{ calculo(item.consumo,item.med_comida_detalle) }}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div class="card card-dark">
													<div class="card-header">
														<h4 class="card-title">Productos en esta Operación </h4>
													</div>
													<div class="card-body">
														<table id="dataTable" class="table table-bordered table-striped">
															<thead>
																<tr>
																	<th>Código</th>
																	<th>Descripción</th>
																	<th>Cantidad</th>
																	<th>Existencia restante en stock</th>
																</tr>
															</thead>
															<tbody>
																<tr v-for="(item, index) in productos" :key="index">
																	<td>{{ item.code }}</td>
																	<td>{{ item.nom_product }}</td>
																	<td>{{ item.cantidad }}</td>
																	<td>{{ calculo_stock(item.stock,item.cantidad)}}</td>
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
										<button type="button" v-bind:disabled="save_condicion" id="btn" onclick="ope.value = this.value" value="Salida" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Salida</button>
										<button type="button" v-bind:disabled="enviar_condicion" class="btn btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus-square"></i> Agregar Productos</button>
										<button type="button" v-show="save_condicion" @click="Get_jornada()" class="btn btn-info" data-toggle="modal" data-target="#modal-lg_jornada"><i class="fas fa-plus-square"></i> Editar Jornada</button>
										<button type="button" v-show="save_condicion" @click="Get_menu()" class="btn btn-warning" data-toggle="modal" data-target="#modal-lg_menu"><i class="fas fa-plus-square"></i> Editar Menú</button>
										<button type="button" v-show="save_condicion" @click="next_entrada()" class="btn btn-warning" data-toggle="modal" data-target="#modal-lg_entrada"><i class="fas fa-plus-square"></i> Entrada de productos</button>
									</div>
								</form>
							</div>
						</div>
						<!-- /.card -->
					</div>
					<!--/.col (left) -->
					<!--/.col (right) -->
				</div>
				<!-- /.row -->
			</section>
		</div><!-- /.container-fluid -->
		<!-- /.content -->
		<!-- /.content-wrapper -->
		<?php
		$this->GetComplement("footer");
		$this->GetComplement("scripts");
		require_once("./views/contents/salidas/modal.php");
		require_once("./views/contents/salidas/modal_entrada.php");
		require_once("./views/contents/salidas/modal_jornada.php");
		require_once("./views/contents/salidas/modal_menu.php");

		?>
	</div>
	<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
	<!-- ./wrapper -->
	<script>
		const app = new Vue({
			el: '#VueAPP',
			data: {
				productos: [
					// {code: "",nom_product: "fasdf", cantidad: 0, limite_stock: 0, stock_maximo: 0, nuevo_stock, if_entrada},
				],
				mensaje: "fasdfasdfsad",
				motivo_salida: "",

				cant_menu: "",
				nom_menu: "",
				titulo_jornada: "",
				titulo_menu: "",

				// DATOS DE LA JORNADA
				jornada_id: "",
				jornada_titulo: "",
				jornada_des: "",
				jornada_cant: "",
				menu_id_jornada: "",
				jornada_fecha: "",
				responsable: '',
				selectMenu: [{}],

				// DATOS DEL MENÚ
				id_menu: "",
				productos_menu: [],
				des_menu: "",
				selectProductos: [{}],

				// DATOS DE LA ENTRADA
				next_id_entrada: '',
				concepto_operacion: '',
				id_comedor: '',

				cant_aproximada: 0,
				enviar_condicion: false,
				save_condicion: false,
				ingrediente: []
			},
			methods: {
				async next_entrada() {
					await fetch(`<?php echo constant("URL"); ?>controller/c_entrada_salida.php?ope=next_ope&&type=E`)
						.then(response => response.json())
						.then(({
							data
						}) => {
							console.log(data)
							this.next_id_entrada = data;
						}).catch(error => console.error(error));
				},
				async get_menus() {
					await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Todos_menu`)
						.then(response => response.json())
						.then(({
							data
						}) => {
							this.selectMenu = data;
						}).catch(error => console.error(error));
				},
				async GetAlimentos() {
					await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Get_alimentos`)
						.then(response => response.json())
						.then(({
							data
						}) => {
							this.selectProductos = data;
						}).catch(error => console.error(error));
				},
				async Get_jornada() {
					await fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php?ope=Consultar_jornada&id_jornada=${this.jornada_id}`)
						.then(response => response.json()).then(({
							data
						}) => {
							this.jornada_id = data[0].id_jornada
							this.jornada_titulo = data[0].titulo_jornada;
							this.jornada_des = data[0].des_jornada;
							this.jornada_cant = data[0].cant_aproximada;
							this.menu_id_jornada = data[0].menu_id_jornada;
							this.jornada_fecha = data[0].fecha_jornada;
							this.responsable = data[0].person_id_responsable
						})
						.catch(Err => {
							console.error(Err)
						});
				},
				async Get_menu() {
					await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Consultar_menu&id_menu=${this.id_menu}`)
						.then(response => response.json()).then(({
							data
						}) => {
							console.log(data)
							this.id_menu = data[0].id_menu;
							this.des_menu = data[0].des_menu;
							this.productos_menu = []

							data[1].forEach(item => {
								this.productos_menu.push({
									id: item.product_id_menu_detalle,
									des: item.nom_product,
									medida: item.med_comida_detalle,
									cantidad: item.consumo
								})
							})
						})
						.catch(Err => {
							console.error(Err)
						});
				},
				async consultar_jornada() {
					if (this.jornada_id == '') {
						this.enviar_condicion = true;
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
							let datos_jornada = data[0];
							this.titulo_jornada = datos_jornada.titulo_jornada;
							this.titulo_menu = datos_jornada.des_menu;
							this.cant_aproximada = datos_jornada.cant_aproximada;
							this.ingrediente = data[1];
							this.id_menu = datos_jornada.id_menu;
							let si_sobrePasa = false;

							datos_menu.forEach(item => {
								let stock = parseInt(item.stock_product)
								let consumo = parseInt(item.consumo)
								let cant_proximada = parseInt(this.cant_aproximada)
								let total = (consumo * cant_proximada);
								let consumo_total;

								if (total > 999 && item.med_comida_detalle != item.med_product) {
									consumo_total = total / 1000;
									if (!Number.isInteger(consumo_total)) consumo_total = Math.round(consumo_total)
								} else {
									if (item.med_comida_detalle == "GM") {
										consumo_total = 1;
									} else consumo_total = total;
								}
								let restante = (item.stock_product - consumo_total);
								let if_entrada;
								let producto = [];
								producto["code"] = item.id_product;
								producto["nom"] = item.nom_product;
								producto["cantidad"] = consumo_total;
								producto["stock"] = parseInt(item.stock_product);
								producto["limite_stock"] = parseInt(item.stock_product);
								producto["maximo_stock"] = parseInt(item.stock_maximo_product) - parseInt(item.stock_product);
								producto["nuevo_stock"] = 0;
								if (restante <= 0) if_entrada = "SI";
								else if_entrada = "NO";
								producto["if_entrada"] = if_entrada;

								this.Duplicar(producto);
								if (producto['cantidad'] > producto['limite_stock']) {
									si_sobrePasa = true;
								}
							});

							if (si_sobrePasa) {
								this.save_condicion = true;
								this.Fn_mensaje_error("No coincide la cantidad requerida!");
							} else {
								this.save_condicion = false;
							}

						}).catch(error => console.error(error));
				},
				calculo(c, u) {
					if (this.cant_aproximada != 0) {
						let simplificado, med;
						let total = parseInt(c) * parseInt(this.cant_aproximada);
						if (total > 999 && u == "GM") {
							simplificado = total / 1000;
							if (u == "GM") med = "KL";
							if (u == "LT") med = "LT";
							if (u == "kL") med = "KL";

							if (!Number.isInteger(simplificado)) simplificado = Math.round(simplificado)
							return `${total} ${u} Ó ${simplificado} ${med}`;
						}
						return `${total} ${u}`;
					}
					return '';
				},
				calculo_stock(stock, cantidad) {
					let stock_min = parseInt(stock)
					let total = parseInt(stock_min) - parseInt(cantidad);
					return total;
				},
				duplicar() {
					this.productos_menu.push({
						id: '',
						des: '',
						medida: '',
						cantidad: 1
					})
				},
				Disminuir_menu(indice) {
					this.productos_menu.splice(indice, 1);
				},
				disminuir() {
					this.productos_menu.pop();
				},
				cambio_menu_modal(e) {
					let contador = 0;
					this.productos.forEach(item => {
						if (item.id == e.target.value) contador += 1
					})
					if (contador > 1) {
						$(`#${e.target.id} option[value='']`).attr('selected', true);
						alert("No se pueden duplicar los alimentos")
						return false;
					}
					if (e.target.value == "") return false;
					let {
						med_product
					} = this.selectProductos.filter(item => item.id_product == e.target.value)[0];
					this.productos = this.productos.map(item => {
						if (item.id == e.target.value) item.medida = med_product;
						return item;
					})
				},
				Duplicar: function(item = []) {

					if (item["code"]) {
						this.productos.push({
							code: item['code'],
							nom_product: item['nom'],
							cantidad: item['cantidad'],
							limite_stock: item['limite_stock'],
							stock: item['stock'],
							stock_maximo: item['maximo_stock'],
							nuevo_stock: item['nuevo_stock'],
							if_entrada: item['if_entrada']
						});
						return false;
					}

					let datos = this.productos[this.productos.length - 1];
					if (typeof datos == "undefined") {
						this.productos.push({
							code: "",
							nom_product: "",
							cantidad: 0,
							limite_stock: 0,
							stock: 0,
							stock_maximo: 0,
							nuevo_stock: 0,
							if_entrada: "NO"
						}, );
						return false;
					}

					if (datos.cantidad > 0 && datos.code != "") {
						this.productos.push({
							code: "",
							nom_product: "",
							cantidad: 0,
							limite_stock: 0,
							stock: 0,
							stock_maximo: 0,
							nuevo_stock: 0,
							if_entrada: "NO"
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
					this.productos[e.target.dataset.index].limite_stock = (parseInt(resultado.stock_product));
				},
				limpiarProductos() {
					this.productos = [];
					this.ingrediente = [];
					this.titulo_jornada = '';
					this.titulo_menu = '';
					this.cant_aproximada = 0;
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
							this.productos[e.target.dataset.index].cantidad = 1;
							this.productos[e.target.dataset.index].stock = data.data.stock_product;
							this.productos[e.target.dataset.index].stock_maximo = parseInt(data.stock_maximo_product) - parseInt(data.stock_product);
							this.productos[e.target.dataset.index].nuevo_stock = parseInt(1);
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

					if (this.productos[element.target.dataset.index].cantidad == 0) {
						this.Fn_mensaje_error("El cantidad no puede ser 0");
						this.productos[element.target.dataset.index].cantidad = 1;
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
				validarStockMaximo: function(index) {
					let input = index.target,
						value = parseInt(input.value),
						maximo = parseInt(input.max);

					if (value > maximo) {
						this.Fn_mensaje_error(`No se puede superar el Stock Maximo de este producto (${this.productos[input.dataset.index].stock_maximo})`);
						this.productos[input.dataset.index].nuevo_stock = maximo;
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
				cantidad_salida: function() {
					if (this.productos.length === 0) return 0;
					let array = this.productos.map(element => parseInt(element.cantidad));
					let total = array.reduce((item1, item2) => item1 + item2, 0);

					return total;
				},
				cantidad_productos: function() {
					if (this.productos.length === 0) return 0;
					let array = this.productos.map(element => parseInt(element.nuevo_stock));
					let total = array.reduce((item1, item2) => item1 + item2, 0);

					return total;
				},
				valida_jornada_concepto: function() {
					if (this.jornada_id != '' && this.motivo_salida == "O") return true;
					else {
						this.productos = [];
						this.jornada_id = '';
						return false;
					}
				}
			},
			async mounted() {
				await this.get_menus()
				await this.GetAlimentos()
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

				if (app.productos.length == 0 || app.productos[0].cantidad == 0 && app.productos[0].id == '') {
					return Toast.fire({
						icon: "error",
						title: "Debes de Ingresar Productos para Realizar esta Operación"
					});
				}

				// if ($("#cant_ope").val() == 0) return Toast.fire({
				// 	icon: "error",
				// 	title: "Debes de Ingresar Productos para Realizar esta Operación"
				// });

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