<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper">
    <?php
    $this->titleContent = "Catálogo de Salida de Productos";

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
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Catálogo de Salida de Productos / Alimentos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Numero de Orden</th>
                        <th>Cantidad de Productos</th>
                        <th>Estado</th>
                        <th>Creación</th>
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Reportes de salidas</h3>
                </div>
                <form action="<?php echo constant("URL"); ?>controller/c_pdf.php" method="POST" target="<?php echo constant("URL"); ?>controller/c_pdf.php" class="">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-3">
                        <label for="">Tipo de reporte(<span class="text-danger text-md">*</span>)</label>
                        <div class="row">
                          <div class="form-check mx-3">
                            <input type="radio" name="tipo_reporte" id="tipo_reporte" value="E" class="form-check-input" disabled>
                            <label for="tipo_reporte" class="form-check-label">Entrada</label>
                          </div>
                          <div class="form-check">
                            <input type="radio" name="tipo_reporte" id="tipo_reporte" value="S" class="form-check-input" readonly checked>
                            <label for="tipo_reporte" class="form-check-label">Salida</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Filtro(<span class="text-danger text-md">*</span>)</label>
                          <div class="row">
                            <div class="form-check mx-3">
                              <input type="radio" name="filtro" id="filtro" value="O" class="form-check-input">
                              <label for="filtro" class="form-check-label">Salidas por consumo</label>
                            </div>
                            <div class="form-check mx-3">
                              <input type="radio" name="filtro" id="filtro" value="V" class="form-check-input">
                              <label for="filtro" class="form-check-label">Salidas por vencimiento</label>
                            </div>
                            <div class="form-check mx-3">
                              <input type="radio" name="filtro" id="filtro" value="R" class="form-check-input">
                              <label for="filtro" class="form-check-label">Salidas por rechazo</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-3">
                        <input type="hidden" name="ope" value="ReporteFiltrado">
                        <button type="submit" id="btn" class="btn btn-primary">
                          <i class="fas fa-save"></i>
                          Enviar
                        </button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
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
  $this->GetComplement("modal_vista");
  ?>
  <script>
    const PDF = (id) => {
      const form = document.getElementById(`formSecondary-${id}`);
      form.ope.value = "pdf_salida";
      $(form).attr('action', '<?php echo constant("URL"); ?>controller/c_pdf.php');
      form.submit();
    }

    const ListarDatos = async (id) => {
      await fetch(`<?php echo constant("URL"); ?>controller/c_entrada_salida.php?ope=Consultar_invent&id_invent=${id}`)
        .then(response => response.text()).then(data => {
          $("#body_html").html(data);
        }).catch(Error => console.error(Error))
    }

    $(() => {
      $('#dataTable').DataTable({
        ajax: {
          url: "<?php echo constant("URL"); ?>controller/c_entrada_salida.php?ope=Todos_salidas",
          dataSrc: "data",
        },
        columns: [{
            data: "id_invent"
          },
          {
            data: "orden_invent",
            render(data){
              if(data) return data; else return "No-tiene"
            }
          },
          {
            data: "cantidad_invent"
          },
          {
            data: "status_invent",
            render: function(data) {
              return (data == 1) ? "Activo" : "Inactivo";
            }
          },
          {
            data: "created_invent",
            render: function(data) {
              return moment(data).format("DD/MM/YYYY h:mm A")
            }
          },
          {
            defaultContent: "",
            render: function(data, type, row, meta) {

              let btn = `
            <form method="POST" id="formSecondary-${row.id_invent}" target="<?php echo constant("URL"); ?>controller/c_pdf.php" action="<?php echo constant('URL'); ?>controller/c_entrada_salida.php">
              <input type="hidden" name="id_invent" value="${row.id_invent}">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button title="Imprimr pdf" type="button" class="btn btn-sm btn-danger" onclick="PDF('${row.id_invent}')"><i class="fas fa-file-pdf"></i></button>
              <button title="Listar datos" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg-vista" onclick="ListarDatos('${row.id_invent}')"><i class="fas fa-list"></i></button>
            </div>`;

              return btn;
            }
          }
        ],
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        language: {
          url: `<?php echo constant("URL"); ?>views/js/DataTable.config.json`
        }
      });
    })
  </script>
</body>

</html>