<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-mini sidebar-collapse layout-footer-fixed text-sm">
    <div class="wrapper">

      <!-- Preloader -->
      <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php //echo constant("URL");?>views/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div> -->

      <?php 
        $this->GetComplement("navbar");
        $this->GetComplement("sidebar");
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php $this->GetComplement("contentHeader");?>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-body">
                
                <div class="row">
                  <div class="col-6">
                    <div class="d-flex flex-column">
                      <h3 class="">Bienvenid@</h3>
                      <h4 class="text-muted">Software de Inventario y Control de Alimentos para el comedor de la “Iglesia Cristiana Pan de Vida”</h4>
                    </div>
                  </div>
                  <div class="col-6">
                    <img src="<?php echo constant('URL');?>views/images/logo.jpeg" alt="AdminLTE Logo" class="w-50 float-right">
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php $this->GetComplement("footer"); ?>
    </div>
<!-- ./wrapper -->
<?php $this->GetComplement("scripts");?>
</html>
