<!-- jQuery -->
<script src="<?php echo constant("URL"); ?>views/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/dist/js/adminlte.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo constant("URL"); ?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo constant("URL"); ?>views/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="<?php echo constant("URL"); ?>views/plugins/select2/js/select2.min.js"></script>
<!-- Moment -->
<script src="<?php echo constant("URL"); ?>views/plugins/moment/moment.min.js"></script>
<!-- InputMask -->
<script src="<?php echo constant("URL"); ?>views/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo constant("URL"); ?>views/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo constant("URL"); ?>views/plugins/toastr/toastr.min.js"></script>
<!-- Vuejs -->
<script src="<?php echo constant("URL"); ?>views/js/vue.min.js"></script>
<script>
	$(document).ready(() => $(".special_select2").select2({
		width: "resolve"
	}));

	$("#viewPassword").on("click", function() {
		$("#password").attr("type", function(index, attr) {
			$("#viewPassword i").toggleClass("fa-eye-slash").toggleClass("fa-eye");
			return attr == "text" ? "password" : "text";
		});
	});

	$("#viewPassword2").on("click", function() {
		$("#password2").attr("type", function(index, attr) {
			$("#viewPassword2 i").toggleClass("fa-eye-slash").toggleClass("fa-eye");
			return attr == "text" ? "password" : "text";
		});
	});

	$("#viewPassword3").on("click", function() {
		$("#code").attr("type", function(index, attr) {
			$("#viewPassword3 i").toggleClass("fa-eye-slash").toggleClass("fa-eye");
			return attr == "text" ? "password" : "text";
		});
	});

	$("#reloadCaptcha").click(function() {
		var captchaImage = $('#captcha').attr('src');
		captchaImage = captchaImage.substring(0, captchaImage.lastIndexOf("?"));
		captchaImage = captchaImage + "?rand=" + Math.random() * 1000;
		$('#captcha').attr('src', captchaImage);
	});

	jQuery.validator.addMethod(
		"lettersonly",
		function(value, e) {
			return (
				this.optional(e) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value)
			);
		},
		"No es un nombre válido"
	);

	jQuery.validator.addMethod(
		"passwordsecure",
		function(value, e) {
			return (
				this.optional(e) ||
				/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/i.test(
					value
				)
			);
		},
		"Contraseña inválida"
	);

	const FreshCatalogo = () => $(`#dataTable`).DataTable().ajax.reload(null, false);

	const Toast = Swal.mixin({
		toast: true,
		position: "top-end",
		showConfirmButton: false,
		timer: 3000
	});

	window.addEventListener("keypress", function(event) {
		if (event.keyCode == 13) {
			if($("#btn")) $("#btn").click();
			if($("#btn_recuperar")) $("#btn_recuperar").click();
			if($("#btn-registrar")) $("#btn-registrar").click();
			if($("#btn-recuperar")) $("#btn-recuperar").click();
			if($("#form-btn__submit")) $("#form-btn__submit").click();
			if ($("#btn")) $("#btn").click();
			event.preventDefault();
		}
	}, false);

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
		}).then(result => {
			if (result.isConfirmed) return true;
			else return false;
		})
	}
</script>
<?php
if (isset($this->code_error)) $this->ObjMessage->printError($this->code_error);
if (isset($this->code_done)) $this->ObjMessage->printMessage($this->code_done);
if (isset($this->url[2])) {
	if ($this->url[2] == "err" || $this->url[2] == "msg") {
		$this->ObjMessage->MensajePersonal([
			'code' => $this->url[2],
			'msg' => $this->url[3]
		]);
	}
}


if (isset($_SESSION['user_id']) && constant("DEV") == false) {
?>
	<script>
		let tiempo_inactividad = 0;
		let tiempo_final = 45;
		// 3 minutos de inactividad

		window.setInterval(() => {
			contador("sum")
			show_alerta();
			if(tiempo_inactividad > tiempo_final) CerrarSession.submit();;
		}, 1000);
		window.onblur = window.onmousemove = () =>{
			if(!Swal.isVisible()) contador("clear");
		}

		function contador(orden) {
			if (orden == "clear") tiempo_inactividad = 0;
			if (orden == "sum") tiempo_inactividad++;
		}

		function show_alerta() {
			if (tiempo_inactividad > 30 && !Swal.isVisible()) {
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