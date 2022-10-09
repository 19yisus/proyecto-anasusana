<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php
        $this->titleContent = "Catálogo de Personas";
        require_once './models/m_marca.php';
        require_once './models/m_cargos.php';
        $model_marca = new m_marca();
        $model_cargo = new m_cargos();
        $cargos = $model_cargo->Get_todos_cargo(1);
        $marcas = $model_marca->Get_todos_marcas(1);
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
                    <h3 class="card-title">Catálogo de Personas</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Cédula</th>
                          <th>Nombre y Apellido</th>
                          <th>¿Es Proveedor?</th>
                          <th>Cargo</th>
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
  require_once("./views/contents/personas/modal.php");
?>
<script>
  $("#telefono_movil_persona").inputmask();
  $("#telefono_casa_persona").inputmask();
  
  const app_vue = new Vue({
    el: "#modal-lg",
    data:{
      tipo_persona: "",
      if_proveedor: "",
      marcas: []
    },
    methods:{
      eliminar: function(index){ this.marcas.splice(index, 1) },
      validaRepetidos: function(e){
        let contador = 0;
        this.marcas.forEach( item => { if(parseInt(item.id_marca) == parseInt(e.target.value)) contador += 1})
        if(contador > 1){
          this.marcas[e.target.dataset.index].id_marca = "";
          this.Fn_mensaje_error("No se pueden duplicar las marcas ya seleccionadas!");
        }
      },
      agregar: function(){
        if(this.marcas.length == 0){
          this.marcas.push({id_marca: ''});
          return false;
        }
        if(this.marcas[this.marcas.length -1 ].id_marca != '') this.marcas.push({id_marca: ''});
        else this.Fn_mensaje_error("Selecciona una Marca primero");
      },
      Fn_mensaje_error: function(sms){
        Toast.fire({
          icon: "error",
          title: `${sms}`
        });
      },
      envio: async function(){
        if($("#formulario").valid()){
          let res = await Confirmar();
          if(!res) return false;

          let datos = new FormData(document.formulario);
          fetch(`<?php echo constant("URL");?>controller/c_persona.php`, {
              method: "POST",
              body: datos,
          }).then( response => response.json())
          .then( res =>{
            FreshCatalogo();
            document.formulario.reset();
            $("#modal-lg").modal("hide");

            Toast.fire({
              icon: `${res.data.code}`,
              title: `${res.data.message}`
            });
          }).catch( Err => console.log(Err))
        }
      }
    },
    computed:{
      juridico: function(){
        if(this.tipo_persona == "J" && this.if_proveedor == 1) return true; 
        else{
          this.marcas = [];
          return false;
        }
      }
    }
  });

  const ChangeStatus = async (value, id) => {
    const form = document.getElementById(`formSecondary-${id}`);
    if(value !== 2){
      form.ope.value = "Desactivar";
      form.status_persona.value = value;
    }else form.ope.value = "Eliminar";

    let res = await Confirmar();
    if(!res) return false;

    const data = new FormData(form);
    await fetch(`<?php echo constant("URL");?>controller/c_persona.php`,{
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
    await fetch(`<?php echo constant("URL");?>controller/c_persona.php?ope=Consultar_persona&id_persona=${value}`)
    .then( response => response.json()).then( res => {
      app_vue.tipo_persona = res.data.tipo_person;
      app_vue.if_proveedor = res.data.if_proveedor;
      marcas = res.marcas.map( item =>{
        let array = [];
        array['id_marca'] = item.id_marca
        return array
      });

      app_vue.marcas = marcas;

      const form = document.formulario;
      form.tipo_persona.value = res.data.tipo_person;
      form.if_proveedor.value = res.data.if_proveedor;
      form.if_user.value = res.data.if_user;
      form.id_persona.value = res.data.id_person;
      form.cedula_persona.value = res.data.cedula_person;
      form.nom_persona.value = res.data.nom_person;
      form.sexo_persona.value = res.data.sexo_person;
      form.telefono_movil_persona.value = res.data.telefono_movil_person;
      form.telefono_casa_persona.value = res.data.telefono_casa_person;
      form.correo_persona.value = res.data.correo_person;
      form.direccion_persona.value = res.data.direccion_person;
      form.cargo_id.value = res.data.cargo_id;
      return res;
    })
    .catch( Err => {
      console.error(Err)
    });
  }

  $( () => {
    $('#dataTable').DataTable({
      ajax:{
        url: "<?php echo constant("URL");?>controller/c_persona.php?ope=Todos_personas",
        dataSrc: "data",
      },
      columns: [
        {data: "cedula_person"},
        {data: "nom_person"},
        {data: "if_proveedor",
        render: function(data){
          return (data === "1") ? "Sí es Proveedor" : "No es Proveedor";
        }},
        {data: "des_cargo", 
          render: function(data){
            return (data != null) ? data : "No posee cargo"
          }},
        {data: "status_person",
        render: function(data){
          return (data == "1") ? "Activo" : "Inactivo";
        }},
        {data: "created_person",
        render: function(data){
          return moment(data).format("DD/MM/YYYY h:mm A")
        }},
        {defaultContent: "",
        render: function(data, type, row, meta){
          console.log(row)
          let btn_secondary;
          let estadoBtnEdit;
          if(row.status_person === "1"){
            estadoBtnEdit = "";
            btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_person})"><i class="fas fa-power-off"></i></button>`;
          }else{
            estadoBtnEdit = "disabled";
            btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_person})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_person})"></i></button>`;
          }
          let btn = `
            <form method="POST" id="formSecondary-${row.id_person}" action="<?php echo constant('URL');?>controller/c_persona.php">
              <input type="hidden" name="id_persona" value="${row.id_person}">
              <input type="hidden" name="status_persona">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_person})"><i class="fas fa-edit"></i></button>${btn_secondary}
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
