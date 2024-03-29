<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4">
  <!-- Brand Logo -->
  <a href="<?php $this->SetURL('inicio/index'); ?>" class="brand-link">
    <span class="brand-text font-weight-bold mx-auto">ANA SUSANA DE OUSET</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo constant('URL');?>views/images/user-icon.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Desarrollando";?></a>
        <small class="text-white"><?php echo $_SESSION['nom_rol']; ?></small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php $this->SetURL('inicio/index'); ?>" class="nav-link <?php $this->IsActive("inicio/index"); ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link <?php $this->IsActive(["grupos/index","grupos/form","marcas/index","marcas/form","personas/index","productos/index","productos/form","comedor/index","comedor/form"]);?>">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Registros
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <!-- $_SESSION['vistas_permitidas'] -->
          <?php 
            if(isset($_SESSION['vistas_permitidas']) && in_array("marcas",$_SESSION['vistas_permitidas'])){
          ?>
            <li class="nav-item">
              <a href="<?php $this->SetURL('marcas/index'); ?>" class="nav-link  <?php $this->IsActive("marcas/index"); ?>">
                <i class="nav-icon fas fa-bullseye"></i>
                <p>
                  Marcas
                </p>
              </a>
            </li>
          <?php 
            }
            if(isset($_SESSION['vistas_permitidas'][0]) && in_array("productos",$_SESSION['vistas_permitidas'])){
          ?>
            <li class="nav-item">
              <a href="<?php $this->SetURL('productos/index');?>" class="nav-link <?php $this->IsActive("productos/index"); ?>">
                <i class="nav-icon fas fa-people-carry"></i>
                <p>
                  Productos
                </p>
              </a>
            </li>
          <?php 
            }
            if(isset($_SESSION['vistas_permitidas'][0]) && in_array("cargos",$_SESSION['vistas_permitidas'])){
          ?>
            <li class="nav-item">
              <a href="<?php $this->SetURL('cargo/index');?>" class="nav-link <?php $this->IsActive("cargo/index"); ?>">
                <i class="nav-icon fas fa-people-carry"></i>
                <p>
                  Cargos
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("personas",$_SESSION['vistas_permitidas'])){
            ?>
            <li class="nav-item">
              <a href="<?php $this->SetURL('personas/index');?>" class="nav-link  <?php $this->IsActive("personas/index"); ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Personas o Proveedores
                </p>
              </a>
            </li>
            <?php 
              }
              if(isset($_SESSION['vistas_permitidas'][0]) && in_array("comedor",$_SESSION['vistas_permitidas'])){
            ?>
            <li class="nav-item">
              <a href="<?php $this->SetURL('comedor/index');?>" class="nav-link <?php $this->IsActive("comedor/index"); ?>">
                <i class="nav-icon fas fa-house-user"></i>
                <p>
                  Comedor
                </p>
              </a>
            </li>
            <?php 
              }
            ?>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link <?php $this->IsActive(["entradas/index","entradas/form","salidas/index","salidas/form"]);?>">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Operaciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php $this->SetURL('entradas/index');?>" class="nav-link <?php $this->IsActive("entradas"); ?>">
                <i class="nav-item fas fa-hand-holding-medical"></i>
                <p>Entrada de productos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php $this->SetURL('salidas/index');?>" class="nav-link <?php $this->IsActive("salidas"); ?>">
                <i class="nav-item fas fa-cart-arrow-down"></i>
                <p>Salida de productos</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if(isset($_SESSION) && $_SESSION['permisos'] == 3){?>
        <li class="nav-item">
          <a href="#" class="nav-link <?php $this->IsActive(["usuarios/index","usuarios/form"]);?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Configuración
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php $this->SetURL('usuarios/index');?>" class="nav-link <?php $this->IsActive("usuarios"); ?>">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>usuarios</p>
              </a>
            </li>
          </ul>
        </li>
        <?php }?>
        <li class="nav-item">
          <a href="#" onclick="CerrarSession.submit();" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Cerrar Sesion</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<form name="CerrarSession" method="POST" action="<?php echo constant("URL");?>controller/c_auth.php"><input type="hidden" name="ope" value="Cerrar_Sesion"></form>
