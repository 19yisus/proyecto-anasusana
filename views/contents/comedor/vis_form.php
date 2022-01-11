<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php 
        require_once("./models/m_persona.php");
        $model_person = new m_persona();
		$person = $model_person->Get_Personas();
        
        $this->titleContent = "Registro de comedor";

        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");        
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
                            <h3 class="card-title">Formulario de registro de comedor</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_comedor.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="hidden" name="id_comedor">
                                            <label for="nom_comedor">Nombre del comedor(<span class="text-danger text-md">*</span>)</label>
                                            <input type="text" name="nom_comedor" id="nom_comedor" placeholder="Ingrese el nombre del comedor" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
										<div class="form-group">
											<label for="encargado_comedor">Selecione al encargado(<span class="text-danger text-md">*</span>)</label>
											<select name="encargado_comedor" id="encargado_comedor" class="custom-select">
												<option value="">Seleccione una persona</option>
												<?php foreach($person as $persona){?>
												<option value="<?php echo $persona['id_person'];?>"><?php echo $persona['nom_person'];?></option>
												<?php }?>
											</select>
										</div>
									</div>
                                    <div class="col-4">
                                        <label for="">Estado del comedor(<span class="text-danger text-md">*</span>)</label>
                                        <div class="row">
                                            <div class="form-check mx-3">
                                                <input type="radio" name="status_comedor" id="status_comedor" value="1" class="form-check-input" readonly checked>
                                                <label for="status_comedor" class="form-check-label">Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="status_comedor" id="status_comedor" value="0" class="form-check-input" disabled>
                                                <label for="status_comedor" class="form-check-label">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="direccion_comedor">Dirección del comedor(<span class="text-danger text-md">*</span>)</label>
                                            <textarea name="direccion_comedor" class="form-control" maxlength="120" id="" cols="30" placeholder="Ingrese la direccion del comedor" rows="2"></textarea>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" name="ope">
                                <button type="button" id="btn" onclick="ope.value = this.value" value="Registrar" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Registrar
                                </button>
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
<?php $this->GetComplement("scripts");?>
<script>
    $("#btn").click( async () =>{
        if($("#formulario").valid()){
            let res = await Confirmar();
            if(res) $("#formulario").submit();
        }
    })

    $("#formulario").validate({
        rules:{
            nom_comedor:{
                required: true,
                minlength: 3,
            },
            encargado_comedor:{
                required: true,
            },
            direccion_comedor:{
                required: true,
                minlength: 5,
                maxlength: 120,
            }
        },
        messages:{
            nom_comedor:{
                required: "Este campo no puede estar vacio",
                minlength: "Debe de contener al menos 3 caracteres",
            },
            encargado_comedor:{
                required: "Debes de seleccionar al encargado del comedor",
            },
            direccion_comedor:{
                required: "La dirección del comedor es requerida",
                minlength: "Minimo de 5 letras",
                maxlength: "Maximo de 120 letras",
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
