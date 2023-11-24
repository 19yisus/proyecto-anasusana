<?php
require_once("./models/m_usuarios.php");
$model = new m_usuarios();
$roles = $model->Get_roles();
?>
<div class="modal fade" id="modal-lg">
	<div class="modal-dialog modal-lg" id="app_vue">
			<div class="modal-content">
					<div class="modal-header">
							<h4 class="modal-title">Consulta</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
					</div>
					<div class="modal-body">
							<div class="row">
									<div class="col-md-12">
											<div class="card card-primary">
													<div class="card-header">
															<h3 class="card-title">Formulario de Modificación de Usuarios</h3>
													</div>
													<!-- /.card-header -->
													<!-- form start -->
													<form id="formulario" action="<?php echo constant("URL");?>controller/c_usuario.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
															<div class="card-body">
																	<div class="row">
																			<div class="col-5 col-sm-12">
																					<div class="form-group">
																							<label for="id_user">Código del Usuario(<span class="text-danger text-md">*</span>)</label>
																							<input type="text" name="id_user" id="id_user" class="form-control" readonly>
																					</div>
																			</div>
																			<div class="col-7 col-sm-12">
																					<div class="form-group">
																							<label for="nom_user">Rol de Usuario(<span class="text-danger text-md">*</span>)</label>
																							<select name="rol_user" id="rol_user" class="custom-select">
																								<option value="">Seleccione una Opción</option>
																								<?php foreach($roles as $rol){?>
																									<option value="<?php echo $rol['id'];?>"><?php echo $rol['nom_rol'];?></option>
																								<?php }?>
																							</select>
																					</div>
																			</div>
																			<div class="col-7 col-sm-12">
																				<div class="form-group">
																					<label for="nom_user">Permisos de Vista(<span class="text-danger text-md">*</span>)</label>
																					<div class="row">
																						<div class="form-check mx-3" v-for="mod in modulos">
																							<input type="checkbox" name="modulos[]" :value="mod" class="form-check-input">
																							<label class="form-check-label">{{mod}}</label>
																						</div>
																					</div>
																				</div>
																			</div>
																	</div>
															</div>
															<!-- /.card-body -->
															<div class="card-footer">
																	<input type="hidden" name="ope" id="oper">
																	<button type="button" id="button" onclick="envio()" value="Actualizar" class="btn btn-primary">Actualizar</button>
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
<script>
	async function envio(){
		$("#oper").val("Actualizar")
		if($("#formulario").valid()){
			let res = await Confirmar();
			if(!res) return false;

			let datos = new FormData(document.formulario);
			fetch(`<?php echo constant("URL");?>controller/c_usuarios.php`, {
					method: "POST",
					body: datos,
			}).then( response => response.json())
			.then( res =>{
					FreshCatalogo();
					document.formulario.reset();
					$("#modal-lg").modal("hide");

					Toast.fire({
						icon: `${res.data.code}`,
						title: `${res.data.message}`
					});
			}).catch( Err => console.log(Err))
		}
	}

	$("#formulario").validate({
			rules:{
				rol_user:{
					required: true,
				}
			},
			messages:{
				rol_user:{
					required: "Debe de Seleccionar un Rol para el Usuario",
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
