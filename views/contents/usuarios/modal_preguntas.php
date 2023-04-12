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
                                <h3 class="card-title">Formulario de preguntas de seguridad</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario_2" action="<?php echo constant("URL");?>controller/c_usuario.php" name="formulario_2" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-5 col-sm-12">
                                      <div class="form-group">
                                        <label for="id_pregun">Id pregunta(<span class="text-danger text-md">*</span>)</label>
                                        <input type="text" name="id_pregun" id="id_pregun" class="form-control" readonly>
                                      </div>
                                    </div>
                                    <div class="col-7 col-sm-12">
                                      <div class="form-group">
                                        <label for="des_pregun">Descripción(<span class="text-danger text-md">*</span>)</label>
                                        <input type="text" name="des_pregun" id="" class="form-control">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <!-- Actualizar_preguntas -->
                                    <!-- Save -->
                                    <input type="hidden" name="ope">
                                    <button type="button" id="btn_2" class="btn btn-primary">Actualizar</button>
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
    $("#btn_2").click( async () =>{
        if($("#formulario_2").valid()){
            let res = await Confirmar();
            if(!res) return false;

            let datos = new FormData(document.formulario_2);
            fetch(`<?php echo constant("URL");?>controller/c_usuarios.php`, {
                method: "POST",
                body: datos,
            }).then( response => response.json())
            .then( res =>{
                FreshCatalogo();
                document.formulario_2.reset();
                $("#modal-lg").modal("hide");

                Toast.fire({
                  icon: `${res.data.code}`,
                  title: `${res.data.message}`
                });
            }).catch( Err => console.log(Err))
        }
    })

    $("#formulario_2").validate({
        rules:{
          des_pregun:{
            required: true,
          }
        },
        messages:{
          des_pregun:{
            required: "Debe de ingresar la descripción de la pregunta",
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
