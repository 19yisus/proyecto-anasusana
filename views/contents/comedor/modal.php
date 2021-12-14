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
                                <h3 class="card-title">Formulario de modificacion de comedor</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario" action="<?php echo constant("URL");?>controller/c_comedor.php" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-sm-12">
                                            <div class="form-group">
                                                <label for="id_comedor">Codigo del comedor(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="id_comedor" id="id_comedor" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-7 col-sm-12">
                                            <div class="form-group">
                                                <label for="nom_comedor">Nombre del comedor(<span class="text-danger text-md">*</span>)</label>
                                                <input type="text" name="nom_comedor" id="nom_comedor" placeholder="Ingrese el nombre del comedor" class="form-control">
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
            status_comedor:{
                required: true,
            }
        },
        messages:{
            nom_comedor:{
                required: "Este campo no puede estar vacio",
                minlength: "Debe de contener al menos 3 caracteres",
            },
            status_comedor:{
                required: "Este campo no puede estar vacio",
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