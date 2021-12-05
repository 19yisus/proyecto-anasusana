<!DOCTYPE html>
<html lang="en">
<?php $this->GetHeader(); ?>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo constant("URL");?>"><b>Iglesia </b>pan de vida</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Recuperacion de contraseña</p>

        <form action="<?php echo constant("URL");?>controller/c_auth.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cedula de la persona">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="<?php echo constant("URL");?>auth/login">Login</a>
        </p>
        <p class="mb-0">
          <a href="<?php echo constant("URL");?>auth/sign_in" class="text-center">Registro de nuevo usuario</a>
        </p>
      </div>
    </div>
  </div>
  <?php $this->GetComplement("scripts"); ?>
</body>
</html>