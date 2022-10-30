<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader();
require("./models/m_productos.php");
$model = new m_productos();
$productos = $model->Get_todos_productos(1);
?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper" id="VueApp">
    <?php
    $this->titleContent = "Registro de Platillos";

    $this->GetComplement("navbar");
    // $this->GetComplement("sidebar");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php $this->GetComplement("contentHeader"); ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Formulario de Registro de Comidas</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formulario" action="<?php echo constant("URL"); ?>controller/c_platillos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-5">
                        <div class="form-group">
                          <input type="hidden" name="id_plat">
                          <label for="des_cargo">Nombre del Platillo(<span class="text-danger text-md">*</span>)</label>
                          <input type="text" name="des_plat" id="des_plat" placeholder="Ingrese la descripción del cargo" class="form-control">
                        </div>
                      </div>

                      <div class="col-4">
                        <label for="">Estado del Platillo(<span class="text-danger text-md">*</span>)</label>
                        <div class="row">
                          <div class="form-check mx-3">
                            <input type="radio" name="estatus_plat" id="estatus_plat" value="1" class="form-check-input" readonly checked>
                            <label for="estatus_plat" class="form-check-label">Activo</label>
                          </div>
                          <div class="form-check">
                            <input type="radio" name="estatus_plat" id="estatus_plat" value="0" class="form-check-input" disabled>
                            <label for="estatus_plat" class="form-check-label">Inactivo</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-for="(itemx, indice) in productos" :key="itemx.id">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Producto {{(indice+1)}}</label>
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
                            <input type="number" step="00.01" min="00.01" class="form-control" name="consumo[]" v-model="productos[indice].cantidad" id="" placeholder="Cantidad">
                            <div class="input-group-append">
                              <span class="input-group-text">{{itemx.medida}}</span>
                            </div>
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
                      <button class="btn btn-success" @click="duplicar" type="button">Añadir Comida <i class="fas fa-plus-square"></i></button>
                      <button class="btn btn-danger" v-if="productos.length > 1" @click="disminuir" type="button">Eliminar Comida -</i></button>
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
  <?php $this->GetComplement("scripts"); ?>
  <script>
    new Vue({
      el: "#VueApp",
      data: {
        productos: [{
          id: '',
          medida: '',
          cantidad: ''
        }],
        selectProductos: [{}]
      },
      methods: {
        async GetAlimentos() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Get_alimentos`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.selectProductos = data;
            }).catch(error => console.error(error));
        },
        cambio(e) {
          let contador = 0;
          this.productos.forEach(item => {
            if (item.id == e.target.value) contador += 1
          })
          if (contador > 1) {
            $(`#${e.target.id} option[value='']`).attr('selected', true);
            alert("No se pueden duplicar los alimentos")
            return false;
          }
          let {
            med_product
          } = this.selectProductos.filter(item => item.id_product == e.target.value)[0];
          this.productos = this.productos.map(item => {
            if (item.id == e.target.value) item.medida = med_product;
            return item;
          })
        },
        duplicar() {
          this.productos.push({
            id: '',
            medida: '',
            cantidad: ''
          })
        },
        disminuir() {
          this.productos.pop();
        }
      },
      async mounted() {
        await this.GetAlimentos();
      }
    })
    
    $("#btn").click(async () => {
      if ($("#formulario").valid()) {
        let res = await Confirmar();
        if (res) $("#formulario").submit();
      }
    })

    $("#formulario").validate({
      rules: {
        des_plat: {
          required: true,
          minlength: 3,
          maxlength: 20
        }
      },
      messages: {
        des_plat: {
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

</html>