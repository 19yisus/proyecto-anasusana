<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php echo (isset($this->titleContent) ? $this->titleContent : "Inicio"); ?></h1>
            </div><!-- /.col -->
            <?php if($this->controlador !== "reportes"){?>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php if ($this->controlador !== "inicio") { ?>
                        <li class="breadcrumb-item"><a class="btn btn-sm btn-warning" href="<?php $this->SetURL(); ?>"><i class="fas fa-list"></i> Listar Registros</a></li>
                        <!-- SI EL USURIO ES ADMIN PODRA CREAR REGISTROS, SI NO LO ES, ENTONCES EL ENLACE NO APARECERA EN SU PANTALLA -->
                        <?php if (isset($_SESSION['permisos']) && $this->controlador != "usuarios" && $_SESSION['permisos'] >= 2) { ?>
                            <li class="breadcrumb-item active"><a class="btn btn-sm btn-primary" href="<?php $this->SetURL("$this->controlador/form"); ?>"><i class="fas fa-pen"></i> Formulario de registros</a></li>
                        <?php } ?>
                    <?php
                    } else {
                    ?>
                        <li class="breadcrumb-item"><a href="<?php echo constant("URL") . $this->controlador; ?>"><?php echo $this->controlador; ?></a></li>
                        <li class="breadcrumb-item active">Proyecto</li>
                    <?php } ?>
                </ol>
            </div><!-- /.col -->
            <?php }?>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->