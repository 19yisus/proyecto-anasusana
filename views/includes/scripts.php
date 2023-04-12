<!-- jQuery -->
<script src="<?php echo constant("URL");?>views/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo constant("URL");?>views/dist/js/adminlte.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo constant("URL");?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo constant("URL");?>views/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="<?php echo constant("URL");?>views/plugins/select2/js/select2.min.js"></script>
<!-- Moment -->
<script src="<?php echo constant("URL");?>views/plugins/moment/moment.min.js"></script>
<!-- InputMask -->
<script src="<?php echo constant("URL");?>views/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo constant("URL");?>views/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo constant("URL");?>views/plugins/toastr/toastr.min.js"></script>
<!-- Vuejs -->
<script src="<?php echo constant("URL");?>views/js/vue.min.js"></script>
<script>
    $(document).ready( () => $(".special_select2").select2({ width: "resolve"}) );
    
    const FreshCatalogo = () => $(`#dataTable`).DataTable().ajax.reload(null, false); 
    
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
    });

    const Confirmar = async () => {
        return await Swal.fire({
            title: "Estas seguro de realizar esta operación?",
            text: "Confirma esta operación",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, estoy segur@",
            cancelButtonText: "Cancelar",
        }).then( result =>{
            if(result.isConfirmed) return true; else return false;
        })
    }
</script>
<?php
	if(isset($this->code_error)) $this->ObjMessage->printError($this->code_error);
	if(isset($this->code_done)) $this->ObjMessage->printMessage($this->code_done);

	if(isset($_SESSION['user_id']) && constant("DEV") == false){
		?>
			<script>
				let tiempo_inactividad = 0;
				let tiempo_final = 60; 
				// 3 minutos de inactividad
								
				window.setInterval(() => {
					contador("sum")
					show_alerta();
					if(tiempo_inactividad > tiempo_final) CerrarSession.submit();
				}, 1000);
				window.onblur = window.onmousemove = () =>{
					if(!Swal.isVisible()) contador("clear");
				}

				function contador(orden){
					if(orden == "clear") tiempo_inactividad = 0;
					if(orden == "sum") tiempo_inactividad++;
				}

				function show_alerta(){
					if(tiempo_inactividad > 40 && !Swal.isVisible()){
						Swal.fire({
							title: `Se cerrará la sesión, ¿desea extender la?`,
							showDenyButton: true,
							confirmButtonText: 'Si!',
							denyButtonText: `No`,
						}).then((result) => {

							if (result.isConfirmed) contador("clear");
							if (result.isDenied) CerrarSession.submit();
						})
					}
				}
			</script>
		<?php
	}
?>