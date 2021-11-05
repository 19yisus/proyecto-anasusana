<!-- jQuery -->
<script src="<?php echo constant("URL");?>views/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Bootstrap 4 -->
<script src="<?php echo constant("URL");?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/chart.js/Chart.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/sparklines/sparkline.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/jquery-knob/jquery.knob.min.js"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
<!-- Summernote -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/summernote/summernote-bs4.min.js"></script> -->
<!-- overlayScrollbars -->
<!-- <script src="<?php //echo constant("URL");?>views/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo constant("URL");?>views/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo constant("URL");?>views/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php //echo constant("URL");?>views/dist/js/pages/dashboard.js"></script> -->
<!-- jquery-validation -->
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
<!-- Moment -->
<script src="<?php echo constant("URL");?>views/plugins/moment/moment.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo constant("URL");?>views/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo constant("URL");?>views/plugins/toastr/toastr.min.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
    });

    const Confirmar = async () => {
        return await Swal.fire({
            title: "Estas seguro de realizar esta operacion?",
            text: "Confirma esta operacion",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, estoy segur@",
        }).then( result =>{
            if(result.isConfirmed) return true; else return false;
        })
    }
</script>
<?php
    require_once("./controller/c_messages.php");

    if(isset($this->code_error)){
        $ObjMessage = new c_messages();
        $ObjMessage->printError($this->code_error);
    }

    if(isset($this->code_done)){
        $ObjMessage = new c_messages();
        $ObjMessage->printMessage($this->code_done);
    }
?>