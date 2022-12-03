<div class="modal fade" id="modal-lg_entrada">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Transacción</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Entrada de productos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario_entrada" action="<?php echo constant("URL"); ?>controller/c_entrada_salida.php" name="formulario_entrada" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <input type="hidden" name="fecha_invent" id="" class="form-control" max="<?php echo $this->thisDateMoreOneHour(); ?>" value="<?php echo $this->DateNow("Y-m-d H:i"); ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 col-sm-12">
                      <div class="form-group">
                        <label for="id_invent">Número de Operación</label>
                        <input type="text" name="id_invent" id="id_invent" readonly v-model="next_id_entrada" class="form-control">
                      </div>
                    </div>
                    <div class="col-3 col-sm-6">
                      <div class="form-group">
                        <label for="concept_invent">Concepto de Operación(<span class="text-danger text-md">*</span>)</label>
                        <select name="concept_invent" id="concept_invent" class="custom-select">
                          <option value="">Seleccione un Proveedor</option>
                          <option value="C">Compra</option>
                          <option value="D">Donación</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-3 col-sm-6">
                      <div class="form-group">
                        <label for="comedor_id_invent">Comedor(<span class="text-danger text-md">*</span>)</label>
                        <select name="comedor_id_invent" id="comedor_id_invent" class="custom-select" readonly>
                          <option value="">Seleccione una Opción</option>
                          <?php foreach ($datosComedor as $comedor) { ?>
                            <option value="<?php echo $comedor['id_comedor']; ?>"><?php echo $comedor['nom_comedor']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 col-sm-6">
                      <div class="form-group">
                        <label for="person_id_invent">Selecione el Proveedor(<span class="text-danger text-md">*</span>)</label>
                        <select name="person_id_invent" id="person_id_invent" class="custom-select special_select2">
                          <option value="">Seleccione un Proveedor</option>
                          <?php foreach ($person as $persona) { ?>
                            <option value="<?php echo $persona['id_person']; ?>"><?php echo $persona['tipo_person'] . "-" . $persona['cedula_person'] . " " . $persona['nom_person']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-6 col-sm-6">
                      <div class="form-group">
                        <label for="recibe_person_id_invent">¿Quién Recibe Esto?(<span class="text-danger text-md">*</span>)</label>
                        <select name="recibe_person_id_invent" id="recibe_person_id_invent" class="custom-select special_select2">
                          <option value="">Seleccione a una Persona</option>
                          <?php foreach ($person2 as $persona) { ?>
                            <option value="<?php echo $persona['id_person']; ?>"><?php echo $persona['tipo_person'] . "-" . $persona['cedula_person'] . " " . $persona['nom_person']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row d-flex align-items-center" v-for="(item, index) in productos" :key="index">
                    <div v-if="productos[index].if_entrada == 'SI' " class="col-6">
                      <div class="form-group d-block">
                        <label for="id_product">Datos Generales del Producto(<span class="text-danger text-md">*</span>)</label>
                        <input v-if="productos[index].if_entrada == 'SI' " type="hidden" name="id_product[]" v-model="productos[index].code">
                        <input v-if="productos[index].if_entrada == 'SI' " type="text" readonly name="" v-model="productos[index].nom_product" id="" class="readonly form-control">
                      </div>
                    </div>
                    <div v-if="productos[index].if_entrada == 'SI' " class="col-3">
                      <div class="form-group">
                        <label  for="cant_product">Cantidad(<span class="text-danger text-md">*</span>)</label>
                        <input v-if="productos[index].if_entrada == 'SI' " type="number" name="cantidad_product[]" :data-index="index" v-on:keyup="validarStockMaximo" :min="productos[index].stock_minimo" :max="productos[index].stock_maximo" min="1" v-model="productos[index].nuevo_stock" :value="productos[index].cantidad" id="cant_product" placeholder="Ingrese la Cantidad" class="form-control" onchange="this.value = parseInt(this.value);">
                      </div>
                    </div>
                    <!-- <button type="button" v-on:click="Disminuir(index)" class="btn btn-danger mt-3">-</button> -->
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="hidden" name="ope" value="Entrada_A">
                  <button type="button" id="btn" onclick="envio_entrada()" class="btn btn-primary"><i class="fas fa-edit"></i> Registrar entrada</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
<script>
  const envio_entrada = async () => {

    if ($("#formulario_entrada").valid()) {
      let res = await Confirmar();
      if (!res) return false;

      let datos = new FormData(document.formulario_entrada);
      fetch(`<?php echo constant("URL"); ?>controller/c_entrada_salida.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          // FreshCatalogo();
          // document.formulario.reset();
          $("#modal-lg_entrada").modal("hide");
          app.consultar_jornada();
          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  }

  $("#formulario_entrada").validate({
    rules: {
      comedor_id_invent: {
        required: true,
      },
      person_id_invent: {
        required: true,
      },
      concept_invent: {
        required: true,
      },
    },
    messages: {
      comedor_id_invent: {
        required: "Debe Seleccionar un Comedor",
      },
      person_id_invent: {
        required: "Debe seleccionar un Proveedor",
      },
      recibe_person_id_invent: {
        required: "Debe Seleccionar quién recibe los Productos",
      },
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