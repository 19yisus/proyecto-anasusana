<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo constant("URL");?>inicio/index" class="brand-link">
    <img src="<?php echo constant('URL');?>views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo constant('URL');?>views/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo constant("URL");?>inicio/index" class="nav-link <?php $this->IsActive("inicio/index"); ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link <?php $this->IsActive(["grupos/index","grupos/form","marcas/index","personas/index","menu-alimentos/index","menu-alimentos/form"]);?>">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Registros
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo constant("URL");?>grupos/index" class="nav-link  <?php $this->IsActive("grupos/index"); ?>">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>
                  Grupos
                </p>
              </a>    
            </li>
            <li class="nav-item">
              <a href="<?php echo constant("URL");?>marcas/index" class="nav-link  <?php $this->IsActive("marcas/index"); ?>">
                <i class="nav-icon fas fa-bullseye"></i>
                <p>
                  Marcas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo constant("URL");?>personas/index" class="nav-link  <?php $this->IsActive("personas/index"); ?>">
                <i class="nav-icon fas fa-users"></i>
                <!-- <i class="fas fa-people-carry"></i> -->
                <!-- <i class="fas fa-user-friends"></i> -->
                <!-- <i class="fas fa-child"></i> -->
                <p>
                  Personas o Proveedores
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo constant("URL");?>menu-alimentos/index" class="nav-link <?php $this->IsActive("menu-alimentos/index"); ?>">
                <i class="nav-icon fas fa-people-carry"></i>
                <!-- <i class="fas fa-user-friends"></i> -->
                <!-- <i class="fas fa-child"></i> -->
                <p>
                  Menu de alimentos
                </p>
              </a>
            </li>
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
              <a href="<?php echo constant("URL");?>entradas/index" class="nav-link <?php $this->IsActive("entradas"); ?>">
                <i class="nav-item fas fa-hand-holding-medical"></i>
                <p>Entrada de productos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo constant("URL");?>salidas/index" class="nav-link <?php $this->IsActive("salidas"); ?>">
                <i class="nav-item fas fa-cart-arrow-down"></i>
                <p>Salida de productos</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>