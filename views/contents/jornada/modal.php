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
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <input type="hidden" name="id_jornada" v-model="id">
                        <label for="titulo_jornada">Titulo de la jornada(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" v-model="titulo" maxlength="30" name="titulo_jornada" id="titulo_jornada" placeholder="Ingrese el titulo de la jornada" class="form-control">
                      </div>
                    </div>
                    <div class="col-4 col-sm-6">
                      <div class="form-group">
                        <label for="titulo_jornada">Cantidad aproximada de beneficiados(<span class="text-danger text-md">*</span>)</label>
                        <input type="number" v-model="cant" name="cant_aproximada" id="cant_aproximada" placeholder="Ingrese una cantidad aproximadas de platos" class="form-control">
                      </div>
                    </div>
                    <div class="col-4 col-sm-6">
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
                    <div class="col-6 col-sm-6">
                      <div class="form-group">
                        <label for="titulo_jornada">Fecha para la jornada(<span class="text-danger text-md">*</span>)</label>
                        <input type="date" v-model="fecha" min="<?php echo $this->DateNow(); ?>" name="fecha_jornada" id="fecha_jornada" class="form-control">
                      </div>
                    </div>
                    <div class="col-6 col-sm-6">
                      <div class="form-group">
                        <label for="responsable">responsable de esta jornada(<span class="text-danger text-md">*</span>)</label>
                        <select name="responsable" id="responsable" class="custom-select special_select2" v-model="responsable">
                          <option value="">Seleccione a una Persona</option>
                          <?php foreach ($person2 as $persona) { ?>
                            <option value="<?php echo $persona['id_person']; ?>"><?php echo $persona['tipo_person'] . "-" . $persona['cedula_person'] . " " . $persona['nom_person']; ?></option>
                          <?php } ?>
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
                  <input type="hidden" name="ope" value="Actualizar">
                  <button type="button" id="btn" onclick="envio()" class="btn btn-primary"><i class="fas fa-edit"></i> Actualizar</button>
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
  const envio = async () => {
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
  }

  $("#formulario").validate({
    rules: {
      titulo_jornada: {
        required: true,
        minlength: 3,
        maxlength: 20
      },
      cant_aproximada: {
        required: true,
        number: true,
      },
      fecha_jornada: {
        required: true,
      },
      des_jornada: {
        required: true,
        minlength: 3,
        maxlength: 120
      },
      menu_id_jornada: {
        required: true,
      },
      responsable: {
        required: true,
      }
    },
    messages: {
      titulo_jornada: {
        required: "Este Campo NO Puede estar Vacio",
        minlength: "Debe de Contener al menos 3 caracteres",
        maxlength: "Debe de contener menos de 20 caracteres"
      },
      cant_aproximada: {
        required: "Este Campo NO Puede estar Vacio",
        number: "Solo de aceptan numeros"
      },
      fecha_jornada: {
        required: "Este Campo NO Puede estar Vacio",
        min: "Debe de ser superior a la fecha actual"
      },
      des_jornada: {
        required: "Este Campo NO Puede estar Vacio",
        minlength: "Debe de Contener al menos 3 caracteres",
        maxlength: "Debe de contener menos de 120 caracteres"
      },
      menu_id_jornada: {
        required: "Este Campo NO Puede estar Vacio",
      },
      responsable: {
        required: "Este Campo NO Puede estar Vacio",
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