<?php
$jor = $result[0];
$i = $result[1];
?>
<div class="col">
  <h3 class="p-2">Titulo de la jornada: <?php echo $jor['titulo_jornada']; ?></h3>
  <h5 class="p-2"><label for="">Descripción: </label> <?php echo $jor['des_jornada']; ?></h5>
  <h5 class="p-2"><label for="">Cantidad de beneficiados aproximada</label> (<?php echo $jor['cant_aproximada']; ?>)</h5>
  <h5 class="p-2"><label for="">Jornada pautada para la fecha:</label> <?php echo date_format(date_create($jor['fecha_jornada']), "d/m/Y"); ?></h5>
  <h5 class="p-2"><label for="">Menú selecionado:</label> <?php echo $jor['des_menu']; ?></h5>
  <h5 class="p-2"><label for="">Preparación:</label> <?php echo $jor['des_procedimiento']; ?></h5>
  <h5 class="p-2"><label for="">Ingredientes:</label></h5>
  <ul>
    <?php
    foreach ($i as $ix) {
    ?>
      <li>
        <h5>Descripción: <?php echo $ix['nom_product']; ?> | Consumo: <?php echo $ix['consumo'] . $ix['med_comida_detalle']; ?></h5>
      </li>
    <?php
    }
    ?>
  </ul>
</div>