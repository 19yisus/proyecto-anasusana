<!-- <?php
      // require_once("./models/m_persona.php");
      // $model_person = new m_persona();
      // $person = $model_person->Get_Personas();
      ?> -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
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
                <h3 class="card-title">Formulario de Modificación de Jornada</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario" action="<?php echo constant("URL"); ?>controller/c_jornada.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-5 col-sm-12">
                      <div class="form-group">
                        <input type="hidden" name="id_jornada">
                        <label for="titulo_jornada">Titulo de la jornada(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" v-model="titulo" maxlength="30" name="titulo_jornada" id="titulo_jornada" placeholder="Ingrese el titulo de la jornada" class="form-control">
                      </div>
                    </div>
                    <div class="col-4 col-sm-12">
                      <div class="form-group">
                        <label for="titulo_jornada">Cantidad aproximada de platos(<span class="text-danger text-md">*</span>)</label>
                        <input type="number" v-model="cant" name="cant_aproximada" id="cant_aproximada" placeholder="Ingrese una cantidad aproximadas de platos" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 col-sm-6">
                      <div class="form-group">
                        <label for="titulo_jornada">Fecha para la jornada(<span class="text-danger text-md">*</span>)</label>
                        <input type="date" v-model="fecha" name="fecha_jornada" id="fecha_jornada" class="form-control">
                      </div>
                    </div>
                    <div class="col-6 col-sm-6">
                      <div class="form-group col-sm-12">
                        <label for="">Menú(<span class="text-danger text-md">*</span>)</label>
                        <select name="menu_id_jornada" id="menu_id_jornada" class="custom-select" v-model="menu_id_jornada">
                          <option value="">Seleccione una opción</option>
                          <option v-for="item in selectMenu" :key="item.id_menu" :value="item.id_menu">{{item.des_menu}}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="">Descripción de la jornada</label>
                        <textarea name="des_jornada" v-model="des" maxlength="120" class="form-control" id="des_jornada" cols="30" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="ope">
                  <button type="button" id="btn" onclick="ope.value = this.value" value="Actualizar" class="btn btn-primary"><i class="fas fa-edit"></i> Actualizar</button>
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
  $("#btn").click(async () => {
    if ($("#formulario").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario);
      fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          FreshCatalogo();
          document.formulario.reset();
          $("#modal-lg").modal("hide");

          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  })

  $("#formulario").validate({
    rules: {
      nom_comedor: {
        required: true,
        minlength: 3,
      },
      encargado_comedor: {
        required: true,
      },
      direccion_comedor: {
        required: true,
        minlength: 5,
        maxlength: 120,
      }
    },
    messages: {
      nom_comedor: {
        required: "Este Campo NO Puede estar Vacio",
        minlength: "Debe de Contener al Menos 3 caracteres",
      },
      encargado_comedor: {
        required: "Debes de Seleccionar al Encargado del Comedor",
      },
      direccion_comedor: {
        required: "La Dirección del Comedor es Requerida",
        minlength: "Mínimo de 5 Letras",
        maxlength: "Máximo de 120 Letras",
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