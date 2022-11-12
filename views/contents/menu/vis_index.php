<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper" id="VueApp">
    <?php
    $this->titleContent = "Catálogo Menú de alimentos";

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
                  <h3 class="card-title">Catálogo de Menú</h3>
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
    <?php
    $this->GetComplement("footer");
    $this->GetComplement("scripts");
    require_once("./views/contents/menu/modal.php");
    ?>
  </div>
  <!-- ./wrapper -->
  <script>
    const app = new Vue({
      el: "#VueApp",
      data: {
        id: "",
        des: "",
        productos: [
          // {
          //   id: '',
          //   medida: '',
          //   cantidad: ''
          // }
        ],
        selectProductos: [{}]
      },
      methods: {
        async Consult(value) {
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Consultar_menu&id_menu=${value}`)
            .then(response => response.json()).then(({
              data
            }) => {
              const form = document.formulario;
              console.log(data)
              this.id = data[0].id_menu;
              this.des = data[0].des_menu;

              let res = data[1].map(item => {
                return {
                  'id': item.product_id_menu_detalle,
                  'cantidad': item.consumo,
                  'medida': item.med_product
                }
              });

              this.productos = res;
            })
            .catch(Err => {
              console.error(Err)
            });
        },
        async GetAlimentos() {
          await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Get_alimentos`)
            .then(response => response.json())
            .then(({
              data
            }) => {
              this.selectProductos = data;
            }).catch(error => console.error(error));
        },
        cambio(e) {
          let contador = 0;
          this.productos.forEach(item => {
            if (item.id == e.target.value) contador += 1
          })
          if (contador > 1) {
            $(`#${e.target.id} option[value='']`).attr('selected', true);
            alert("No se pueden duplicar los alimentos")
            return false;
          }
          let {
            med_product
          } = this.selectProductos.filter(item => item.id_product == e.target.value)[0];
          this.productos = this.productos.map(item => {
            if (item.id == e.target.value) item.medida = med_product;
            return item;
          })
        },
        duplicar() {
          this.productos.push({
            id: '',
            medida: '',
            cantidad: ''
          })
        },
        disminuir() {
          this.productos.pop();
        }
      },
      async mounted() {
        await this.GetAlimentos();
      }
    })

    const ChangeStatus = async (value, id) => {
      const form = document.getElementById(`formSecondary-${id}`);
      if (value !== 2) {
        form.ope.value = "Desactivar";
        form.estatus_menu.value = value;
      } else form.ope.value = "Eliminar";

      let res = await Confirmar();
      if (!res) return false;

      const data = new FormData(form);
      await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php`, {
          method: "POST",
          body: data
        }).then(response => response.json())
        .then(res => {
          Toast.fire({
            icon: `${res.data.code}`,
            title: `${res.data.message}`
          });
          FreshCatalogo();
        });
    }

    const Consultar = async (value) => app.Consult(value);

    $(() => {
      $('#dataTable').DataTable({
        ajax: {
          url: "<?php echo constant("URL"); ?>controller/c_menu.php?ope=Todos_menu",
          dataSrc: "data",
        },
        columns: [{
            data: "id_menu"
          },
          {
            data: "des_menu"
          },
          {
            data: "status_menu",
            render: function(data) {
              return (data == 1) ? "Activo" : "Inactivo";
            }
          },
          {
            defaultContent: "",
            render: function(data, type, row, meta) {
              // <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_menu})"></i></button>
              let btn_secondary;
              let estadoBtnEdit;
              if (row.status_menu === "1") {
                estadoBtnEdit = "";
                btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_menu})"><i class="fas fa-power-off"></i></button>`;
              } else {
                estadoBtnEdit = "disabled";
                btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_menu})"><i class="fas fa-power-off"></i></button>`;
              }
              let btn = `
            <form method="POST" id="formSecondary-${row.id_menu}" action="<?php echo constant('URL'); ?>controller/c_menu.php">
              <input type="hidden" name="id_menu" value="${row.id_menu}">
              <input type="hidden" name="estatus_menu">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_menu})"><i class="fas fa-edit"></i></button>${btn_secondary}
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