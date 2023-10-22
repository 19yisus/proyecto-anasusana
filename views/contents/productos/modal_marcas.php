<div class="modal fade" id="modal-lg-marca">
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
                <h3 class="card-title">Formulario de Marcas</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario_marcas" action="<?php echo constant("URL"); ?>controller/c_marca.php" name="formulario_marcas" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <label for="nom_marca">Nombre de la Marca(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" name="nom_marca" id="nom_marca" placeholder="Ingrese el nombre de la marca" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="ope">
                  <button type="button" id="btn_marca" onclick="ope.value = this.value" value="Registrar_async" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
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
  $("#btn_marca").click(async () => {
    if ($("#formulario_marcas").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario_marcas);
      fetch(`<?php echo constant("URL"); ?>controller/c_marca.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          consultarMarcasToSelect()

          document.formulario_marcas.reset();
          $("#modal-lg-marca").modal("hide");

          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  })

  $("#formulario_marcas").validate({
    rules: {
      nom_marca: {
        required: true,
        minlength: 3,
      }
    },
    messages: {
      nom_marca: {
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