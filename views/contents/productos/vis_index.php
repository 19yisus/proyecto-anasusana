<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php 
        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");
        require_once("./models/m_marca.php");
        require_once("./models/m_grupo.php");

        $model_marca = new m_marca();
        $marcas = $model_marca->Get_todos_marcas(1);

        $model_grupo = new m_grupo();
        $grupos = $model_grupo->Get_todos_grupos(1);
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php $this->GetComplement("contentHeader");?>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Catalogo de Productos</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombre</th>
                          <th>Cantidad en stock</th>
                          <th>Marca</th>
                          <th>Grupo</th>
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
          </div><!-- /.container-fluid -->
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
  require_once("./views/contents/productos/modal.php");
?>
<script>
  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);
    if(value !== 2){
      form.ope.value = "Desactivar";
      form.status_producto.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_producto.php`,{
      method: "POST",
      body: data
    }).then(response => response.json())
    .then( res =>{
      Toast.fire({
        icon: `${res.data.code}`,
        title: `${res.data.message}`
      });
      FreshCatalogo();
    });
  }

  const Consultar = async (value) => {
    await fetch(`<?php echo constant("URL");?>controller/c_producto.php?ope=Consultar_producto&id_producto=${value}`)
    .then( response => response.json()).then( res => {
      const form = document.formulario;
      form.id_producto.value = res.data.id_product;
      form.nom_producto.value = res.data.nom_product;
      form.med_producto.value = res.data.med_product;
      form.valor_producto.value = res.data.valor_product;
      form.grupo_id_producto.value = res.data.grupo_id_product;
      form.marca_id_producto.value = res.data.marca_id_product;
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_producto.php?ope=Todos_productos",
        dataSrc: "data",
      },
      columns: [
        {data: "id_product"},
        {data: "nom_product"},
        {data: "stock_product"},
        {data: "nom_marca"},
        {data: "nom_grupo"},
        {data: "status_product", 
        render: function(data){
          return (data == 1) ? "Activo" : "Innactivo";
        }},
        {data: "created_product", 
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          let btn_secondary;
          let estadoBtnEdit;
          if(row.status_product === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_product})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_product})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_product})"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_product}" action="<?php echo constant('URL');?>controller/c_producto.php">
              <input type="hidden" name="id_producto" value="${row.id_product}">
              <input type="hidden" name="status_producto">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_product})"><i class="fas fa-edit"></i></button>${btn_secondary}
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
</html>
