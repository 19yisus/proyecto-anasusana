<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php 
        $this->titleContent = "Registro de marcas";

        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");
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
                    <div class="card card-cyan">
                        <div class="card-header">
                            <h3 class="card-title">Formulario de registro de marcas</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_marca.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="hidden" name="id_marca">
                                            <label for="nom_marca">Nombre de la marca</label>
                                            <input type="text" name="nom_marca" id="nom_marca" placeholder="Ingrese el nombre de la marca" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <label for="">Estado de la marca</label>
                                        <div class="row">
                                            <div class="form-check mx-3">
                                                <input type="radio" name="status_marca" id="status_marca" value="1" class="form-check-input" readonly checked>
                                                <label for="status_marca" class="form-check-label">Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="status_marca" id="status_marca" value="0" class="form-check-input" disabled>
                                                <label for="status_marca" class="form-check-label">Innactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" name="ope">
                                <button type="button" id="btn" onclick="ope.value = this.value" value="Registrar" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            <!--/.col (right) -->
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
<?php $this->GetComplement("scripts");?>
<script>
    $("#btn").click( async () =>{
        if($("#formulario").valid()){
            let res = await Confirmar();
            console.log(res)
            if(res) $("#formulario").submit();
        }
    })

    $("#formulario").validate({
        rules:{
            nom_marca:{
                required: true,
                minlength: 3,
            }
        },
        messages:{
            nom_marca:{
                required: "Este campo no puede estar vacio",
                minlength: "Debe de contener al menos 3 caracteres",
            }
        },
        errorElement: "span",
        errorPlacement: function (error, element){
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        }
    });
</script>
</html>
