<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
	<div class="wrapper" id="VueApp">
	  <?php
		$this->titleContent = "Registro de Entrada de Productos";

		$this->GetComplement("navbar");
		$this->GetComplement("sidebar");
		require_once("./models/m_entrada_salida.php");
		require_once("./models/m_persona.php");
		require_once("./models/m_comedor.php");

		$model = new m_entrada_salida();
		$NextId_inventario = $model->NextId("E");

		$model_comedor = new m_comedor();
		$datosComedor = $model_comedor->Get_todos_comedor(1);

		$model_person = new m_persona();
		$person = $model_person->Get_proveedor();

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
							<h3 class="card-title">Formulario de Registro de Entradas </h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form id="formulario" action="<?php echo constant("URL");?>controller/c_entrada_salida.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
							<div class="card-body">
								<div class="row">
									<div class="col-3">
										<div class="form-group">
											<label for="id_invent">Número de Operación</label>
											<input type="text" name="id_invent" id="id_invent" readonly value="<?php echo $NextId_inventario;?>" class="form-control">
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="comedor_id_invent">Comedor(<span class="text-danger text-md">*</span>)</label>
											<select name="comedor_id_invent" id="comedor_id_invent" class="custom-select" readonly>
												<option value="">Seleccione una Opción</option>
												<?php foreach($datosComedor as $comedor){?>
												<option value="<?php echo $comedor['id_comedor'];?>"><?php echo $comedor['nom_comedor'];?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="orden_invent">N° Orden(<span class="text-danger text-md">*</span>)</label>
											<input type="text" name="orden_invent" id="orden_invent" class="form-control" placeholder="Ingrese el Número de Orden" maxlength="20">
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="person_id_invent">Selecione el Proveedor(<span class="text-danger text-md">*</span>)</label>
											<select name="person_id_invent" id="person_id_invent" class="custom-select special_select2">
												<option value="">Seleccione un Proveedor</option>
												<?php foreach($person as $persona){?>
												<option value="<?php echo $persona['id_person'];?>"><?php echo $persona['tipo_person']."-".$persona['cedula_person']." ".$persona['nom_person'];?></option>
												<?php }?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-3">
										<div class="form-group">
											<label for="concept_invent">Concepto de Operación(<span class="text-danger text-md">*</span>)</label>
											<select name="concept_invent" id="concept_invent" class="custom-select">
												<option value="">Seleccione un Proveedor</option>
												<option value="C">Compra</option>
												<option value="D">Donación</option>
											</select>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="fecha_invent">Fecha de la Operación(<span class="text-danger text-md">*</span>)</label>
											<input type="datetime-local" name="fecha_invent" id="" class="form-control" max="<?php echo $this->thisDateMoreOneHour();?>" value="<?php echo $this->DateNow("Y-m-d H:i");?>" >
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<input type="hidden" min="0" name="cantidad_invent" id="cant_ope" class="form-control" readonly :value="cantidad_productos">
											<label for="observacion_invent">Observación(<span class="text-danger text-md">*</span>)</label>
											<textarea name="observacion_invent" minlength="4" maxlength="120" id="" cols="30" rows="2" class="form-control" placeholder="Ingrese una Observación para esta operación"></textarea>
										</div>
									</div>
									<div class="d-none" v-for="(item, index) in productos" id="lista_alimentos" :key="index">
										<input type="hidden" class="id_input" name="id_product[]" :value="item.code">
										<input type="hidden" name="precio_product[]" :value="item.precio">
										<input type="hidden" class="cant_input" name="cantidad_product[]" :value="item.cantidad">
										<input type="hidden" name="fecha_product[]" :value="item.fecha">
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
															<th>Precio</th>
															<th>Fecha de Vencimiento</th>
														</tr>
													</thead>
													<tbody>
														<tr v-for="(item, index) in productos" :key="index">
															<td>{{ item.code }}</td>
															<td>{{ item.nom_product }}</td>
															<td>{{ item.cantidad }}</td>
															<td>{{ item.precio }}</td>
															<td>{{ item.fecha }}</td>
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
								<button type="button" id="btn" onclick="ope.value = this.value" value="Entrada" class="btn btn-primary">
									<i class="fas fa-save"></i>
									Registrar Entrada
								</button>
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
									<i class="fas fa-plus-square"></i> Agregar Productos</button>
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
		require_once("./views/contents/entradas/modal.php");
		?>
	</div>
<!-- ./wrapper -->
<script>
	new Vue({
		el: '#VueApp',
		data: {
		productos: [
			// {code: "", nom_product: "", precio: 0, cantidad: 0, fecha: ""},
		],
		},
		methods: {
			Duplicar: function () {
				let datos = this.productos[this.productos.length - 1];
				if(typeof datos == "undefined"){
					this.productos.push({code: "",  nom_product: "",precio: 0, cantidad: 1, fecha: ""});
					return false;
				}

				if(datos.cantidad > 0 && datos.code != ""){
					this.productos.push({code: "", nom_product: "", precio: 0, cantidad: 1, fecha: ""})
				}else{
					Toast.fire({
						icon: "error",
						title: "Completa los campos antes de agregar otro producto"
					});
				}
			},
			Disminuir: function(codigo){
				this.productos[codigo].cantidad = parseInt(this.productos[codigo].cantidad);
				this.productos[codigo].cantidad -= 1;
				if(this.productos[codigo].cantidad === 0 || this.productos[codigo].cantidad < 0) this.productos.splice(codigo, 1);
			},
			resetProductos: function(){
				while(this.productos.length > 0){
					this.Disminuir(this.productos.length - 1)
				}
			},
			ConsultarName: async function(index){
				await fetch(`<?php echo constant("URL");?>controller/c_productos.php?ope=Consultar_producto&id_producto=${this.productos[index].code}`)
				.then( response => response.json()).then( ({data}) => {
					this.productos[index].nom_product = data.nom_product;
					this.productos[index].cantidad = parseInt(this.productos[index].cantidad);
				}).catch( error => console.error(error));
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
	})

	$("#btn").click( async () =>{
		if($("#formulario").valid()){
			let status_inputs = true;
			document.querySelectorAll(".id_input").forEach( item =>{ if(item.value == "") status_inputs = false;});
			document.querySelectorAll(".cant_input").forEach( item =>{ if(parseInt(item.value) == 0) status_inputs = false;});

			if(!status_inputs) return Toast.fire({icon: "error",title: "Los datos de los Productos están Incompletos"});

			if($("#cant_ope").val() == 0) return Toast.fire({icon: "error",title: "Debes de Ingresar Productos para realizar esta Operación"});
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
			observacion_invent:{
				required: true,
				minlength: 4,
				maxlength: 120,
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
				required: "Debe Seleccionar un Comedor",
			},
			orden_invent:{
				required: "El Número de orden es Requerido",
				number: "Sólo se aceptan Números",
				maxlength:"Máximo 20 caracteres numéricos",
			},
			person_id_invent:{
				required: "Debe seleccionar un Proveedor",
			},
			recibe_person_id_invent: {
				required: "Debe Seleccionar quién recibe los Productos",
			},
			observacion_invent:{
				required: "La observación para ésta operación es Necesaria",
				minlength: "La Observación puede ser de mínimo 4 caracteres",
				maxlength: "Máximo 120 caracteres",
			},
			concept_invent:{
			  required: "Seleccione el Concepto para ésta Operación",
			},
			fecha_invent:{
				required: "La Fecha de ésta Operación es Necesaria",
				max: "Ésta fecha no puede superar la Fecha y Hora actual",
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
