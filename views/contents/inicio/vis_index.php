<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">

      <!-- Preloader -->
      <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php //echo constant("URL");?>views/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div> -->

      <?php
        $this->GetComplement("navbar");
        // $this->GetComplement("sidebar");
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
                      <h4 class="text-muted">Software de Inventario y Control de Alimentos para la escuela Ana Susana de Ousset</h4>
                    </div>
                  </div>
                  <div class="col-6">
                     <img src="<?php echo constant('URL');?>views/images/logo.jpg" alt="AdminLTE Logo" style="width:10rem !important;" class="w-12 float-right"> 
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mx-1">
                    <h4>Reseña historica de la escuela Ana Susana de Ousset:</h4>
                    <h6 class="text-justify">La institución fue fundada en el año 1963, en una casa de paredes de bahareque y techo de zinc bajo el nombre de Escuela Pimpinela, para ese entonces contaba con cuatro maestros, entre los cuales se conocen los nombres de Carlina de Rodríguez, Luisa Graterol de Pérez y Alicia de Gavidea; y un obrero. Haciendo una mención especial a la señora Guadalupe Colmenárez, quien fue pionera de la fundación de la escuela.</h6>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mx-1">
                    <h4>Misión de la escuela Ana Susana de Ousset</h4>
                    <h6 class="text-justify">Brindar una educación a los niños, niñas y adolescentes de la educación inicial y primaria con una práctica pedagógica abierta, reflexiva, holística, cualitativa y constructiva; que atienda a los intereses y necesidades de los educandos, permitiendo el desarrollo de su personalidad y fortaleciendo los valores de convivencia, solidaridad, trabajo y responsabilidad.
                    </h6>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="mx-1">
                    <h4>Visión de la escuela Ana Susana de Ousset</h4>
                    <h6 class="text-justify">Lograr la formación de un educando responsable, con conciencia nacional, soberana; que aprecie los valores patrios, sus tradiciones y costumbres ancestrales, en el marco de un enfoque geohistórico, en pro y para el trabajo liberador, que se apropie del desarrollo humanístico y sociable.
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
