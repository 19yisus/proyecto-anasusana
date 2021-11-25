<?php 
    require("./models/m_producto.php");
    $model = new m_producto();
    $productos = $model->Get_todos_productos(1);
?>
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lista de productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-cyan">
                            <div class="card-header">
                                <h3 class="card-title">Productos para esta transaccion</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formulario" name="formulario" method="POST" autocomplete="off" class="needs-validation" novalidate>
                                <div class="card-body" id="caja">
                                    <div class="row d-flex align-items-center" v-for="(item, index) in productos" :key="index">
                                        <div class="col-4">
                                            <div class="form-group d-block">
                                                <label for="id_product">Codigo del producto(<span class="text-danger text-md">*</span>)</label>
                                                <!-- special_select2 lo dejo aca por si acaso -->
                                                <select name="id_product" v-model="productos[index].code" value="" id="" class="custom-select">
                                                    <option value="">Seleccione un producto</option>
                                                    <?php foreach($productos as $item){?>
                                                    <option value="<?php echo $item['id_product'];?>"><?php echo $item['nom_product']; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="cant_product">Cantidad(<span class="text-danger text-md">*</span>)</label>
                                                <input type="number" name="cant_product" min="0" v-model="productos[index].cantidad" :value="item.cantidad" id="cant_product" placeholder="Ingrese la cantidad" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="precio_product">Precio(<span class="text-danger text-md">*</span>)</label>
                                                <input type="number" name="precio_product" min="0" v-model="productos[index].precio" :value="item.precio" id="precio_product" placeholder="Ingrese su precio" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="fecha_vencimiento">Fecha de vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" min="<?php echo $this->DateNow();?>" v-model="productos[index].fecha" :value="item.fecha" id="fecha_vencimiento" placeholder="Ingrese fecha de vencimiento" class="form-control">
                                            </div>
                                        </div>
                                        <button type="button" v-on:click="Disminuir(index)" class="btn btn-danger mt-3">-</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" v-on:click="Duplicar" id="btn_duplicar" class="btn btn-success">Mas productos</button>
                                </div>
                            </form>
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
<script>
    // $("#btn_duplicar").click( () => { $("#caja").children(":first-child").clone().appendTo($("#caja").children(":first-child")) });

    // const PrintContent = async () => {
    //     let cantidad = parseInt($("#cant_ope").val());

    //     if(cantidad == 0){
    //         let modal_datos_product = await fetch("<?php //echo constant("URL");?>views/contents/entradas/modal_datos_product.php")
    //         .then( response => response.text()).then( res => res).catch(Err => console.error(Err));
    //         $(modal_datos_product).attr("id","element-1").appendTo($("#caja"))
    //     }

    //     if(cantidad > 0){

    //     }
    // }

</script>
