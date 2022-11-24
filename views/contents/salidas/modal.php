<?php
require("./models/m_productos.php");
$model = new m_productos();
$productos = $model->Get_todos_productos(2);

?>
<div class="modal fade" id="modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Lista de Productos</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Productos para esta Transacción </h3>
							</div>
							<!-- /.card-header -->
							<!-- form start -->
							<form id="formulario" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
								<div class="card-body" id="caja">
									<div class="row d-flex align-items-center" v-for="(item, index) in productos" :key="index">
										<div class="col-6">
											<div class="form-group d-block">
												<label for="id_product">Datos Generales del Producto(<span class="text-danger text-md">*</span>)</label>
												<!-- special_select2 lo dejo aca por si acaso -->
												<select name="id_product" v-model="productos[index].code" :data-index="index" v-on:change="ConsultarName" :id="index" class="custom-select">
													<option value=".">Seleccione un Producto</option>
													<?php foreach ($productos as $item) { ?>
														<option value="<?php echo $item['id_product']; ?>"><?php echo $item['nom_product'] . " - " . $item['nom_marca'] . ' - ' . $item['valor_product'] . $item['med_product']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-5">
											<div class="form-group">
												<label for="cant_product">Cantidad(<span class="text-danger text-md">*</span>)</label>
												<input type="number" v-on:keyup="validaCantidad" name="cant_product" :data-index="index" :max="item.limite_stock" min="0" v-model="productos[index].cantidad" :value="item.cantidad" id="cant_product" placeholder="Ingrese la cantidad" class="form-control">
											</div>
										</div>
										<button type="button" v-on:click="Disminuir(index)" class="btn btn-danger mt-3">-</button>
									</div>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<button type="button" v-on:click="Duplicar" id="btn_duplicar" class="btn btn-success"><i class="fas fa-plus-square"></i> Más Productos</button>
									<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary"><i class="fas fa-save"></i> Guardar y Salir</button>
									<button type="button" v-on:click="resetProductos" class="btn btn-danger"><i class="fas fa-trash"></i> Cancelar</button>
								</div>
							</form>
						</div>
						<!-- /.card -->
					</div>
					<!-- /.row -->
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->