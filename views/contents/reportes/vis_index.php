<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper" id="VueApp">
    <?php
    $this->titleContent = "Consulta y Reportes";

    $this->GetComplement("navbar");
    require_once("./models/m_marca.php");

    $model_marca = new m_marca();
    $marcas = $model_marca->Get_todos_marcas(1);
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
                  <h3 class="card-title">Reportes de módulos</h3>
                </div>
                <form action="<?php echo constant("URL"); ?>controller/c_pdf.php" method="POST" target="<?php echo constant("URL"); ?>controller/c_pdf.php" class="">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-4">
                        <label for="">Tipo de reporte(<span class="text-danger text-md">*</span>)</label>
                        <div class="row">
                          <div class="form-check mx-3">
                            <input type="radio" v-model="tipo_reporte" name="tipo_reporte" id="tipo_reporte" value="Productos" class="form-check-input">
                            <label for="tipo_reporte" class="form-check-label">Productos</label>
                          </div>
                          <div class="form-check mx-3">
                            <input type="radio" v-model="tipo_reporte" name="tipo_reporte" id="tipo_reporte" value="Menu" class="form-check-input">
                            <label for="tipo_reporte" class="form-check-label">Menú</label>
                          </div>
                          <div class="form-check mx-3">
                            <input type="radio" v-model="tipo_reporte" name="tipo_reporte" id="tipo_reporte" value="Jornada" class="form-check-input">
                            <label for="tipo_reporte" class="form-check-label">Jornadas</label>
                          </div>
                          <div class="form-check mx-3">
                            <input type="radio" v-model="tipo_reporte" name="tipo_reporte" id="tipo_reporte" value="Entrada" class="form-check-input">
                            <label for="tipo_reporte" class="form-check-label">Entrada</label>
                          </div>
                          <div class="form-check">
                            <input type="radio" v-model="tipo_reporte" name="tipo_reporte" id="tipo_reporte" value="Salida" class="form-check-input">
                            <label for="tipo_reporte" class="form-check-label">Salida</label>
                          </div>
                        </div>
                      </div>
                      <!-- FILTROS PARA ENTRADAS -->
                      <div class="col-4" v-show="tipo_reporte == 'Entrada' || tipo_reporte == 'Salida'">
                        <div class="form-group">
                          <label for="">Filtro(<span class="text-danger text-md">*</span>)</label>
                          <div class="row">
                            <!-- FILTROS ESPECIFICOS PARA ENTRADAS -->
                            <div v-show="tipo_reporte == 'Entrada'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Compra" class="form-check-input" v-bind:checked="filtro == 'Compra'" v-bind:disabled="tipo_reporte != 'Entrada'" required>
                              <label for="filtro" class="form-check-label">Entrada por compra</label>
                            </div>
                            <div v-show="tipo_reporte == 'Entrada'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Donacion" class="form-check-input" v-bind:checked="filtro == 'Donacion'" v-bind:disabled="tipo_reporte != 'Entrada'" required>
                              <label for="filtro" class="form-check-label">Entrada por donación</label>
                            </div>
                            <div v-show="tipo_reporte == 'Entrada'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Todas_entradas" class="form-check-input" v-bind:checked="filtro == 'Todos_entrada'" v-bind:disabled="tipo_reporte != 'Entrada'" required>
                              <label for="filtro" class="form-check-label">Todas las entradas</label>
                            </div>
                            <!-- FILTROS ESPECIFICOS PARA SALIDAS -->
                            <div v-show="tipo_reporte == 'Salida'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Consumo" class="form-check-input" v-bind:checked="filtro == 'Consumo'" v-bind:disabled="tipo_reporte != 'Salida'" required>
                              <label for="filtro" class="form-check-label">Salidas por consumo</label>
                            </div>
                            <div v-show="tipo_reporte == 'Salida'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Vencimiento" class="form-check-input" v-bind:checked="filtro == 'Vencimiento'" v-bind:disabled="tipo_reporte != 'Salida'" required>
                              <label for="filtro" class="form-check-label">Salidas por vencimiento</label>
                            </div>
                            <div v-show="tipo_reporte == 'Salida'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Rechazo" class="form-check-input" v-bind:checked="filtro == 'Rechazo'" v-bind:disabled="tipo_reporte != 'Salida'" required>
                              <label for="filtro" class="form-check-label">Salidas por remanente</label>
                            </div>
                            <div v-show="tipo_reporte == 'Salida'" class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Todas_salidas" class="form-check-input" v-bind:checked="filtro == 'Todas_salidas'" v-bind:disabled="tipo_reporte != 'Salida'" required>
                              <label for="filtro" class="form-check-label">Todas las salidas</label>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="col-4" v-show="tipo_reporte == 'Menu' || tipo_reporte == 'Jornada' || tipo_reporte == 'Entrada' || tipo_reporte == 'Salida'">
                        <div class="form-group">
                          <label for="">Filtro de fechas(<span class="text-danger text-md">*</span>)</label>
                          <div class="row">
                            <!-- FILTROS PARA ENTRADA, SALIDA, JORNADA Y MENU -->
                            <div v-show="tipo_reporte == 'Menu' || tipo_reporte == 'Jornada' || tipo_reporte == 'Entrada' || tipo_reporte == 'Salida'" class="form-check mx-3">
                              <input type="radio" v-model="filtro_extra" name="filtro_extra" required id="filtro_extra" v-bind:checked="filtro_extra == 'Fecha_registro'" value="Fecha_registro" class="form-check-input" v-bind:disabled="tipo_reporte != 'Menu' && tipo_reporte != 'Jornada' && tipo_reporte != 'Entrada' && tipo_reporte != 'Salida'" required>
                              <label for="filtro" class="form-check-label">Por fecha de registro</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- FILTROS PARA SALIDAS -->
                      <!-- FILTROS PARA PRODUCTOS -->
                      <div class="col-4" v-show="tipo_reporte == 'Productos'">
                        <div class="form-group">
                          <label for="">Filtro(<span class="text-danger text-md">*</span>)</label>
                          <div class="row">
                            <div class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Todos" class="form-check-input" v-bind:disabled="tipo_reporte != 'Productos'" v-bind:checked="filtro == 'Todos'" required>
                              <label for="filtro" class="form-check-label">Todos</label>
                            </div>
                            <div class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Marcas" class="form-check-input" v-bind:disabled="tipo_reporte != 'Productos'" v-bind:checked="filtro == 'Marcas'" required>
                              <label for="filtro" class="form-check-label">Por Marca</label>
                            </div>
                            <div class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Unidades" class="form-check-input" v-bind:disabled="tipo_reporte != 'Productos'" v-bind:checked="filtro == 'Unidades'" required>
                              <label for="filtro" class="form-check-label">Por Unidad de Medida</label>
                            </div>
                            <div class="form-check mx-3">
                              <input type="radio" v-model="filtro" name="filtro" id="filtro" value="Stock_max" class="form-check-input" v-bind:disabled="tipo_reporte != 'Productos'" v-bind:checked="filtro == 'Stock_max'" required>
                              <label for="filtro" class="form-check-label">Por Stock maximo</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- FILTROS DE UNIDADES PARA PRODUCTOS -->
                      <div class="col-3" v-show="filtro == 'Unidades' && tipo_reporte == 'Productos'">
                        <div class="form-group">
                          <label for="">Unidad de Medida(<span class="text-danger text-md">*</span>)</label>
                          <select name="id" id="med_producto_select" class="custom-select" v-bind:disabled="filtro != 'Unidades' || tipo_reporte != 'Productos'" required>
                            <option value="">Seleccione una Medida</option>
                            <option value="KL">Kilo gramos (KL)</option>
                            <option value="LT">Litros (L)</option>
                            <option value="GM">Gramos (G)</option>
                          </select>
                        </div>
                      </div>
                      <!-- FILTROS DE FECHAS -->
                      <div class="col-4" v-show="filtro_extra != '' && tipo_reporte == 'Menu' || filtro_extra != '' && tipo_reporte == 'Jornada' || filtro_extra != '' && tipo_reporte == 'Entrada' || filtro_extra != '' && tipo_reporte == 'Salida' ">
                        <div class="form-group">
                          <label for="">Fechas(<span class="text-danger text-md">*</span>)</label>
                          <div class="input-group">
                            <input type="date" max="<?php echo $this->DateNow(); ?>" required name="desde" aria-label="desde" id="" class="form-control" v-bind:disabled="valid">

                            <input type="date" max="<?php echo $this->DateNow(); ?>" required name="hasta" aria-label="hasta" id="" class="form-control" v-bind:disabled="valid">
                          </div>
                        </div>
                      </div>
                      <!-- FILTROS DE MARCAS PARA PRODUCTOS -->
                      <div class="col-3" v-show="filtro == 'Marcas' && tipo_reporte == 'Productos'">
                        <div class="form-group">
                          <label for="">Marcas(<span class="text-danger text-md">*</span>)</label>
                          <select name="id" id="mar_producto_select" class="custom-select" v-bind:disabled="filtro != 'Marcas' || tipo_reporte != 'Productos'" required>
                            <option value="">Seleccione una Marca</option>
                            <?php
                            foreach ($marcas as $marca) { ?>
                              <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nom_marca']; ?></option><?php
                                                                                                                          } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <input type="hidden" name="ope" v-model="tipo_reporte">
                    <button type="submit" id="btn" class="btn btn-primary">
                      <i class="fas fa-save"></i>
                      Enviar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->GetComplement("footer"); ?>
  </div>
  <!-- ./wrapper -->
  <?php
  $this->GetComplement("scripts");
  ?>
  <script>
    const PDF = (id) => {
      const form = document.getElementById(`formSecondary-${id}`);
      form.ope.value = "pdf_entrada";
      $(form).attr('action', '<?php echo constant("URL"); ?>controller/c_pdf.php');
      form.submit();
    }

    new Vue({
      el: "#VueApp",
      data: {
        tipo_reporte: "",
        filtro: "",
        filtro_extra: ""
      },
      computed: {
        valid() {
          if (this.filtro_extra == '' || this.tipo_reporte != 'Menu' && this.tipo_reporte != 'Jornada' && this.tipo_reporte != 'Entrada' && this.tipo_reporte != 'Salida') {
            return true
          } else return false;
        }
      },
      watch: {
        tipo_reporte() {
          this.filtro = "";
          this.filtro_extra = "";
        },
      }
    })
  </script>
</body>

</html>