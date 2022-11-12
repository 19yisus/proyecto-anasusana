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
                <h3 class="card-title">Formulario de Modificación de comidas</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario" action="<?php echo constant("URL"); ?>controller/c_platillos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-5 col-sm-12">
                      <div class="form-group">
                        <label for="id_plat">Código del platillo(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" name="id_plat" v-model="id" id="id_plat" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-7 col-sm-12">
                      <div class="form-group">
                        <label for="des_plat">Descripción del platillos(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" name="des_plat" v-model="des" id="des_plat" placeholder="Ingrese la descripción del platillo" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row" v-for="(itemx, indice) in productos" :key="itemx.id">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Producto {{indice}}</label>
                        <select :data-index="indice" id="comida" name="comidas[]" class="custom-select" v-model="productos[indice].id" @change="cambio">
                          <option value="">Seleccione una opción</option>
                          <option v-for="item in selectProductos" :key="item.id_product" :data-medida="item.med_product" :id="item.med_product" :value="item.id_product">{{item.nom_product}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-5">
                      <div class="form-group">
                        <label for="">Cantidad</label>
                        <div class="input-group">
                          <input type="number" step="00.01" class="form-control" name="consumo[]" v-model="productos[indice].cantidad" id="" placeholder="Cantidad">
                          <div class="input-group-append">
                            <span class="input-group-text">{{itemx.medida}}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <input type="hidden" name="ope" value="Actualizar">
                    <button type="button" id="btn" onclick="envio()" value="Actualizar" class="btn btn-primary"><i class="fas fa-edit"></i> Actualizar</button>
                    <button class="btn btn-success" @click="duplicar" type="button">Añadir Comida <i class="fas fa-plus-square"></i></button>
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
    console.log("DSDSD");
    if ($("#formulario").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario);
      fetch(`<?php echo constant("URL"); ?>controller/c_platillos.php`, {
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
      des_plat: {
        required: true,
        minlength: 3,
        maxlength: 20,
      },
    },
    messages: {
      des_plat: {
        required: "Este Campo NO Puede estar Vacio",
        minlength: "Debe de Contener al Menos 3 caracteres",
        maxlength: "Debe de contener menos de 20 caracteres"
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