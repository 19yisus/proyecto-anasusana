<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Configuración (preguntas de seguridad)";

        $this->GetComplement("navbar");
        // $this->GetComplement("sidebar");
        require_once("./models/m_db.php");

      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php $this->GetComplement("contentHeader");?>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-warning">
                  <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Configuración de preguntas de seguridad</h3>
                    <div class="ml-auto">
                      <button type="button" data-toggle="modal" data-target="#modal-lg" onclick="Reset_form()" class="btn btn-sm btn-success font-weight-bold">Nueva pregunta</button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Descripción de la pregunta</th>
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
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php $this->GetComplement("footer"); ?>
    </div>
<!-- ./wrapper -->
<?php
  $this->GetComplement("scripts");
  require_once("./views/contents/usuarios/modal_preguntas.php");
?>
<script>

  const Consultar = async (value) => {
    await fetch(`<?php echo constant("URL");?>controller/c_usuarios.php?ope=Consultar_pregunta&id_pregun=${value}`)
    .then( response => response.json()).then( res => {
      const form = document.formulario_2;
      form.id_pregun.value = res.data.id_pregun;
      form.des_pregun.value = res.data.des_pregun;
      form.ope.value = "Actualizar_preguntas";
      $("#btn_2").text("Actualizar")
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  const Reset_form = () => {
    const form = document.formulario_2;
    form.id_pregun.value = "";
    form.des_pregun.value = "";
    form.ope.value = "Save";
    $("#btn_2").text("Guardar")
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_usuarios.php?ope=Todos_preguntas",
        dataSrc: "data",
      },
      columns: [
        {data: "id_pregun"},
        {data: "des_pregun"},
        {defaultContent: "",
        render: function(data, type, row, meta){
          
          let btn_secondary;
          let estadoBtnEdit;
          let btn = `
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_pregun})"><i class="fas fa-edit"></i></button>
            </div>`;

          if(row.nivel_permisos_rol == "3") btn = ``;

          //return btn;
        }}
      ],
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      language: {
        url: `<?php echo constant("URL");?>views/js/DataTable.config.json`
      }
    });
  })
</script>
</html>
