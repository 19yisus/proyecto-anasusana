<?php

if (!class_exists("m_db")) require("m_db.php");

class m_platillos extends m_db
{
  private $id_plat, $des_plat, $estatus_plat;
  private $product_id_plat_detalle, $plat_id_detalle, $consumo;

  public function __construct()
  {
    parent::__construct();
    $this->id_plat = $this->des_plat = $this->estatus_plat = null;
    $this->product_id_plat_detalle = $this->plat_id_detalle = $this->consumo = null;
  }

  public function setDatos($d)
  {
    $this->id_plat = isset($d["id_plat"]) ? $this->Clean(intval($d["id_plat"]))  : null;
    $this->des_plat = isset($d["des_plat"]) ? $this->Clean($d["des_plat"]) : null;
    $this->estatus_plat = isset($d["estatus_plat"]) ? $this->Clean($d["estatus_plat"]) : null;
    $this->product_id_plat_detalle = isset($d['comidas']) ? $d['comidas']  : null;
    $this->plat_id_detalle = isset($d["plat_id_detalle"]) ? $this->Clean(intval($d["plat_id_detalle"]))  : null;
    $this->consumo = isset($d["consumo"]) ? $d["consumo"]  : null;
  }

  public function Create()
  {
    try {
      // TRANSACCTION
      $status_transaccion = true;
      $result = $this->Query("SELECT * FROM platillo WHERE des_plat = '$this->des_plat'");
      if ($result->num_rows > 0) return "err/02ERR";

      $this->Start_transacction();
      $sql1 = "INSERT INTO platillo(des_plat, status_plat, created_plat) VALUES('$this->des_plat', 1, NOW());";
      $this->Query($sql1);

      // var_dump($sql1);

      if ($this->Result_last_query()) {
        $id = $this->Returning_id();
        $count = sizeof($this->product_id_plat_detalle);
        for ($i = 0; $i < $count; $i++) {
          $item = $this->product_id_plat_detalle[$i];
          $consumo = $this->consumo[$i];
          $sql2 = "INSERT INTO platillo_detalle(product_id_plat_detalle, plat_id_detalle, consumo) VALUES($item,$id,$consumo)";
          $this->Query($sql2);

          // die($sql2);

          if (!$this->Result_last_query()) {
            $status_transaccion = false;
            die("FINALLL");
            break;
          }
        }
      } else {
        $status_transaccion = false;
        die("FINAL");
        $this->Rollback();
      }

      if ($status_transaccion) {
        $this->End_transacction();
        return "msg/01DONE";
      } else {
        $this->Rollback();
        return "err/01ERR";
      }
    } catch (Exception $e) {
      die("AH OCURRIDO UN ERROR: " . $e->getMessage());
    }
  }

  public function Update()
  {
    $result = $this->Query("SELECT * FROM platillo WHERE des_plat = '$this->des_plat' AND id_plat != $this->id_plat ;");
    if ($result->num_rows > 0) return ["code" => "error", "message" => "Los datos no se pueden duplicar"];

    $sql = "UPDATE platillo SET des_plat = '$this->des_plat' WHERE id_plat = $this->id_plat ;";
    $this->Query($sql);

    $sqlDelete = "DELETE FROM platillo_detalle WHERE plat_id_detalle = $this->id_plat";
    $this->Query($sqlDelete);

    $count = sizeof($this->product_id_plat_detalle);
    for ($i = 0; $i < $count; $i++) {
      $item = $this->product_id_plat_detalle[$i];
      $consumo = $this->consumo[$i];
      $sql2 = "INSERT INTO platillo_detalle(product_id_plat_detalle, plat_id_detalle, consumo) VALUES($item,$this->id_plat,$consumo)";
      $this->Query($sql2);
    }

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Disable()
  {

    $sql = "UPDATE platillo SET status_plat = $this->estatus_plat WHERE id_plat = $this->id_plat ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Delete()
  {
    $sql = "DELETE FROM platillo WHERE id_plat = $this->id_plat AND estatus_plat = '0' ;";
    $this->Query($sql);

    if ($this->Result_last_query()) return ["code" => "success", "message" => "Operación Exitosa"];
    else return ["code" => "error", "message" => "Operación Fallida"];
  }

  public function Get_todos_plat($status = '')
  {
    if ($status != '') $sql = "SELECT * FROM platillo WHERE estatus_plat = $status";
    else $sql = "SELECT * FROM platillo ";
    $results = $this->query($sql);
    return $this->Get_todos_array($results);
  }

  public function Get_plat()
  {
    $sql = "SELECT * FROM platillo WHERE id_plat = $this->id_plat ;";
    $sql2 = "SELECT * FROM platillo_detalle INNER JOIN productos ON id_product = product_id_plat_detalle WHERE plat_id_detalle = $this->id_plat";
    $results = $this->Query($sql);
    $result2 = $this->Query($sql2);
    $datos_generales = $this->Get_array($results);
    $datos_comidas = $this->Get_todos_array($result2);
    return [$datos_generales, $datos_comidas];
  }
}
