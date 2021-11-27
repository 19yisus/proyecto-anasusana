<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php 
        $this->titleContent = "Catalogo de salida de productos";
        
        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");
      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" >
        <?php $this->GetComplement("contentHeader");?>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Catalogo de salida de productos / Alimentos</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Codigo</th>
                          <th>Numero de orden</th>
                          <th>Cantidad de productos</th>
                          <th>Estado</th>
                          <th>Creacion</th>
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
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer text-sm">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 3.1.0
        </div>
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
      
    </div>
<!-- ./wrapper -->
<?php 
  $this->GetComplement("scripts");
  require_once("./views/contents/salidas/modal.php");
  // require_once("./views/contents/salidas/modal2.php");
?>
<script>

  const PDF = (id) => {
    alert("Funcion en desarrollo");
  }

  const ListarDatos = (id) => {
    alert("Funcion en desarrollo");
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_entrada_salida.php?ope=Todos_salidas",
        dataSrc: "data",
      },
      columns: [
        {data: "id_invent"},
        {data: "orden_invent"},
        {data: "cantidad_invent"},
        {data: "status_invent", 
        render: function(data){
          return (data == 1) ? "Activo" : "Innactivo";
        }},
        {data: "created_invent", 
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          
          let btn = `
            <div class="btn-group">
              <button title="Imprimr pdf" type="button" class="btn btn-sm btn-danger" onclick="PDF(${row.id_invent})"><i class="fas fa-file-pdf"></i></button>
              <button title="Listar datos" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg-2" onclick="ListarDatos(${row.id_invent})"><i class="fas fa-list"></i></button>
            </div>`;

          return btn;
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
</body>
</html>
