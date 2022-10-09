<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Catálogo Cargos registrados";

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
                    <h3 class="card-title">Catálogo de Cargos</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Estado</th>
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
  require_once("./views/contents/cargo/modal.php");
?>
<script>
  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);
    if(value !== 2){
      form.ope.value = "Desactivar";
      form.estatus_cargo.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_cargo.php`,{
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
    
    await fetch(`<?php echo constant("URL");?>controller/c_cargo.php?ope=Consultar_cargo&id_cargo=${value}`)
    .then( response => response.json()).then( ({data}) => {
      const form = document.formulario;
      form.id_cargo.value = data.id_cargo;
      form.des_cargo.value = data.des_cargo;
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_cargo.php?ope=Todos_cargo",
        dataSrc: "data",
      },
      columns: [
        {data: "id_cargo"},
        {data: "des_cargo"},
        {data: "estatus_cargo",
        render: function(data){
          return (data == 1) ? "Activo" : "Inactivo";
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          let btn_secondary;
          let estadoBtnEdit;
          if(row.estatus_cargo === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_cargo})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_cargo})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_cargo})"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_cargo}" action="<?php echo constant('URL');?>controller/c_cargo.php">
              <input type="hidden" name="id_cargo" value="${row.id_cargo}">
              <input type="hidden" name="estatus_cargo">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_cargo})"><i class="fas fa-edit"></i></button>${btn_secondary}
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
