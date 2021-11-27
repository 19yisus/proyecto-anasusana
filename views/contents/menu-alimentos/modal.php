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
                        <div class="card card-cyan">
                            <div class="card-header">
                                <h3 class="card-title">Formulario de modificacion de productos</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario" action="<?php echo constant("URL");?>controller/c_menu-alimentos.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-sm-12">
                                            <div class="form-group">
                                                <label for="id_producto">Id del producto(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="id_producto" id="id_producto" placeholder="Ingrese el nombre del producto" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="nom_producto">Nombre del producto(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="nom_producto" id="nom_producto" placeholder="Ingrese el nombre del producto" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
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
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="">Valor de medida(<span class="text-danger text-md">*</span>)</label>
                                                <input type="number" name="valor_producto" id="valor_producto" class="form-control" placeholder="Ingrese un valor">
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
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
                                        <div class="col-7 col-sm-12">
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
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <input type="hidden" name="ope">
                                    <button type="button" id="btn" onclick="ope.value = this.value" value="Actualizar" class="btn btn-primary">Actualizar</button>
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
    $("#btn").click( async () =>{
        if($("#formulario").valid()){
            let res = await Confirmar();
            if(!res) return false;

            let datos = new FormData(document.formulario);
            fetch(`<?php echo constant("URL");?>controller/c_menu-alimentos.php`, {
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