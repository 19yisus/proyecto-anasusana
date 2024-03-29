<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Catálogo Marcas";
        $this->GetComplement("navbar");
        // $this->GetComplement("sidebar");
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
                  <div class="card-header">
                    <h3 class="card-title">Catálogo de Marcas</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
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
  require_once("./views/contents/marcas/modal.php");
?>
<script>
  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);
    if(value !== 2){
      form.ope.value = "Desactivar";
      form.status_marca.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_marca.php`,{
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
    await fetch(`<?php echo constant("URL");?>controller/c_marca.php?ope=Consultar_marca&id_marca=${value}`)
    .then( response => response.json()).then( res => {
      const form = document.formulario;
      form.id_marca.value = res.data.id_marca;
      form.nom_marca.value = res.data.nom_marca;
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_marca.php?ope=Todos_marcas",
        dataSrc: "data",
      },
      columns: [
        {data: "id_marca"},
        {data: "nom_marca"},
        {data: "status_marca",
        render: function(data){
          return (data == 1) ? "Activo" : "Inactivo";
        }},
        {data: "created_marca",
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          let btn_secondary;
          let estadoBtnEdit;
          if(row.status_marca === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_marca})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_marca})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_marca})"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_marca}" action="<?php echo constant('URL');?>controller/c_marca.php">
              <input type="hidden" name="id_marca" value="${row.id_marca}">
              <input type="hidden" name="status_marca">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_marca})"><i class="fas fa-edit"></i></button>${btn_secondary}
            </div>`;

            <?php if(isset($_SESSION['permisos'])){?>
              if(<?php echo $_SESSION['permisos'];?> == 1) btn = ``;
            <?php }?>

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
