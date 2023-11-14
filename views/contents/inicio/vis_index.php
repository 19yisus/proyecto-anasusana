<!DOCTYPE html>
<html lang="es">
<?php $this->GetHeader(); ?>

<body class="hold-transition sidebar-collapse layout-top-nav layout-footer-fixed text-sm">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php //echo constant("URL");
                                            ?>views/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div> -->

    <?php
    $this->GetComplement("navbar");
    // $this->GetComplement("sidebar");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php $this->GetComplement("contentHeader"); ?>
      <!-- Main content -->
      <!-- <section class="content">
          <div class="container-fluid">
            
          </div>
        </section> -->
      <section class="content">
        <div class="div">
          <div class="div-header">
            <div class="div__search">
              <span class="welcome">Hola, <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Desarrollando";?></span></span>
              <div class="search">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg-datos_comunidad">
                  Información sobre la comunidad
                </button>
              </div>
            </div>
            <div class="presentation">
              <div class="presentation__text">
                <h1>Bienvenido(a)</h1>
                <span>al comedor de la escuela </span>
                <span>Ana Susana de Ouset</span>
              </div>
              <div class="description">
                <p>Esta es una sección informativa y resumida de lo más realizado en el sistema</p>
              </div>
              <img src="<?php echo constant('URL');?>views/images/cooking.svg" alt="">
            </div>
          </div>
          <div class="div-products">
            <div class="title-product">
              <h3>Productos más usados</h3>
              <div class="div-btn">
                <img class="slide-button btn-prev" id="btn-prev" src="<?php echo constant('URL');?>views/images/left.png" alt="">
                <img class="slide-button btn-next" id="btn-next" src="<?php echo constant('URL');?>views/images/right.png" alt="">
              </div>
            </div>
            <div class="slider-scrollbar">
              <div class="scrollbar-track">
                <div class="scrollbar-thumb"></div>
              </div>
            </div>
            <div class="product-track">
              <div class="subproduct-track">
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/aceite.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Aceite</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/arroz.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Arroz</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/cebolla.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Cebolla</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/harina.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Harina</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/aceite.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Aceite</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/arroz.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Arroz</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/cebolla.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Cebolla</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
                <div class="card">
                  <div class="imgBx">
                    <img src="<?php echo constant('URL');?>views/images/harina.png" alt="">
                  </div>
                  <div class="card-content">
                    <h2>Harina</h2>
                    <span>Veces usadas: </span> <br>
                    <span>Restantes: </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="registrar-producto">
            <span><a href="">Registrar más productos</a></span>
          </div>

          <div class="div-lastmenu" id="menus_recientes">
            <div class="title-lastmenu">
              <h3 class="title__menu">Menú's agregados recientes</h3>
            </div>
            <div class="menu-track">
              <div class="card-food" v-for="(menu,index) in menus" :key="index">
                <img src="<?php echo constant('URL');?>views/images/menu.png" alt="">
                <h4>{{menu.des_menu}}</h4>
                <div class="btn-more-food">
                  <button class="button-48" @click="get_menu_detalle(menu.id_menu)" role="button"><span class="text">Detalles</span></button>
                </div>
              </div>
            </div>
            
            <div class="registrar-menu">
              <ul style="list-style: none;">
                <li>
                  <span><a href="<?php echo constant('URL');?>menu">Ver más</a></span>
                </li>
                <li>
                  <span><a href="<?php echo constant('URL');?>menu/form">Agregar más menús</a></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-lg-datos_comunidad">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Datos de la comunidad</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Informacion de la Comunidad</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- card body -->
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-10">
                          <h2>Reseña historica de la escuela Ana Susana de Ousset:</h2>
                          <h6 class="text-justify" style="font-size: 23px !important;">La institución fue fundada en el año 1963, en una casa de paredes de bahareque y techo de zinc bajo el nombre de Escuela Pimpinela, para ese entonces contaba con cuatro maestros, entre los cuales se conocen los nombres de Carlina de Rodríguez, Luisa Graterol de Pérez y Alicia de Gavidea; y un obrero. Haciendo una mención especial a la señora Guadalupe Colmenárez, quien fue pionera de la fundación de la escuela.</h6>
                        </div>
                        <div class="col-2">
                          <img src="<?php echo constant('URL');?>views/images/logo.png" alt="AdminLTE Logo" style="width:10rem !important;" class="w-12 float-right"> 
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="mx-1">
                          <h2>Misión de la escuela Ana Susana de Ousset</h2>
                          <h6 class="text-justify" style="font-size: 23px !important;">Brindar una educación a los niños, niñas y adolescentes de la educación inicial y primaria con una práctica pedagógica abierta, reflexiva, holística, cualitativa y constructiva; que atienda a los intereses y necesidades de los educandos, permitiendo el desarrollo de su personalidad y fortaleciendo los valores de convivencia, solidaridad, trabajo y responsabilidad.
                          </h6>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="mx-1">
                          <h2>Visión de la escuela Ana Susana de Ousset</h2>
                          <h6 class="text-justify" style="font-size: 23px !important;">Lograr la formación de un educando responsable, con conciencia nacional, soberana; que aprecie los valores patrios, sus tradiciones y costumbres ancestrales, en el marco de un enfoque geohistórico, en pro y para el trabajo liberador, que se apropie del desarrollo humanístico y sociable.
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.row -->
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>

    <div class="modal fade" id="modal-lg-receta">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Consulta</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Consulta de receta</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- card body -->
                  <div class="card-body">
                    <div class="row" id="content_menu_detalle">
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.row -->
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
      <!-- /.modal -->
    <?php $this->GetComplement("footer");  ?>
  </div>
  <!-- ./wrapper -->
  <?php $this->GetComplement("scripts"); ?>
  <script>
    new Vue({
      el: "#menus_recientes",
      data:function(){
        return {
          menus: []
        }
      },
      methods:{
        get_menus_recientes: async function(){
          await fetch(`<?php echo constant("URL"); ?>controller/c_entrada_salida.php?ope=menus_recientes`)
          .then(response => response.json())
          .then( res => {
            this.menus = res.data;
          })
          .catch(error => console.error(error));
        },
        get_menu_detalle: async function(id){
          await fetch(`<?php echo constant("URL"); ?>controller/c_menu.php?ope=Consultar_menu_detallado&&id_menu=${id}`)
          .then(response => response.text())
          .then((data) => {
            $("#content_menu_detalle").html(data)
            $("#modal-lg-receta").modal("toggle")
          }).catch(error => console.error(error));
        }
      },
      async mounted(){
        await this.get_menus_recientes();
      }
    });
  </script>
</html>