<!DOCTYPE html>
<html lang="es">
	<?php $this->GetHeader(); ?>
	<body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
		<div class="wrapper" id="VueApp">
			<?php 
				$this->titleContent = "Registro de salida de productos";

				$this->GetComplement("navbar");
				$this->GetComplement("sidebar");
				require_once("./models/m_entrada_salida.php");
				require_once("./models/m_persona.php");
				require_once("./models/m_comedor.php");

				$model_salida = new m_entrada_salida();
				$NextId_inventario = $model_salida->NextId("S");

				$model_comedor = new m_comedor();
				$datosComedor = $model_comedor->Get_todos_comedor(1);

				$model_person = new m_persona();
				$person2 = $model_person->Get_Personas();
			?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<?php $this->GetComplement("contentHeader");?>
				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
								<div class="col-md-12">
										<div class="card card-primary">
												<div class="card-header">
														<h3 class="card-title">Formulario de registro de salidas </h3>
												</div>
												<!-- /.card-header -->
												<!-- form start -->
												<form id="formulario" action="<?php echo constant("URL");?>controller/c_entrada_salida.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
														<div class="card-body">
																<div class="row">
																		<div class="col-3">
																				<div class="form-group">
																						<label for="id_invent">Numero de operación</label>
																						<input type="text" name="id_invent" id="id_invent" readonly value="<?php echo $NextId_inventario;?>" class="form-control">
																				</div>
																		</div>
																		<div class="col-3">
																				<div class="form-group">
																						<label for="comedor_id_invent">Comedor(<span class="text-danger text-md">*</span>)</label>
																						<select name="comedor_id_invent" id="comedor_id_invent" class="custom-select" readonly>
																							<option value="">Seleccione una opcion</option>
																							<?php foreach($datosComedor as $comedor){?>
																							<option value="<?php echo $comedor['id_comedor'];?>"><?php echo $comedor['nom_comedor'];?></option>
																							<?php }?>
																						</select>
																				</div>
																		</div>
																		<div class="col-3">
																				<div class="form-group">
																						<label for="orden_invent">N° Orden(<span class="text-danger text-md">*</span>)</label>
																						<input type="text" maxlength="20" name="orden_invent" id="orden_invent" class="form-control" placeholder="Ingrese el numero de orden">
																				</div>
																		</div>
																		<div class="col-3">
																				<div class="form-group">
																						<label for="concept_invent">Concepto de operación(<span class="text-danger text-md">*</span>)</label>
																						<select name="concept_invent" id="concept_invent" class="custom-select">
																								<option value="">Seleccione una opcion</option>
																								<option value="O">Cónsumo</option>
																								<option value="V">Vencimiento</option>
																								<option value="R">Rechazo</option>
																						</select>
																				</div>
																		</div>
																</div>
																<div class="row">
																	<div class="col-3">
																		<div class="form-group">
																			<label for="fecha_invent">Fecha de la operación(<span class="text-danger text-md">*</span>)</label>
																			<input type="datetime-local" name="fecha_invent" id="" class="form-control" max="<?php echo $this->thisDateMoreOneHour();?>" value="<?php echo $this->DateNow("Y-m-d H:i");?>" >
																		</div>
																	</div>
																	<div class="col-3">
																		<div class="form-group">
																			<label for="recibe_person_id_invent">¿Quien recibe esto?(<span class="text-danger text-md">*</span>)</label>
																			<select name="recibe_person_id_invent" id="recibe_person_id_invent" class="custom-select special_select2">
																				<option value="">Seleccione a una persona</option>
																				<?php foreach($person2 as $persona){?>
																				<option value="<?php echo $persona['id_person'];?>"><?php echo $persona['tipo_person']."-".$persona['cedula_person']." ".$persona['nom_person'];?></option>
																				<?php }?>
																			</select>
																		</div>
																	</div>
																	<div class="col-6">
																		<div class="form-group">
																			<input type="hidden" min="0" name="cantidad_invent" id="cant_ope" class="form-control" readonly :value="cantidad_productos">
																			<label for="observacion_invent">Observación(<span class="text-danger text-md">*</span>)</label>
																			<textarea name="observacion_invent" minlength="4" maxlength="120" id="" cols="30" rows="2" class="form-control" placeholder="Ingrese una observacion para esta opearcion"></textarea>
																		</div>
																	</div>
																	<div class="d-none" v-for="(item, index) in productos" :key="index">
																		<input type="hidden" class="id_input" name="id_product[]" :value="item.code">
																		<input type="hidden" class="cant_input" name="cantidad_product[]" :value="item.cantidad">
																	</div>
																</div>
															<div class="row">
																<div class="col-12">
																	<div class="card card-dark">
																		<div class="card-header">
																			<h4 class="card-title">Productos en esta operación</h4>
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
																<button type="button" id="btn" onclick="ope.value = this.value" value="Salida" class="btn btn-primary"><i class="fas fa-save"></i> Registrar salida</button>
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus-square"></i> Agregar productos</button>
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
			]
		},
		methods: {
			Duplicar: function () {
				let datos = this.productos[this.productos.length - 1];
				if(typeof datos == "undefined"){
					this.productos.push({code: "",nom_product: "", cantidad: 0, limite_stock: 0},);
					return false;
				}

				if(datos.cantidad > 0 && datos.code != ""){
					this.productos.push({code: "",nom_product: "", cantidad: 0, limite_stock: 0},)
				}else{
					Toast.fire({
						icon: "error",
						title: "Selecciona un producto y su cantidad para proceder"
					});
				}
			},
			Disminuir: function(codigo){
				this.productos[codigo].cantidad = parseInt(this.productos[codigo].cantidad);
				this.productos[codigo].cantidad -= 1;
				if(this.productos[codigo].cantidad === 0 || this.productos[codigo].cantidad < 0) this.productos.splice(codigo, 1);
			},
			consulta_limite_stock: async function(e){
				let resultado = await fetch(`<?php echo constant("URL");?>controller/c_productos.php?ope=Consultar_producto&id_producto=${this.productos[e.target.dataset.index].code}`)
				.then( response => response.json()).then( res => res.data).catch( Err => console.error(Err));
				this.productos[e.target.dataset.index].limite_stock = resultado.stock_product;
			},
			resetProductos: function(){
				while(this.productos.length > 0){
					this.Disminuir(this.productos.length - 1)
				}
			},
			ConsultarName: async function(e){
				if(e.target.value == ".") return;

				if(this.CodigosDuplicados(e.target)){
					this.Fn_mensaje_error("No se puede seleccionar un producto dos veces en la misma operación!");
					return;
				}
				await this.consulta_limite_stock(e);
				await fetch(`<?php echo constant("URL");?>controller/c_productos.php?ope=Consultar_producto&id_producto=${this.productos[e.target.dataset.index].code}`)
				.then( response => response.json()).then( data => {
					this.productos[e.target.dataset.index].nom_product = data.data.nom_product;
					this.productos[e.target.dataset.index].cantidad = 0;
				}).catch( error => console.error(error));
			},
			CodigosDuplicados(element){
				let contador = 0;
				this.productos.forEach( item => { if(parseInt(item.code) == parseInt(element.value)) contador += 1})
				if(contador > 1){
					this.productos[element.dataset.index].code = "";
					$(`#${element.id} option[value='.']`).attr('selected', true);
				}
				return contador > 1;
			},
			validaCantidad: function(element){
				if(this.productos[element.target.dataset.index].code == ""){
					this.Fn_mensaje_error("Primero selecciona un producto para consultar su stock");
					return;
				}
				if(parseInt(element.target.max) == 0){
					this.Fn_mensaje_error("No hay stock para este producto");
					return;
				}

				if(parseInt(element.target.value) > parseInt(element.target.max)){
					this.productos[element.target.dataset.index].cantidad = this.productos[element.target.dataset.index].limite_stock;
					this.Fn_mensaje_error("No puedes sobrepasar el stock para este producto");
				}
			},
			Fn_mensaje_error: function(sms){
				Toast.fire({
					icon: "error",
					title: `${sms}`
				});
			}
		},
		computed: {
			cantidad_productos: function(){
				if(this.productos.length === 0) return 0;
				let array = this.productos.map( element => parseInt(element.cantidad));
				let total = array.reduce( (item1, item2) => item1 + item2, 0 );
				return total;
			}
		}
	});

	$("#btn").click( async () =>{
		if($("#formulario").valid()){
			let status_inputs = true;
			document.querySelectorAll(".id_input").forEach( item =>{ if(item.value == "") status_inputs = false;});
			document.querySelectorAll(".cant_input").forEach( item =>{ if(parseInt(item.value) == 0) status_inputs = false;});
			
			if(!status_inputs) return Toast.fire({icon: "error",title: "Los datos de los productos estan incompletos"});

			if($("#cant_ope").val() == 0) return Toast.fire({icon: "error",title: "Debes de ingresar productos para realizar esta operación"});
			
			let res = await Confirmar();
			if(res) $("#formulario").submit();
		}
	})

	$("#formulario").validate({
		rules:{
			comedor_id_invent:{
				required: true,
			},
			orden_invent:{
				number: true,
				required: true,
				maxlength:20,
			},
			person_id_invent:{
				required: true,
			},
			recibe_person_id_invent:{
				required: true,
			},
			observacion_invent:{
				required: true,
				minlength: 4,
				maxlength: 120,
			},
			cantidad_invent:{
				required: true,
				min: 1,
			},
			concept_invent:{
				required: true,
			},
			fecha_invent:{
				required: true,
			}
		},
		messages:{
			comedor_id_invent:{
				required: "Debe se seleccionar un comedor",
			},
			orden_invent:{
				required: "El numero de orden es requerido",
				number: "Solo se aceptan numeros",
				maxlength:"Maximo 20 caracteres numericos",
			},
			person_id_invent:{
				required: "Debe seleecionar un proveedor",
			},
			recibe_person_id_invent: {
				required: "Debe seleccionar quien recibe los productos",
			},
			observacion_invent:{
				required: "La observacion para esta operación es necesaria",
				minlength: "La observacion puede ser de minimo 4 caracteres",
				maxlength: "Maximo 120 caracteres",
			},
			cantidad_invent:{
				required: "Es necesario tener al menos 1 producto para esta operación",
				min: "Minimo 1 producto",
			},
			concept_invent:{
				required: "Seleccione el concepto para esta operación",
			},
			fecha_invent:{
				required: "La fecha de esta operación es necesaria",
				max: "Esta fecha no puede superar la fecha y hora actual",
			}
		},
		errorElement: "span",
		errorPlacement: function (error, element){
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},
		highlight: function (element, errorClass, validClass){
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass){
			$(element).removeClass('is-invalid');
		}
	});
</script>
</html>
