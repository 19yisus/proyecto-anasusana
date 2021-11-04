<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0"><?php echo (isset($this->titleContent) ? $this->titleContent : "Inicio"); ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <?php if($this->controlador !== "inicio"){ ?>
            <li class="breadcrumb-item"><a href="<?php echo constant("URL"). $this->controlador;?>">Listar Registros</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo constant("URL"). $this->controlador;?>/form">Formulario de registros</a></li>
            <?php 
                }else{
            ?>
            <li class="breadcrumb-item"><a href="<?php echo constant("URL"). $this->controlador;?>"><?php echo $this->controlador; ?></a></li>
            <li class="breadcrumb-item active">Proyecto</li>
            <?php }?>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->