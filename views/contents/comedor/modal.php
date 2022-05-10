<?php
    require_once("./models/m_persona.php");
    $model_person = new m_persona();
    $person = $model_person->Get_Personas();
?>
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
                                <h3 class="card-title">Formulario de Modificación de Comedor</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario" action="<?php echo constant("URL");?>controller/c_comedor.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-sm-12">
                                            <div class="form-group">
                                                <label for="id_comedor">Código del Comedor(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="id_comedor" id="id_comedor" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="nom_comedor">Nombre del Comedor(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="nom_comedor" id="nom_comedor" placeholder="Ingrese el Nombre del Comedor" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3 col-sm-12">
                                            <div class="form-group">
                                                <label for="encargado_comedor">Selecione al Encargado(<span class="text-danger text-md">*</span>)</label>
                                                <select name="encargado_comedor" id="encargado_comedor" class="custom-select">
                                                    <option value="">Seleccione una Persona</option>
                                                    <?php foreach($person as $persona){?>
                                                    <option value="<?php echo $persona['id_person'];?>"><?php echo $persona['nom_person'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="direccion_comedor">Dirección del Comedor(<span class="text-danger text-md">*</span>)</label>
                                                <textarea name="direccion_comedor" class="form-control" maxlength="120" id="direccion_comedor" cols="30" placeholder="Ingrese la Dirección del Comedor" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <input type="hidden" name="ope">
                                    <button type="button" id="btn" onclick="ope.value = this.value" value="Actualizar" class="btn btn-primary"><i class="fas fa-edit"></i> Actualizar</button>
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
            fetch(`<?php echo constant("URL");?>controller/c_comedor.php`, {
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
            nom_comedor:{
                required: true,
                minlength: 3,
            },
            encargado_comedor:{
                required: true,
            },
            direccion_comedor:{
                required: true,
                minlength: 5,
                maxlength: 120,
            }
        },
        messages:{
            nom_comedor:{
                required: "Este Campo NO Puede estar Vacio",
                minlength: "Debe de Contener al Menos 3 caracteres",
            },
            encargado_comedor:{
                required: "Debes de Seleccionar al Encargado del Comedor",
            },
            direccion_comedor:{
                required: "La Dirección del Comedor es Requerida",
                minlength: "Mínimo de 5 Letras",
                maxlength: "Máximo de 120 Letras",
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
