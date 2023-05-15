<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Registro de Cargos";

        $this->GetComplement("navbar");
        // $this->GetComplement("sidebar");
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
                            <h3 class="card-title">Formulario de Registro de Cargos</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_cargo.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="hidden" name="id_cargo">
                                            <label for="des_cargo">Nombre del cargo(<span class="text-danger text-md">*</span>)</label>
                                            <input type="text" name="des_cargo" id="des_cargo" placeholder="Ingrese la descripción del cargo" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-4">
                                        <label for="">Estado del Cargo(<span class="text-danger text-md">*</span>)</label>
                                        <div class="row">
                                            <div class="form-check mx-3">
                                                <input type="radio" name="estatus_cargo" id="estatus_cargo" value="1" class="form-check-input" readonly checked>
                                                <label for="estatus_cargo" class="form-check-label">Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="estatus_cargo" id="estatus_cargo" value="0" class="form-check-input" disabled>
                                                <label for="estatus_cargo" class="form-check-label">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" name="ope" value="Registrar">
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
            des_cargo:{
                required: true,
                minlength: 3,
                maxlength: 20
            }
        },
        messages:{
            des_cargo:{
                required: "Este Campo NO Puede estar Vacio",
                minlength: "Debe de Contener al menos 3 caracteres",
                maxlength: "Debe de contener menos de 20 caracteres"
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
