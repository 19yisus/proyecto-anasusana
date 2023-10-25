<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Consulta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Formulario de Modificación de Productos</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario" action="<?php echo constant("URL"); ?>controller/c_productos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-sm-12">
                                            <div class="form-group">
                                                <label for="id_producto">Código del Producto(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="id_producto" id="id_producto" placeholder="Ingrese el Código del Producto" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="nom_producto">Nombre del Producto(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="nom_producto" id="nom_producto" placeholder="Ingrese el Nombre del Producto" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Unidad de Medida(<span class="text-danger text-md">*</span>)</label>
                                                <select name="med_producto" id="med_producto" class="custom-select">
                                                    <option value="">Seleccione una Medida</option>
                                                    <option value="KL">Kilo gramos (KL)</option>
                                                    <option value="GM">Gramos (G)</option>
                                                    <option value="LT">Litros (L)</option>
                                                    <option value="ML">Mililitros (ML)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Valor de Medida(<span class="text-danger text-md">*</span>)</label>
                                                <input type="number" name="valor_producto" step="0.01" id="valor_producto" class="form-control" placeholder="Ingrese un Valor">
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Stock Maximo(<span class="text-danger text-md">*</span>)</label>
                                                <input type="number" name="stock_maximo_producto" step="1" id="stock_maximo_producto" class="form-control" placeholder="Ingrese los valores">
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Marca del Producto(<span class="text-danger text-md">*</span>)</label>
                                                <select name="marca_id_producto" id="marca_id_producto" class="custom-select">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php
                                                    foreach ($marcas as $marca) {
                                                    ?><option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nom_marca']; ?></option><?php
                                                                                                                                                        }
                                                                                                                                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <input type="hidden" name="ope">
                                    <button type="button" id="btn" onclick="ope.value = this.value" value="Actualizar" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                        Actualizar</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $("#btn").click(async () => {
        if ($("#formulario").valid()) {
            let res = await Confirmar();
            if (!res) return false;

            let datos = new FormData(document.formulario);
            fetch(`<?php echo constant("URL"); ?>controller/c_productos.php`, {
                    method: "POST",
                    body: datos,
                }).then(response => response.json())
                .then(res => {
                    FreshCatalogo();
                    document.formulario.reset();
                    $("#modal-lg").modal("hide");

                    Toast.fire({
                        icon: `${res.data.code}`,
                        title: `${res.data.message}`
                    });
                }).catch(Err => console.log(Err))
        }
    })

    $("#formulario").validate({
        rules: {
            nom_producto: {
                required: true,
                minlength: 3,
            },
            med_producto: {
                required: true,
            },
            valor_producto: {
                required: true,
                number: true,
            },
            stock_maximo_producto: {
                required: true,
                number: true,
            },
            marca_id_producto: {
                required: true
            }
        },
        messages: {
            nom_producto: {
                required: "Este Campo NO puede estar Vacio",
                minlength: "Debe de Contener al menos 3 Caracteres",
            },
            med_producto: {
                required: "Debe de Seleccionar una Opción",
            },
            valor_producto: {
                required: "Este Campo NO puede estar Vacio",
                number: "Sólo se Aceptan Números"
            },
            stock_maximo_producto: {
                required: "Este Campo NO puede estar Vacio",
                number: "Sólo se Aceptan Números"
            },
            marca_id_producto: {
                required: "Debe de Seleccionar una Opción"
            }
        },
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
</script>