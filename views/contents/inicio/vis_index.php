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
                      <h4 class="text-muted">Software de Inventario y Control de Alimentos para el Comedor de la “Iglesia Cristiana Pan de Vida”</h4>
                    </div>
                  </div>
                  <div class="col-6">
                    <img src="<?php echo constant('URL');?>views/images/logo.jpeg" alt="AdminLTE Logo" class="w-50 float-right">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mx-1">
                    <h4>Misión de la Escuela Dominical para Niños:</h4>
                    <h6 class="text-justify">Enseñar, instruir e incentivar a los niños a que aprendan la palabra de Dios y sean buenos cuidadanos en todo lugar.
                      También, crear estrategias para hacer crecer la matrícula, y luego que formen parte de la Iglesia.
                    </h6>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mx-1">
                    <h4>Visión de la Escuela Dominical para Niños:</h4>
                    <h6 class="text-justify">Consolidar la masa total de los niños a una motivación de conocer las Santas Escrituras y mantener una conducta integra
                      en la iglesia, hogar, escuela y comunidad; con el fin de convertir a los niños en futuros Adultos Responsables, educados, respetados y honorables.
                    </h6>
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
