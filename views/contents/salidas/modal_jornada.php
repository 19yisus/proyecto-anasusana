<div class="modal fade" id="modal-lg_jornada">
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
              <form id="formulario_jornada" action="<?php echo constant("URL"); ?>controller/c_jornada.php" name="formulario_jornada" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <input type="hidden" name="id_jornada" v-model="jornada_id">
                        <label for="titulo_jornada">Titulo de la jornada(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" readonly v-model="jornada_titulo" maxlength="30" name="titulo_jornada" id="titulo_jornada" placeholder="Ingrese el titulo de la jornada" class="form-control">
                      </div>
                    </div>
                    <div class="col-4 col-sm-6">
                      <div class="form-group">
                        <label for="titulo_jornada">Cantidad aproximada de beneficiados(<span class="text-danger text-md">*</span>)</label>
                        <input type="number" v-model="jornada_cant" name="cant_aproximada" id="cant_aproximada" placeholder="Ingrese una cantidad aproximadas de platos" class="form-control">
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
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="ope" value="Actualizar_cantidades">
                  <button type="button" id="btn" onclick="envio_jornada()" class="btn btn-primary"><i class="fas fa-edit"></i> Actualizar</button>
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
  const envio_jornada = async () => {
    
    if ($("#formulario_jornada").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario_jornada);
      fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          // FreshCatalogo();
          // document.formulario.reset();
          $("#modal-lg_jornada").modal("hide");
          app.consultar_jornada();
          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  }

  $("#formulario_jornada").validate({
    rules: {
      cant_aproximada: {
        required: true,
        number: true,
      },
      menu_id_jornada: {
        required: true,
      }
    },
    messages: {
      cant_aproximada: {
        required: "Este Campo NO Puede estar Vacio",
        number: "Solo de aceptan numeros"
      },
      menu_id_jornada: {
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