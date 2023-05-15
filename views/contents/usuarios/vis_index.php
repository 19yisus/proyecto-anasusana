<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Catálogo de Usuarios";

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
                  <div class="card-header">
                    <h3 class="card-title">Catálogo de Usuarios</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Cédula</th>
                          <th>Nombre</th>
                          <th>Rol</th>
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
  require_once("./views/contents/usuarios/modal.php");
?>
<script>
  
  const app = new Vue({
    el: '#app_vue',
    data:{
      modulos:[
        "marcas",
        "personas",
        "jornada",
        "productos",
        "entradas",
        "salidas",
        "comedor",
        "cargo",
        "menu",
        "reportes",
      ],
      modulosRegistrados:[]
    },
    computed:{
      if_modulo(name){
        let check = false;
        this.modulosRegistrados.forEach(element => {
          console.log(element, name)
          if(element.modulo_name == name){
            check = true;
            return false;
          }
        });
      }
    }
  });
  
  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);

    if(value !== 2){
      form.ope.value = "Desactivar";
      form.status_user.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_usuarios.php`,{
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
    await fetch(`<?php echo constant("URL");?>controller/c_usuarios.php?ope=Consultar_user&id_user=${value}`)
    .then( response => response.json()).then( res => {
      const form = document.formulario;
      form.id_user.value = res.data[0].id_user;
      form.rol_user.value = res.data[0].id_rol;
      app.modulosRegistrados = res.data[1];
      console.log(app.modulosRegistrados)
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_usuarios.php?ope=Todos_users",
        dataSrc: "data",
      },
      columns: [
        {data: "cedula_person"},
        {data: "nom_person"},
        {data: "nom_rol"},
        {data: "status_user",
        render: function(data){
          return (data == 1) ? "Activo" : "Inactivo";
        }},
        {data: "created_user",
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          
          let btn_secondary;
          let estadoBtnEdit;
          if(row.status_user === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_user})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_user})"><i class="fas fa-power-off"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_user}" action="<?php echo constant('URL');?>controller/c_usuarios.php">
              <input type="hidden" name="id_user" value="${row.id_user}">
              <input type="hidden" name="status_user">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_user})"><i class="fas fa-edit"></i></button>${btn_secondary}
            </div>`;

          if(row.nivel_permisos_rol == "3") btn = ``;

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
