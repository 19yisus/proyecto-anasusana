<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper">
    <?php
    $this->titleContent = "Catálogo de Registros de Productos";

    $this->GetComplement("navbar");
    // $this->GetComplement("sidebar");
    require_once("./models/m_marca.php");

    $model_marca = new m_marca();
    $marcas = $model_marca->Get_todos_marcas(1);
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
                  <h3 class="card-title">Catálogo de Productos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Cantidad en Stock</th>
                        <th>Stock Máximo</th>
                        <th>Marca</th>
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
  require_once("./views/contents/productos/modal.php");
  ?>
  <script>
    document.querySelectorAll("#filtro").forEach(item => {
      item.addEventListener("click", (e) => {
        if (e.target.value == "M") {
          // med_producto_select,mar_producto_select
          $("#select_medidas").hide(150);
          $("#select_marcas").show(150, () => {
            $("#mar_producto_select").removeAttr("disabled");
            $("#med_producto_select").attr("disabled", true);
          })
        }
        if (e.target.value == "U") {
          $("#select_marcas").hide(150);
          $("#select_medidas").show(150, () => {
            $("#med_producto_select").removeAttr("disabled");
            $("#mar_producto_select").attr("disabled", true);
          })
        }

        if (e.target.value == "T") {
          $("#select_medidas").hide(150);
          $("#select_marcas").hide(150);
          $("#med_producto_select").attr("disabled", true);
          $("#mar_producto_select").attr("disabled", true);
        }
      })
    })
    const ChangeStatus = async (value, id) => {
      const form = document.getElementById(`formSecondary-${id}`);
      if (value !== 2) {
        form.ope.value = "Desactivar";
        form.status_producto.value = value;
      } else form.ope.value = "Eliminar";

      let res = await Confirmar();
      if (!res) return false;

      const data = new FormData(form);
      await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php`, {
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

    const Consultar = async (value) => {
      await fetch(`<?php echo constant("URL"); ?>controller/c_productos.php?ope=Consultar_producto&id_producto=${value}`)
        .then(response => response.json()).then(res => {
          const form = document.formulario;
          form.id_producto.value = res.data.id_product;
          form.nom_producto.value = res.data.nom_product;
          form.med_producto.value = res.data.med_product;
          form.valor_producto.value = res.data.valor_product;
          form.stock_maximo_producto.value = res.data.stock_maximo_product;

          if(res.data.marca_id_product !== null){
            $("#marca_id_producto").attr("disabled", false);
            form.marca_id_producto.value = res.data.marca_id_product; 
          } 
          else $("#marca_id_producto").attr("disabled", true);

        })
        .catch(Err => {
          console.error(Err)
        });
    }

    $(() => {
      $('#dataTable').DataTable({
        ajax: {
          url: "<?php echo constant("URL"); ?>controller/c_productos.php?ope=Get_alimentos",
          dataSrc: "data",
        },
        columns: [{
            data: "id_product"
          },
          {
            data: "nom_product"
          },
          {
            data: "stock_product"
          },
          {
            data: "stock_maximo_product"
          },
          {
            data: "nom_marca"
          },
          {
            data: "status_product",
            render: function(data) {
              return (data == 1) ? "Activo" : "Inactivo";
            }
          },
          {
            data: "created_product",
            render: function(data) {
              return moment(data).format("DD/MM/YYYY h:mm A")
            }
          },
          {
            defaultContent: "",
            render: function(data, type, row, meta) {
              let btn_secondary;
              let estadoBtnEdit;
              if (row.status_product === "1") {
                estadoBtnEdit = "";
                btn_secondary = `<button class="btn btn-sm btn-success" onclick="ChangeStatus(0,${row.id_product})"><i class="fas fa-power-off"></i></button>`;
              } else {
                estadoBtnEdit = "disabled";
                btn_secondary = `
            <button type="button" class="btn btn-sm btn-danger" onclick="ChangeStatus(1,${row.id_product})"><i class="fas fa-power-off"></i></button>
            <button type="button" class="btn btn-sm btn-warning"><i class="fas fa-trash" onclick="ChangeStatus(2,${row.id_product})"></i></button>`;
              }
              let btn = `
            <form method="POST" id="formSecondary-${row.id_product}" action="<?php echo constant('URL'); ?>controller/c_productos.php">
              <input type="hidden" name="id_producto" value="${row.id_product}">
              <input type="hidden" name="status_producto">
              <input type="hidden" name="ope">
            </form>
            <div class="btn-group">
              <button type="button" ${estadoBtnEdit} class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-lg" onclick="Consultar(${row.id_product})"><i class="fas fa-edit"></i></button>${btn_secondary}
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