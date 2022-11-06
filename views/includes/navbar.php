<!-- Navbar -->
<!-- <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav> -->
<!-- /.navbar -->

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-dark">
  <div class="container d-flex justify-content-between ">
    <a href="<?php $this->SetURL('inicio/index'); ?>" class="navbar-brand">
      <img src="<?php echo constant('URL'); ?>views/images/user-icon.png" class="brand-image img-circle elevation-1" style="opacity: .8" alt="User Image">
      <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->

      <a href="<?php $this->SetURL('inicio/index'); ?>" class="d-flex flex-column text-white text-bold">
        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Desarrollando"; ?>
        <small class=""><?php echo $_SESSION['nom_rol']; ?></small>
      </a>
    </a>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="<?php $this->SetURL('inicio/index'); ?>" class="nav-link <?php $this->IsActive("inicio/index"); ?>">
            <p> <i class="nav-icon fas fa-home"></i> Inicio</p>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" class="nav-link dropdown-toggle <?php $this->IsActive(["grupos/index", "grupos/form", "marcas/index", "marcas/form", "personas/index", "productos/index", "productos/form", "comedor/index", "comedor/form"]); ?>">
            <i class="nav-icon fas fa-copy"></i>
            Registros
          </a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li>
              <a href="<?php $this->SetURL('marcas/index'); ?>" class="dropdown-item  <?php $this->IsActive("marcas/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-bullseye"></i>
                  Marcas
                </p>
              </a>
            </li>
            <li>
              <a href="<?php $this->SetURL('productos/index'); ?>" class="dropdown-item <?php $this->IsActive("productos/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-people-carry"></i>
                  Productos
                </p>
              </a>
            </li>
            <li>
              <a href="<?php $this->SetURL('cargo/index'); ?>" class="dropdown-item <?php $this->IsActive("cargo/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-people-carry"></i>
                  Cargos
                </p>
              </a>
            </li>
            <li>
              <a href="<?php $this->SetURL('personas/index'); ?>" class="dropdown-item  <?php $this->IsActive("personas/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-users"></i>
                  Personas o Proveedores
                </p>
              </a>
            </li>
            <li>
              <a href="<?php $this->SetURL('comedor/index'); ?>" class="dropdown-item <?php $this->IsActive("comedor/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-house-user"></i>
                  Comedor
                </p>
              </a>
            </li>
            <!-- <li>
              <a href="<?php //$this->SetURL('platillo/index'); ?>" class="dropdown-item <?php //$this->IsActive("platillo/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-house-user"></i>
                  Platillos
                </p>
              </a>
            </li> -->
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" class="nav-link dropdown-toggle <?php $this->IsActive(["entradas/index", "entradas/form", "salidas/index", "salidas/form"]); ?>">
            <i class="nav-icon fas fa-chart-pie"></i>
            Operaciones
          </a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li>
              <a href="<?php $this->SetURL('entradas/index'); ?>" class="dropdown-item <?php $this->IsActive("entradas"); ?>">
                <p>
                  <i class="nav-item fas fa-hand-holding-medical"></i>
                  Entrada de productos
                </p>
              </a>
            </li>
            <li>
              <a href="<?php $this->SetURL('salidas/index'); ?>" class="dropdown-item <?php $this->IsActive("salidas"); ?>">
                <p>
                  <i class="nav-item fas fa-cart-arrow-down"></i>
                  Salida de productos
                </p>
              </a>
            </li>
          </ul>
        </li>
        <?php if (isset($_SESSION) && $_SESSION['permisos'] == 3) { ?>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" class="nav-link dropdown-toggle <?php $this->IsActive(["usuarios/index", "usuarios/form"]); ?>">
              <i class="nav-icon fas fa-cog"></i>
              Configuración
            </a>

            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li>
                <a href="<?php $this->SetURL('usuarios/index'); ?>" class="dropdown-item <?php $this->IsActive("usuarios"); ?>">
                  <p>
                    <i class="nav-icon fas fa-user-cog"></i>
                    usuarios
                  </p>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>

        <li class="nav-item">
          <a href="#" onclick="CerrarSession.submit();" class="nav-link">
            <p>
              <i class="nav-icon fas fa-sign-out-alt"></i>
              Cerrar Sesion
            </p>
          </a>
        </li>
      </ul>
      <div class="col-3">
        <img src="<?php echo constant('URL'); ?>views/images/logo.jpeg" alt="AdminLTE Logo" width="200" class="float-right">
      </div>
    </div>
  </div>
</nav>
<form name="CerrarSession" method="POST" action="<?php echo constant("URL"); ?>controller/c_auth.php"><input type="hidden" name="ope" value="Cerrar_Sesion"></form>
<!-- /.navbar -->