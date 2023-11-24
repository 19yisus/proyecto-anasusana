<?php
$d = $result[0];
$i = $result[1];
?>
<div class="col-12">
  <h3><label for="">Nombre del menú:</label> <?php echo $d['des_menu']; ?></h3>
  <div class="p-2 col-12">
    <h4><label for="">Preparación:</label></h4>
    <p>- <?php echo $d['des_procedimiento']; ?></p>
  </div>

  <h4><label for="">Ingredientes</label></h4>
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