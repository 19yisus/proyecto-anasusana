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
    $this->titleContent = "Registro de Jornadas";

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
                  <h3 class="card-title">Formulario de Registro de Jornadas</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formulario" action="<?php echo constant("URL"); ?>controller/c_jornada.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-5">
                        <div class="form-group">
                          <input type="hidden" name="id_jornada">
                          <label for="titulo_jornada">Titulo de la jornada(<span class="text-danger text-md">*</span>)</label>
                          <input type="text" maxlength="30" name="titulo_jornada" id="titulo_jornada" placeholder="Ingrese el titulo de la jornada" class="form-control">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="titulo_jornada">Cantidad aproximada de platos(<span class="text-danger text-md">*</span>)</label>
                          <input type="number" name="cant_aproximada" id="cant_aproximada" placeholder="Ingrese una cantidad aproximadas de platos" class="form-control">
                        </div>
                      </div>
                      <div class="col-3">
                        <label for="">Estado de la jornada(<span class="text-danger text-md">*</span>)</label>
                        <div class="row">
                          <div class="form-check mx-3">
                            <input type="radio" name="estatus_jornada" id="estatus_jornada" value="1" class="form-check-input" readonly checked>
                            <label for="estatus_jornada" class="form-check-label">Activo</label>
                          </div>
                          <div class="form-check">
                            <input type="radio" name="estatus_jornada" id="estatus_jornada" value="0" class="form-check-input" disabled>
                            <label for="estatus_jornada" class="form-check-label">Inactivo</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="titulo_jornada">Fecha para la jornada(<span class="text-danger text-md">*</span>)</label>
                          <input type="date" name="fecha_jornada" id="fecha_jornada" class="form-control">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Menú(<span class="text-danger text-md">*</span>)</label>
                          <select name="menu_id_jornada" id="" class="custom-select" v-model="menu_id_jornada">
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
                          <textarea name="des_jornada" maxlength="120" class="form-control" id="des_jornada" cols="30" rows="2"></textarea>
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
  <?php $this->GetComplement("scripts"); ?>
  <script>
    new Vue({
      el: "#VueApp",
      data: {
        productos: [{
          id: '',
          medida: '',
          cantidad: '',
        }],
        menu_id_jornada: '',
        selectMenu: [{}]
      },
      methods: {
        async GetMenu() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Todos_menu`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.selectMenu = data;
            }).catch(error => console.error(error));
        },
      },
      async mounted() {
        await this.GetMenu();
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
        des_menu: {
          required: true,
          minlength: 3,
          maxlength: 20
        },
        des_procedimiento: {
          required: true,
          minlength: 1,
          maxlength: 120
        }
      },
      messages: {
        des_menu: {
          required: "Este Campo NO Puede estar Vacio",
          minlength: "Debe de Contener al menos 3 caracteres",
          maxlength: "Debe de contener menos de 20 caracteres"
        },
        des_procedimiento: {
          required: "Este Campo NO Puede estar Vacio",
          minlength: "Debe de Contener al menos 1 caracteres",
          maxlength: "Debe de contener menos de 120 caracteres"
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