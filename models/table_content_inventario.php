<?php 
  $conceptos = [
    'V' => "Vencimiento",
    'R' => "Rechazo",
    'O' => "Cónsumo",
    'C' => "Compra",
    'D' => "Donación",
  ];
  $operaciones = [
    'E' => "Entrada de productos",
    'S' => "Salida de productos",
  ];

  $fecha_inventario = new DateTime($datos_inventario['created_invent']);
?>
<h4>Datos de la operación "<?php echo $operaciones[$datos_inventario['type_operacion_invent']];?>"</h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Código</th>
      <th>Numero de orden</th>
      <th>Concepto de operación</th>
      <th>Cantidad de productos</th>
      <th>Fecha y hora</th>
      <th>Observación</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $this->id_invent;?></td>
      <td><?php echo $datos_inventario['orden_invent'];?></td>
      <td><?php echo $conceptos[$datos_inventario['concept_invent']];?></td>
      <td><?php echo $datos_inventario['cantidad_invent'];?></td>
      <td><?php echo $fecha_inventario->format("d-m-Y h:i a");?></td>
      <td><?php echo $datos_inventario['observacion_invent'];?></td>
    </tr>
  </tbody>
</table>
<h4>Datos del usuario responsable de la operación</h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Cédula</th>
      <th>Nombre</th>
      <th>Contacto</th>
      <th>Rol del usuario</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $datos_usuario['tipo_person']."-".$datos_usuario['cedula_person'];?></td>
      <td><?php echo $datos_usuario['nom_person'];?></td>
      <td><?php echo "telf: (".$datos_usuario['telefono_movil_person'].') Email: '.$datos_usuario['correo_person'];?></td>
      <td><?php echo $datos_usuario['nom_rol'];?></td>
    </tr>
  </tbody>
</table>
<h4>Datos <?php echo ($datos_inventario['type_operacion_invent'] == "E") ? "del Proveedor" : "de quien recibe los productos";?></h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Cédula</th>
      <th>Nombre</th>
      <th>Contacto</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $persona['persona']['tipo_persona']."-".$persona['persona']['cedula'];?></td>
      <td><?php echo $persona['persona']['nom'];?></td>
      <td><?php echo $persona['persona']['telf'];?></td>
    </tr>
  </tbody>
</table>
<?php 
  if(isset($datos_encargado)){
    $fecha_encargado = new DateTime($datos_encargado['created_person']);
?>
<h4>Datos del encargado del comedor</h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Nombre del comedor</th>
      <th>Dirección del comedor</th>
      <th>Encargado del comedor</th>
      <th>Contacto del encargado</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $datos_inventario['nom_comedor'];?></td>
      <td><?php echo $datos_inventario['direccion_comedor'];?></td>
      <td><?php echo $datos_encargado['tipo_person'].'-'.$datos_encargado['cedula_person'].' '.$datos_encargado['nom_person'];?></td>
      <td><?php echo "telf: (".$datos_encargado['telefono_movil_person'].') Email: '.$datos_encargado['correo_person'];?></td>
    </tr>
  </tbody>
</table>
<table class="table table-bordered table-striped">
  <thead class="table-dark">  
    <tr>
      <th>Dirección del encargado</th>
      <th>Telefono de casa</th>
      <th>Fecha de registro en el sistema</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $datos_encargado['direccion_person'];?></td>
      <td><?php echo $datos_encargado['telefono_casa_person'];?></td>
      <td><?php echo $fecha_encargado->format("d-m-Y h:i a");?></td>
    </tr>
  </tbody>
</table>
<?php }?>
<h4>Datos de los productos en esta operación</h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Código</th>
      <th>Descripción</th>
      <th>Medidas</th>
      <th>Precio</th>
      <th>Marca</th>
      <th>Cantidad</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($datos_productos as $producto){?>
      <tr>
        <td><?php echo $producto['id_product'];?></td>
        <td><?php echo $producto['nom_product'];?></td>
        <td><?php echo $producto['valor_product']." ".$producto['med_product'];?></td>
        <td><?php echo $producto['precio_product_ope'];?></td>
        <td><?php echo $producto['nom_marca'];?></td>
        <td><?php echo $producto['detalle_cantidad'];?></td>
      </tr>
    <?php }?>
  </tbody>
</table>