<div class="modal fade" id="modal-lg-cargo">
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
                <h3 class="card-title">Formulario de Cargos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario_cargos" action="<?php echo constant("URL"); ?>controller/c_cargo.php" name="formulario_cargos" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <label for="des_cargo">Nombre del Cargo(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" name="des_cargo" id="des_cargo" placeholder="Ingrese el nombre del marca" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="ope">
                  <button type="button" id="btn_cargo" onclick="ope.value = this.value" value="Registrar_async" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
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
  $("#btn_cargo").click(async () => {
    if ($("#formulario_cargos").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario_cargos);
      fetch(`<?php echo constant("URL"); ?>controller/c_cargo.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          consultarCargosToSelect()

          document.formulario_cargos.reset();
          $("#modal-lg-cargo").modal("hide");

          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  })

  $("#formulario_cargos").validate({
    rules: {
      des_cargo: {
        required: true,
        minlength: 3,
      }
    },
    messages: {
      des_cargo: {
        required: "Este Campo NO puede estar Vacio",
        minlength: "Debe de Contener al menos 3 caracteres",
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