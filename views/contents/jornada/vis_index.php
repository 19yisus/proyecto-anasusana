<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper" id="VueApp">
    <?php
    $this->titleContent = "Catálogo Jornadas";
    require_once("./models/m_persona.php");

    $model_person = new m_persona();
    $person2 = $model_person->Get_Personas();

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
                  <h3 class="card-title">Catálogo de Jornadas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Titulo</th>
                        <th>Cantidad aproximada de beneficiados</th>
                        <th>Fecha para esta jornada</th>
                        <th>Responsable</th>
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
    <?php
    $this->GetComplement("footer");
    $this->GetComplement("scripts");
    require_once("./views/contents/jornada/modal.php");
    ?>
  </div>
  <!-- ./wrapper -->
  <script>
    const consultaDetallada = async (id) => {
      await fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php?ope=Consultar_jornada_detallado&&id_jornada=${id}`)
        .then(response => response.text())
        .then((data) => { 
          $("#content_jornada_detalle").html(data)
        }).catch(error => console.error(error));
    }

    const app = new Vue({
      el: "#VueApp",
      data: {
        id: "",
        titulo: "",
        des: "",
        cant: "",
        menu_id_jornada: "",
        fecha: "",
        responsable: '',
        selectMenu: [{}]
      },
      methods: {
        async Consult(value) {
          await fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php?ope=Consultar_jornada&id_jornada=${value}`)
            .then(response => response.json()).then(({
              data
            }) => {
              const form = document.formulario;
              this.id = data[0].id_jornada;
              this.des = data[0].des_jornada;
              this.cant = data[0].cant_aproximada;
              this.titulo = data[0].titulo_jornada;
              this.responsable = data[0].person_id_responsable
              this.fecha = data[0].fecha_jornada;
              this.menu_id_jornada = data[0].menu_id_jornada;

            })
            .catch(Err => {
              console.error(Err)
            });
        },
        async GetMenu() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Todos_menu`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.selectMenu = data;
            }).catch(error => console.error(error));
        },
      },
      async mounted() {
        await this.GetMenu();
      }
    })

    // const ChangeStatus = async (value, id) => {
    //   const form = document.getElementById(`formSecondary-${id}`);
    //   if (value !== 2) {
    //     form.ope.value = "Desactivar";
    //     form.estatus_menu.value = value;
    //   } else form.ope.value = "Eliminar";

    //   let res = await Confirmar();
    //   if (!res) return false;

    //   const data = new FormData(form);
    //   await fetch(`<?php echo constant("URL"); ?>controller/c_jornada.php`, {
    //       method: "POST",
    //       body: data
    //     }).then(response => response.json())
    //     .then(res => {
    //       Toast.fire({
    //         icon: `${res.data.code}`,
    //         title: `${res.data.message}`
    //       });
    //       FreshCatalogo();
    //     });
    // }

    const Consultar = async (value) => app.Consult(value);

    $(() => {
      $('#dataTable').DataTable({
        ajax: {
          url: "<?php echo constant("URL"); ?>controller/c_jornada.php?ope=Todos_jornada",
          dataSrc: "data",
        },
        columns: [{
            data: "id_jornada"
          },
          {
            data: "titulo_jornada"
          },
          {
            data: "cant_aproximada"
          },
          {
            data: "fecha_jornada",
            render(data) {
              return moment(data).format("DD/MM/YYYY h:mm A")
            }
          },
          {
            data: "cedula_person",
            render(data, type, row) {
              return `${row.tipo_person}-${data} ${row.nom_person}`
            }
          },
          {
            data: "estatus_jornada",
            render: function(data) {
              return (data == 1) ? "Activo" : "Inactivo";
            }
          },
          {
            defaultContent: "",
            render: function(data, type, row, meta) {
              let btn_secondary;
              let estadoBtnEdit;
              if (row.estatus_jornada === "1") {
                estadoBtnEdit = "";
              } else {
                estadoBtnEdit = "disabled";
              }
              let btn = `
            <form method="POST" id="formSecondary-${row.id_jornada}" action="<?php echo constant('URL'); ?>controller/c_jornada.php">
              <input type="hidden" name="id_jornada" value="${row.id_jornada}">
              <input type="hidden" name="estatus_jornada">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_jornada})"><i class="fas fa-edit"></i></button>
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-lg-jornada" onclick="consultaDetallada(${row.id_jornada})"><i class="fas fa-list"></i></button>
            </div>`;

              <?php if (isset($_SESSION['permisos'])) { ?>
                if (<?php echo $_SESSION['permisos']; ?> == 1) btn = ``;
              <?php } ?>

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

</html>