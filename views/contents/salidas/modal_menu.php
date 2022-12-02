<div class="modal fade" id="modal-lg_menu">
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
                <h3 class="card-title">Formulario de Modificación de menú</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="formulario_menu" action="<?php echo constant("URL"); ?>controller/c_menu.php" name="formulario_menu" method="POST" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-4 col-sm-12">
                      <div class="form-group">
                        <label for="des_cargo">Nombre del menú(<span class="text-danger text-md">*</span>)</label>
                        <input type="text" readonly name="des_menu" id="des_menu" v-model="des_menu" placeholder="Ingrese la descripción del menú" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row" v-for="(itemx, indice) in productos_menu" :key="itemx.id">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Ingrediente {{(indice+1)}}</label>
                        <select :data-index="indice" id="comida" name="comidas[]" class="custom-select" v-model="productos_menu[indice].id" @change="cambio_menu_modal">
                          <option value="">Seleccione una opción</option>
                          <option v-for="item in selectProductos" :key="item.id_product" :data-medida="item.med_product" :id="item.med_product" :value="item.id_product">{{item.nom_product}}</option>
                        </select>
                        <!-- <input type="text" name="des_comida_detalle[]" id="" class="form-control" v-model="productos[indice].des"> -->
                      </div>
                    </div>
                    <div class="col-5">
                      <div class="form-group">
                        <label for="">Cantidad</label>
                        <div class="input-group">
                          <input type="number" step="1" min="1" class="form-control" name="consumo[]" v-model="productos_menu[indice].cantidad" id="" placeholder="Cantidad">
                          <div class="input-group-append">
                            <select name="med_comida_detalle[]" id="med_comida_detalle" class="input-group-text custom-select" v-model="productos_menu[indice].medida">
                              <option value="">Medidas</option>
                              <option value="KL">KL</option>
                              <option value="LT">LT</option>
                              <option value="GM">GM</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <input type="hidden" name="id_menu" v-model="id_menu" id="id_menu" class="form-control" readonly>
                    <input type="hidden" name="ope" value="Actualizar_cantidad">
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
    if ($("#formulario_menu").valid()) {
      let condicion = true;
      app.productos_menu.forEach(item =>{
        if(item.id == "") condicion = false;
        if(item.cantidad == "") condicion = false;
        if(item.medida == "") condicion = false;
      })

      if(!condicion){
        app.Fn_mensaje_error("Debes de llenar los campos")
        return false;
      }

      let res = await Confirmar();
      if (!res) return false;

      

      let datos = new FormData(document.formulario_menu);
      fetch(`<?php echo constant("URL"); ?>controller/c_menu.php`, {
          method: "POST",
          body: datos,
        }).then(response => response.json())
        .then(res => {
          // FreshCatalogo();
          // document.formulario_menu.reset();
          app.consultar_jornada();
          $("#modal-lg_menu").modal("hide");

          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
        }).catch(Err => console.log(Err))
    }
  }

  $("#formulario").validate({
    rules: {
      des_menu: {
        required: true,
        minlength: 3,
        maxlength: 20
      },
      comidas:{
        required: true,
      },
      consumo:{
        required: true
      }
    },
    messages: {
      des_menu: {
        required: "Este Campo NO Puede estar Vacio",
        minlength: "Debe de Contener al menos 3 caracteres",
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