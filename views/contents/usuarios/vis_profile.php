<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Mi usuario";

        $this->GetComplement("navbar");
        require_once("./models/m_auth.php");
		    $model = new m_auth();
        $preguntas = $model->Get_Preguntas();
        $mi_profile = $model->Get_me($_SESSION['user_id']);
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
                          <h3 class="card-title">Configuración de mi usuario</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_usuarios.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-2">
                                <div class="form-group">
                                  <label for="">Cédula(<span class="text-danger text-md">*</span>)</label>
                                  <input type="hidden" name="id_user" value="<?php echo $mi_profile['id_user'];?>">
                                  <input type="hidden" name="id_person" value="<?php echo $mi_profile['id_person'];?>">
                                  <input type="text" readonly class="form-control" value="<?php echo $mi_profile['tipo_person']."-".$mi_profile['cedula_person'];?>">
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="form-group">
                                  <label for="">Nombre y Apellido(<span class="text-danger text-md">*</span>)</label>
                                  <input type="text" readonly class="form-control" value="<?php echo $mi_profile['nom_person'];?>">
                                </div>
                              </div>
                              <div class="col-5">
                                <div class="form-group">
                                  <label for="">Correo Electronico(<span class="text-danger text-md">*</span>)</label>
                                  <input type="text" class="form-control" value="<?php echo $mi_profile['correo_person'];?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <!-- <div class="col-3"></div>
                              <div class="col-3"></div> -->
                              <div class="col-6">
                                <div class="mb-3 form-group">
                                  <label for="">Primera Pregunta de Seguridad(<span class="text-danger text-md">*</span>)</label>
                                  <select name="pregunta1" class="custom-select" id="" onchange="Get_respuestas('#respues_1', this.value)">
                                    <option value="">Seleccione una Pregunta</option>
                                    <?php foreach($preguntas as $pregunta1){
                                      $id_pregun1 = $pregunta1['id_pregun'];
                                      ?>
                                      <option <?php echo ($id_pregun1 == $mi_profile['pregun1_user']) ? "selected" : "";?> value="<?php echo $id_pregun1; ?>"><?php echo $pregunta1['des_pregun'];?></option>
                                    <?php }?>
                                  </select>
                                </div>

                                <div class="mb-3 form-group">
                                  <label for="">Primera Respuesta(<span class="text-danger text-md">*</span>)</label>
                                  <input type="text" value="<?php echo $mi_profile['respuesta1_user'];?>" name="respuesta1" id="" class="form-control" placeholder="Escriba su respuesta">
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="mb-3 form-group">
                                  <label for="">Segunda Pregunta de Seguridad(<span class="text-danger text-md">*</span>)</label>
                                  <select name="pregunta2" id="pregun2" class="custom-select" id="">
                                    <option value="">Seleccione una Pregunta</option>
                                    <?php foreach($preguntas as $pregunta2){
                                      $id_pregun2 = $pregunta2['id_pregun'];
                                      ?>
                                      <option <?php echo ($id_pregun2 == $mi_profile['pregun2_user']) ? "selected" : "";?> value="<?php echo $id_pregun2; ?>"><?php echo $pregunta2['des_pregun'];?></option>
                                    <?php }?>
                                  </select>
                                </div>

                                <div class="mb-3 form-group">
                                  <label for="">Segunda Respuesta(<span class="text-danger text-md">*</span>)</label>
                                  <input type="text" value="<?php echo $mi_profile['respuesta2_user'];?>" name="respuesta2" id="" class="form-control" placeholder="Escriba su respuesta">
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
            nom_marca:{
                required: true,
                minlength: 3,
            }
        },
        messages:{
            nom_marca:{
                required: "Este Campo no puede estar Vacio",
                minlength: "Debe de Contener al menos 3 caracteres",
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
