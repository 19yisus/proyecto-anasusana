<!DOCTYPE html>
<html lang="es">
  <?php $this->GetHeader(); ?>
  <body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
    <div class="wrapper">

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content mt-5">
          <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>
            <div class="error-content">
              <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Página no encontrada.</h3>
              <p>
                No pudimos encontrar la página que estas buscando.
                Has Click aquí para <a href="<?php $this->SetURL('inicio/index'); ?>">Regresar a la vista anterior</a> .
              </p>
            </div>
            <!-- /.error-content -->
          </div>
          <!-- /.error-page -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php $this->GetComplement("footer"); ?>
    </div>
<!-- ./wrapper -->
<?php $this->GetComplement("scripts");?>
</html>
