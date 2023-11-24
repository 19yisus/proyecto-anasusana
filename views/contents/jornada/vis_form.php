<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader();
require("./models/m_productos.php");
require_once("./models/m_persona.php");

$model = new m_productos();
$productos = $model->Get_todos_productos(1);

$model_person = new m_persona();
$person2 = $model_person->Get_Personas();
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
                          <label for="titulo_jornada">Titulo de la Jornada(<span class="text-danger text-md">*</span>)</label>
                          <input type="text" maxlength="30" name="titulo_jornada" id="titulo_jornada" placeholder="Ingrese el titulo de la jornada" class="form-control">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="titulo_jornada">Cantidad Aproximada de Beneficiados(<span class="text-danger text-md">*</span>)</label>
                          <input type="number" name="cant_aproximada" v-model="cant_aproximada" :min="porciones" id="cant_aproximada" placeholder="Ingrese una cantidad aproximadas de beneficiados" class="form-control">
                        </div>
                      </div>
                      <div class="col-3">
                        <label for="">Estado de la Jornada(<span class="text-danger text-md">*</span>)</label>
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
                      <div class="col-3">
                        <div class="form-group">
                          <label for="titulo_jornada">Fecha para la Jornada(<span class="text-danger text-md">*</span>)</label>
                          <input type="date" min="<?php echo $this->DateNow(); ?>" name="fecha_jornada" id="fecha_jornada" class="form-control">
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-group">
                          <label for="">Menú(<span class="text-danger text-md">*</span>)</label>
                          <select name="menu_id_jornada" id="" class="custom-select" v-model="menu_id_jornada" v-on:change="consultar_menu">
                            <option value="">Seleccione una Opción</option>
                            <option v-for="item in selectMenu" :key="item.id_menu" :value="item.id_menu">{{item.des_menu}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="form-group">
                          <label for="responsable">Responsable de Esta Jornada(<span class="text-danger text-md">*</span>)</label>
                          <select name="responsable" id="responsable" class="custom-select special_select2">
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
                          <label for="">Descripción de la Jornada(<span class="text-danger text-md">*</span>)</label>
                          <textarea name="des_jornada" maxlength="120" class="form-control" id="des_jornada" cols="30" rows="2"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row" v-show="menu_id_jornada != ''">
                      <div class="col-12">
                        <div class="card card-success">
                          <div class="card-header">
                            <h4 class="card-title">
                              Información del Menú |
                              Descripción "{{titulo_menu}}"</h4>
                          </div>
                          <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Ingredientes</th>
                                  <th>Consumo</th>
                                  <th>Aproximado a gastar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(item, index) in ingrediente" :key="index">
                                  <td>{{ item.nom_product }}</td>
                                  <td>{{ item.consumo }} {{ item.med_comida_detalle }}</td>
                                  <td>{{ calculo(item.consumo, item.med_comida_detalle) }}</td>
                                </tr>
                              </tbody>
                            </table>
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
        cant_aproximada: 0,
        ingrediente: [],
        menu_id_jornada: '',
        titulo_menu: '',
        porciones: 0,
        selectMenu: [{}]
      },
      methods: {
        calculo(consumo, medida) {
          // let cantidad = parseInt(this.cant_aproximada) / parseInt(this.porciones);

          if (this.cant_aproximada != 0) {
            let simplificado, med;
            let total = parseInt(consumo) * parseInt(this.cant_aproximada);
            if (total > 999 && medida == "GM" || total > 999 && medida == "ML") {
              simplificado = total / 1000;
              if (medida == "GM") med = "KL";
              if (medida == "KL") med = "KL";
              if (medida == "LT") med = "LT";
              if (medida == "ML") med = "LT";              
              return `${total} ${medida} Ó ${simplificado} ${med}`;
            }
            return `${total} ${medida}`;
            // let total = parseInt(consumo) * parseInt(this.cant_aproximada);
          }
          return '';
        },
        async GetMenu() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Todos_menu`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.selectMenu = data;
            }).catch(error => console.error(error));
        },
        async consultar_menu() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Consultar_menu&id_menu=${this.menu_id_jornada}`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.titulo_menu = data[0].des_menu;
              this.ingrediente = data[1];
              console.log(data)
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
        titulo_jornada: {
          required: true,
          minlength: 3,
          maxlength: 30
        },
        cant_aproximada: {
          required: true,
          number: true,
          min:1,
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
          number: "Solo de aceptan numeros",
          min: "Debe de ingresar al menos un beneficiado",
        },
        fecha_jornada: {
          required: "Este Campo NO Puede estar Vacio",
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

</html>