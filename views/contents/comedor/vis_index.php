<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Catálogo Comedor";

        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");
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
                    <h3 class="card-title">Catálogo de Comedores</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Cédula del Encargado</th>
                          <th>Encargado</th>
                          <th>Estado</th>
                          <th>Sede Principal</th>
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
  require_once("./views/contents/comedor/modal.php");
?>
<script>
  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);
    if(value !== 2){
      form.ope.value = "Desactivar";
      form.status_comedor.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_comedor.php`,{
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

  const ExisteSede = async () => {
    return await fetch(`<?php echo constant("URL");?>controller/c_comedor.php?ope=Existe_sede`)
    .then( response => response.json()).then( ({data}) => data).catch( error => {
      console.error(error)
      return false;
    })
  }
  const Consultar = async (value) => {
    let existe_sede = await ExisteSede()

    await fetch(`<?php echo constant("URL");?>controller/c_comedor.php?ope=Consultar_comedor&id_comedor=${value}`)
    .then( response => response.json()).then( ({data}) => {
      const form = document.formulario;
      form.id_comedor.value = data.id_comedor;
      form.nom_comedor.value = data.nom_comedor;
      form.encargado_comedor.value = data.encargado_comedor;
      form.direccion_comedor.value = data.direccion_comedor;
      form.if_sede.value = data.if_sede;

      if(existe_sede){
        if(parseInt(data.if_sede) == 1){
          form.if_sede[0].disabled = false;
          form.if_sede[1].disabled = false;
        }else{
          form.if_sede[0].disabled = true;
          form.if_sede[1].disabled = false;
        }
      }else{
        form.if_sede[0].disabled = false;
        form.if_sede[1].disabled = false;
      }
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_comedor.php?ope=Todos_comedor",
        dataSrc: "data",
      },
      columns: [
        {data: "id_comedor"},
        {data: "nom_comedor"},
        {data: "cedula_person",
        render: function(data, type, row){
          return row.tipo_person+'-'+row.cedula_person
        }},
        {data: "nom_person"},
        {data: "status_comedor",
        render: function(data){
          return (data == 1) ? "Activo" : "Inactivo";
        }},
        {data: "if_sede",
        render: function(data){
          return (data == 1) ? "Si" : "No";
        }},
        {data: "created_comedor",
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          let btn_secondary;
          let estadoBtnEdit;
          if(row.status_comedor === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_comedor})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_comedor})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_comedor})"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_comedor}" action="<?php echo constant('URL');?>controller/c_comedor.php">
              <input type="hidden" name="id_comedor" value="${row.id_comedor}">
              <input type="hidden" name="status_comedor">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_comedor})"><i class="fas fa-edit"></i></button>${btn_secondary}
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
