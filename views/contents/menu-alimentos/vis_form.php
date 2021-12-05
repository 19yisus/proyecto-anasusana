<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">
      <?php 
        $this->titleContent = "Formulario de registro Menu de alimentos";

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
                    <div class="card card-cyan">
                        <div class="card-header">
                            <h3 class="card-title">Formulario de registro de productos</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formulario" action="<?php echo constant("URL");?>controller/c_menu-alimentos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="nom_producto">Nombre del producto(<span class="text-danger text-md">*</span>)</label>
                                            <input type="text" name="nom_producto" id="nom_producto" placeholder="Ingrese el nombre del producto" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="">Unidad de medida(<span class="text-danger text-md">*</span>)</label>
                                            <select name="med_producto" id="med_producto" class="custom-select">
                                                <option value="">Seleccione una medida</option>
                                                <option value="KL">Kilo gramos</option>
                                                <option value="LT">Litros</option>
                                                <option value="GM">Gramos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="">Valor de medida(<span class="text-danger text-md">*</span>)</label>
                                            <input type="number" name="valor_producto" step="0.01" id="valor_producto" class="form-control" placeholder="Ingrese un valor">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Grupo del producto(<span class="text-danger text-md">*</span>)</label>
                                            <select name="grupo_id_producto" id="grupo_id_producto" class="custom-select">
                                                <option value="">Seleccione una medida</option>
                                                <?php
                                                    foreach($grupos as $grupo){
                                                        ?><option value="<?php echo $grupo['id_grupo'];?>"><?php echo $grupo['nom_grupo'];?></option><?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Marca del producto(<span class="text-danger text-md">*</span>)</label>
                                            <select name="marca_id_producto" id="marca_id_producto" class="custom-select">
                                                <option value="">Seleccione una marca</option>
                                                <?php
                                                    foreach($marcas as $marca){
                                                        ?><option value="<?php echo $marca['id_marca'];?>"><?php echo $marca['nom_marca'];?></option><?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Estado del producto(<span class="text-danger text-md">*</span>)</label>
                                        <div class="row">
                                            <div class="form-check mx-3">
                                                <input type="radio" name="status_producto" id="status_producto" value="1" class="form-check-input" readonly checked>
                                                <label for="status_producto" class="form-check-label">Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="status_producto" id="status_producto" value="0" class="form-check-input" disabled>
                                                <label for="status_producto" class="form-check-label">Innactivo</label>
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
      <?php $this->GetComplement("footer"); ?>
    </div>
<!-- ./wrapper -->
<?php $this->GetComplement("scripts");?>
<script>
    $("#btn").click( async () =>{
        if($("#formulario").valid()){
            let res = await Confirmar();
            if(res) $("#formulario").submit();
        }
    })

    $("#formulario").validate({
        rules:{
            nom_producto:{
                required: true,
                minlength: 3,
            },
            med_producto:{
                required: true,
            },
            valor_producto:{
                required: true,
                number: true,
            },
            grupo_id_producto:{
                required: true
            },
            marca_id_producto:{
                required: true
            }
        },
        messages:{
            nom_producto:{
                required: "Este campo no puede estar vacio",
                minlength: "Debe de contener al menos 3 caracteres",
            },
            med_producto:{
                required: "Debe de seleccionar una opcion",
            },
            valor_producto:{
                required: "Este campo no puede estar vacio",
                number: "Solo se aceptan numeros"
            },
            grupo_id_producto:{
                required: "Debe de seleccionar una opcion"
            },
            marca_id_producto:{
                required: "Debe de seleccionar una opcion"
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
