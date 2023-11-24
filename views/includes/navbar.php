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
  <div class="container d-flex flex-wrap justify-content-between col-12">
    <a href="<?php $this->SetURL('usuarios/profile'); ?>" class="navbar-brand">
      <img src="<?php echo constant('URL'); ?>views/images/user-icon.png" class="brand-image img-circle elevation-1" style="opacity: .8" alt="User Image">
      <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->

      <a href="<?php $this->SetURL('usuarios/profile'); ?>" class="d-flex flex-column text-white text-bold">
        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Desarrollando"; ?>
        <small class=""><?php echo $_SESSION['nom_rol']; ?></small>
      </a>
    </a>

    <div class="collapse navbar-collapse order-3 col-10" id="navbarCollapse">
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
          <?php 
            if(isset($_SESSION['vistas_permitidas']) && in_array("marcas",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
          ?>
            <li>
              <a href="<?php $this->SetURL('marcas/index'); ?>" class="dropdown-item  <?php $this->IsActive("marcas/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-bullseye"></i>
                  Marcas
                </p>
              </a>
            </li>
          <?php 
            }
            if(isset($_SESSION['vistas_permitidas'][0]) && in_array("productos",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
          ?>
            <li>
              <a href="<?php $this->SetURL('productos/index'); ?>" class="dropdown-item <?php $this->IsActive("productos/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-people-carry"></i>
                  Productos
                </p>
              </a>
            </li>
          <?php 
            }
            if(isset($_SESSION['vistas_permitidas'][0]) && in_array("cargos",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
          ?>
            <li>
              <a href="<?php $this->SetURL('cargo/index'); ?>" class="dropdown-item <?php $this->IsActive("cargo/index"); ?>">
                <p>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width: 12px;">
                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path d="M208 48c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM152 352V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152z" />
                  </svg>
                  Cargos
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("personas",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
            ?>
            <li>
              <a href="<?php $this->SetURL('personas/index'); ?>" class="dropdown-item  <?php $this->IsActive("personas/index"); ?>">
                <p>
                  <i class="nav-icon fas fa-users"></i>
                  Personas o Proveedores
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("menu",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
            ?>
            <li>
              <a href="<?php $this->SetURL('menu/index'); ?>" class="dropdown-item <?php $this->IsActive("menu"); ?>">
                <p>
                  <i class="nav-item fas fa-hand-holding-medical"></i>
                  Menú de alimentos
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("jornada",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
            ?>
            <li>
              <a href="<?php $this->SetURL('jornada/index'); ?>" class="dropdown-item <?php $this->IsActive("jornada/index"); ?>">
                <p>
                  
                  <i class="nav-icon fas fa-people-arrows"></i>
                  Jornada
                </p>
              </a>
            </li>
            <?php 
              }
            ?>
          </ul>
        </li>
        <?php 
          if(
            isset($_SESSION['vistas_permitidas'][0]) && in_array("entradas",$_SESSION['vistas_permitidas']) ||
            isset($_SESSION['vistas_permitidas'][0]) && in_array("salidas",$_SESSION['vistas_permitidas'])  || 
            $_SESSION['permisos'] == '3'
          ){
        ?>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" class="nav-link dropdown-toggle <?php $this->IsActive(["entradas/index", "entradas/form", "salidas/index", "salidas/form"]); ?>">
            <i class="nav-icon fas fa-chart-pie"></i>
            Operaciones
          </a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <?php 
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("entradas",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
            ?>
            <li>
              <a href="<?php $this->SetURL('entradas/index'); ?>" class="dropdown-item <?php $this->IsActive("entradas"); ?>">
                <p>
                  <i class="nav-item fas fa-hand-holding-medical"></i>
                  Entrada de productos
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("salidas",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
            ?>
            <li>
              <a href="<?php $this->SetURL('salidas/index'); ?>" class="dropdown-item <?php $this->IsActive("salidas"); ?>">
                <p>
                  <i class="nav-item fas fa-cart-arrow-down"></i>
                  Salida de productos
                </p>
              </a>
            </li>
            <?php 
              }
            ?>
          </ul>
        </li>
        <?php 
          }
          if(isset($_SESSION['vistas_permitidas'][0]) && in_array("reportes",$_SESSION['vistas_permitidas']) || $_SESSION['permisos'] == '3'){
        ?>
        <li class="nav-item">
          <a href="<?php $this->SetURL('reportes/index'); ?>" class="nav-link <?php $this->IsActive("reportes"); ?>">
            <p>
              <i class="nav-icon fas fa-file-pdf"></i>
              Consulta y Reportes
            </p>
          </a>
        </li>
        <?php 
          }
        ?>
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
                    Usuarios
                  </p>
                </a>
              </li>
              <li>
                <a href="<?php $this->SetURL('usuarios/preguntas'); ?>" class="dropdown-item <?php $this->IsActive("usuarios"); ?>">
                  <p>
                    <i class="nav-icon fas fa-cog"></i>
                    Preguntas de Seguridad
                  </p>
                </a>
              </li>
              <li>
                <a href="<?php $this->SetURL('sistem/index'); ?>" class="dropdown-item <?php $this->IsActive("sistem"); ?>">
                  <p>
                    <i class="nav-icon fas fa-list"></i>
                    Bitacora
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
      <!-- <div class="col-3">
        <img src="<?php //echo constant('URL'); ?>views/images/logo.jpeg" alt="AdminLTE Logo" width="200" class="float-right">
      </div> -->
    </div>
  </div>
</nav>
<form name="CerrarSession" method="POST" action="<?php echo constant("URL"); ?>controller/c_auth.php"><input type="hidden" name="ope" value="Cerrar_Sesion"></form>
<!-- /.navbar -->