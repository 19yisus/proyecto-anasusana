<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        require_once("./models/m_persona.php");
        require_once("./models/m_comedor.php");

        $model_person = new m_persona();
		    $person = $model_person->Get_Personas();

        $model_comedor = new m_comedor();
        $resultSede = $model_comedor->ExisteSede();

        $this->titleContent = "Registro de Comedor";

        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");

        // var_dump($resultSede);
        // die("fasdfa");
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
                            <h3 class="card-title">Formulario de Registro de Comedor</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_comedor.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="hidden" name="id_comedor">
                                            <label for="nom_comedor">Nombre del Comedor(<span class="text-danger text-md">*</span>)</label>
                                            <input type="text" name="nom_comedor" id="nom_comedor" placeholder="Ingrese el Nombre del Comedor" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                  										<div class="form-group">
                  											<label for="encargado_comedor">Selecione al Encargado(<span class="text-danger text-md">*</span>)</label>
                  											<select name="encargado_comedor" id="encargado_comedor" class="custom-select">
                  												<option value="">Seleccione una Persona</option>
                  												<?php foreach($person as $persona){?>
                  												<option value="<?php echo $persona['id_person'];?>"><?php echo $persona['nom_person'];?></option>
                  												<?php }?>
                  											</select>
                  										</div>
                  									</div>
                                    <div class="col-4">
                                        <label for="">Estado del Comedor(<span class="text-danger text-md">*</span>)</label>
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
                                  <div class="col-2">
                                      <label for="">Es sede principal?(<span class="text-danger text-md">*</span>)</label>
                                      <div class="row">
                                          <div class="form-check mx-3">
                                            <input type="hidden" name="if_sede" value="<?php echo ($resultSede) ? 0 : 1 ; ?>">
                                              <input type="radio" name="if_sede" id="if_sede" value="1" class="form-check-input" disabled <?php if(!$resultSede) echo "checked"; ?> >
                                              <label for="if_sede" class="form-check-label">Si</label>
                                          </div>
                                          <div class="form-check">
                                              <input type="radio" name="if_sede" id="if_sede" value="0" class="form-check-input" disabled <?php if($resultSede) echo "checked"; ?> >
                                              <label for="if_sede" class="form-check-label">No</label>
                                          </div>
                                      </div>
                                  </div>
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label for="direccion_comedor">Dirección del Comedor(<span class="text-danger text-md">*</span>)</label>
                                            <textarea name="direccion_comedor" class="form-control" maxlength="120" id="" cols="30" placeholder="Ingrese la Dirección del Comedor" rows="2"></textarea>
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
                required: "Este Campo NO Puede estar Vacio",
                minlength: "Debe de Contener al menos 3 caracteres",
            },
            encargado_comedor:{
                required: "Debes de Seleccionar al Encargado del Comedor",
            },
            direccion_comedor:{
                required: "La Dirección del Comedor es Requerida",
                minlength: "Mínimo de 5 Letras",
                maxlength: "Máximo de 120 Letras",
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
